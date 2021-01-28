<?php

namespace AwemaPL\AllegroClient;

use AwemaPL\AllegroClient\User\Sections\Accounts\Models\Account;
use AwemaPL\AllegroClient\User\Sections\Accounts\Repositories\Contracts\AccountRepository;
use AwemaPL\AllegroClient\User\Sections\Accounts\Repositories\EloquentAccountRepository;
use AwemaPL\AllegroClient\User\Sections\Applications\Models\Application;
use AwemaPL\AllegroClient\User\Sections\Accounts\Policies\AccountPolicy;
use AwemaPL\AllegroClient\User\Sections\Applications\Repositories\Contracts\ApplicationRepository;
use AwemaPL\AllegroClient\User\Sections\Applications\Repositories\EloquentApplicationRepository;
use AwemaPL\AllegroClient\Admin\Sections\Settings\Repositories\Contracts\SettingRepository;
use AwemaPL\AllegroClient\Admin\Sections\Settings\Repositories\EloquentSettingRepository;
use AwemaPL\AllegroClient\User\Sections\Accounts\Services\Authorization;
use AwemaPL\AllegroClient\User\Sections\Applications\Policies\ApplicationPolicy;
use AwemaPL\BaseJS\AwemaProvider;
use AwemaPL\AllegroClient\Listeners\EventSubscriber;
use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Middleware\GlobalMiddleware;
use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Middleware\GroupMiddleware;
use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Middleware\Installation;
use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Middleware\RouteMiddleware;
use AwemaPL\AllegroClient\Contracts\AllegroClient as AllegroClientContract;
use Illuminate\Support\Facades\Event;
use AwemaPL\AllegroClient\User\Sections\Accounts\Services\Contracts\Authorization as AuthorizationContract;

class AllegroClientServiceProvider extends AwemaProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Application::class => ApplicationPolicy::class,
        Account::class => AccountPolicy::class,
    ];

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'allegro-client');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'allegro-client');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->bootMiddleware();
        app('allegro-client')->includeLangJs();
        app('allegro-client')->menuMerge();
        app('allegro-client')->mergePermissions();
        $this->registerPolicies();
        Event::subscribe(EventSubscriber::class);
        parent::boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/allegro-client.php', 'allegro-client');
        $this->mergeConfigFrom(__DIR__ . '/../config/allegro-client-menu.php', 'allegro-client-menu');
        $this->app->bind(AllegroClientContract::class, AllegroClient::class);
        $this->app->singleton('allegro-client', AllegroClientContract::class);
        $this->registerRepositories();
        $this->registerServices();
        parent::register();
    }


    public function getPackageName(): string
    {
        return 'allegro-client';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Register and bind package repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bind(ApplicationRepository::class, EloquentApplicationRepository::class);
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
    }

    /**
     * Register and bind package services
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->bind(AuthorizationContract::class, Authorization::class);
    }


    /**
     * Boot middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootMiddleware()
    {
        $this->bootGlobalMiddleware();
        $this->bootRouteMiddleware();
        $this->bootGroupMiddleware();
    }

    /**
     * Boot route middleware
     */
    private function bootRouteMiddleware()
    {
        $router = app('router');
        $router->aliasMiddleware('allegro-client', RouteMiddleware::class);
    }

    /**
     * Boot grEloquentAccountRepositoryoup middleware
     */
    private function bootGroupMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->appendMiddlewareToGroup('web', GroupMiddleware::class);
        $kernel->appendMiddlewareToGroup('web', Installation::class);
    }

    /**
     * Boot global middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootGlobalMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(GlobalMiddleware::class);
    }
}
