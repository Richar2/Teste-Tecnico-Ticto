<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use DateInterval;

class EmployeePassportServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        $this->app->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $grant = $this->makeEmployeePasswordGrant();

            $server->enableGrantType(
                $grant,
                new DateInterval('P1Y')
            );
        });
    }

    protected function makeEmployeePasswordGrant()
    {
        $userRepository = new UserRepository; 
        $refreshTokenRepository = new RefreshTokenRepository;

        $grant = new PasswordGrant(
            $userRepository,
            $refreshTokenRepository
        );

        $grant->setRefreshTokenTTL(new DateInterval('P1Y'));

        return $grant;
    }

}
