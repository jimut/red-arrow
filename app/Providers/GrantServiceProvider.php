<?php

namespace App\Providers;

use App\Grant\RegisterGrant;
use App\Grant\SocialGrant;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use League\OAuth2\Server\AuthorizationServer;

class GrantServiceProvider extends PassportServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $server = $this->app->make(AuthorizationServer::class);
        
        $server->enableGrantType(
            $this->makeRegisterGrant(), Passport::tokensExpireIn()
        );

        $server->enableGrantType(
            $this->makeSocialGrant(), Passport::tokensExpireIn()
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function makeRegisterGrant() 
    {
        $grant = new RegisterGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeSocialGrant()
    {
        $grant = new SocialGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
