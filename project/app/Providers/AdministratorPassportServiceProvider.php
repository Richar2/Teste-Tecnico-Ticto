<?php

namespace App\Providers;

use DateInterval;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\RefreshTokenRepository as RefreshTokenRepositoryContract;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;

class AdministratorPassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $grant = $this->makeAdministratorPasswordGrant();

            $server->enableGrantType(
                $grant,
                new DateInterval('P1Y')
            );
        });
    }

    protected function makeAdministratorPasswordGrant()
    {
        $hasher = app(Hasher::class);

        $userRepository = new UserRepository($hasher, 'administrators');

        $refreshTokenRepositoryContract = app(RefreshTokenRepositoryContract::class);
        $events = app(Dispatcher::class);

        $bridgeRefreshTokenRepository = new RefreshTokenRepository(
            $refreshTokenRepositoryContract,
            $events
        );

        $grant = new PasswordGrant(
            $userRepository,
            $bridgeRefreshTokenRepository
        );

        $grant->setRefreshTokenTTL(new DateInterval('P1Y'));

        return $grant;
    }
}