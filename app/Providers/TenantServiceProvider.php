<?php

namespace App\Providers;

use App\Console\Commands\Tenant\Migrate;
use App\Console\Commands\Tenant\MigrateRollback;
use App\Console\Commands\Tenant\Seed;
use App\Tenant\Cache\TenantCacheManager;
use App\Tenant\Database\DatabaseManager;
use App\Tenant\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;


class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Migrate::class, function($app){

            return new Migrate($app->make('migrator'),$app->make(Dispatcher::class),$app->make(DatabaseManager::class));
        });

        $this->app->singleton(MigrateRollback::class, function($app){

            return new MigrateRollback($app->make('migrator'), $app->make(DatabaseManager::class));
        });

        $this->app->singleton(Seed::class, function($app){

            return new Seed($app->make('db'), $app->make(DatabaseManager::class));
        });

        $this->app->extend('cache', function(){

            return new TenantCacheManager($this->app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Manager::class, function(){
            return new Manager();
        });

        Request::macro('tenant',function(){
            return app(Manager::class)->getTenant();
        });

        Blade::if('tenant',function(){
            return app(Manager::class)->hasTenant();
        });
    }
}
