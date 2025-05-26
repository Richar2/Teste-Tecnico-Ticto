<?php
namespace App\Providers;

use DateInterval;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\RefreshTokenRepository as RefreshTokenRepositoryContract;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;

class EmployeePassportServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

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

        $hasher = app(\Illuminate\Contracts\Hashing\Hasher::class);

        $userRepository = new \Laravel\Passport\Bridge\UserRepository($hasher, 'employees');
    
        $refreshTokenRepositoryContract = app(\Laravel\Passport\RefreshTokenRepository::class);
        $events = app(\Illuminate\Contracts\Events\Dispatcher::class);
    
        $bridgeRefreshTokenRepository = new \Laravel\Passport\Bridge\RefreshTokenRepository(
            $refreshTokenRepositoryContract, 
            $events                         
        );
    
        $grant = new \League\OAuth2\Server\Grant\PasswordGrant(
            $userRepository,
            $bridgeRefreshTokenRepository
        );
    
        $grant->setRefreshTokenTTL(new \DateInterval('P1Y'));
    
        return $grant;
    }
}
