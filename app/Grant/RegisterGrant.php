<?php

namespace App\Grant;

use App\User;
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

class RegisterGrant extends AbstractGrant
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

    protected function validateClient(ServerRequestInterface $request) {
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
        $name = $this->getRequestParameter('name', $request);
        if (is_null($name)) {
            throw OAuthServerException::invalidRequest('name');
        }

        $email = $this->getRequestParameter('email', $request);
        if (is_null($email)) {
            throw OAuthServerException::invalidRequest('email');
        }

        $password = $this->getRequestParameter('password', $request);
        if (is_null($password)) {
            throw OAuthServerException::invalidRequest('passowrd');
        }

        $user = $this->getUserEntityByUserCredentials(
            $name,
            $email,
            $password
        );
        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidCredentials();
        }

        return $user;
    }

    protected function getUserEntityByUserCredentials($name, $email, $password) {
        if (is_null($model = config('auth.providers.users.model'))) {
            throw new RuntimeException('Unable to determine user model from configuration.');
        }

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        $validator = Validator::make($userData, $rules);

        if ($validator->fails()) {
            throw OAuthServerException::accessDenied($validator->errors()->all());
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        if (!$user) {
            return;
        }

        return new PassportBridgeUser($user->getAuthIdentifier());
    }

    public function getIdentifier()
    {
        return 'register';
    }
}