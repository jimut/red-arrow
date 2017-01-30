<?php

namespace App\Grant;

use App\User;
use App\SocialAccount;
use Validator;
use DateInterval;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\RequestEvent;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Laravel\Passport\Bridge\User as PassportBridgeUser;
use Laravel\Passport\Client;
use Psr\Http\Message\ServerRequestInterface;

class SocialGrant extends AbstractGrant
{
    public function __construct(
        UserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->setUserRepository($userRepository);
        $this->setRefreshTokenRepository($refreshTokenRepository);

        $this->refreshTokenTTL = new DateInterval('P1M');
    }

    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ) {
        $client = $this->validateClient($request);
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request));
        $user = $this->validateUser($request, $client);

        $scopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client, $user->getIdentifier());

        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $user->getIdentifier(), $scopes);
        $refreshToken = $this->issueRefreshToken($accessToken);

        $responseType->setAccessToken($accessToken);
        $responseType->setRefreshToken($refreshToken);

        return $responseType;
    }

    protected function validateClient(ServerRequestInterface $request)
    {
        $passportBridgeClient = parent::validateClient($request);

        $clientId = $this->getRequestParameter('client_id', $request);
        $client = Client::find($clientId);
        if (!$client->firstParty()) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::CLIENT_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidClient();
        }

        return $passportBridgeClient;
    }

    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $provider = $this->getRequestParameter('provider', $request);
        if (is_null($provider)) {
            throw OAuthServerException::invalidRequest('provider');
        }

        $providerUserId = $this->getRequestParameter('provider_user_id', $request);
        if (is_null($providerUserId)) {
            throw OAuthServerException::invalidRequest('provider_user_id');
        }

        $email = $this->getRequestParameter('email', $request);
        if (is_null($email)) {
            throw OAuthServerException::invalidRequest('email');
        }

        $name = $this->getRequestParameter('name', $request);
        if (is_null($name)) {
            throw OAuthServerException::invalidRequest('name');
        }

        $user = $this->getUserEntityBySocialProviderCredentials(
            $provider,
            $providerUserId,
            $email,
            $name
        );
        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidCredentials();
        }

        return $user;
    }

    protected function getUserEntityBySocialProviderCredentials($provider, $providerUserId, $email, $name)
    {
        $account = SocialAccount::where([
            ['provider', $provider],
            ['provider_user_id', $providerUserId]
        ])->first();

        if ($account) {
            return new PassportBridgeUser($account->user->getAuthIdentifier());
        }

        $account = new SocialAccount([
            'provider' => $provider,
            'provider_user_id' => $providerUserId
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $email,
                'name' => $name
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return new PassportBridgeUser($user->getAuthIdentifier());
    }

    public function getIdentifier()
    {
        return 'social';
    }
}
