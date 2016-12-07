<?php

namespace codeFin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\codeFin\Repositories\MyModelRepository::class, \codeFin\Repositories\MyModelRepositoryEloquent::class);
        $this->app->bind(\codeFin\Repositories\BankRepository::class, \codeFin\Repositories\BankRepositoryEloquent::class);
        $this->app->bind(\codeFin\Repositories\BankAccountRepository::class, \codeFin\Repositories\BankAccountRepositoryEloquent::class);
        $this->app->bind(\codeFin\Repositories\BankAccountRepository::class, \codeFin\Repositories\BankAccountRepositoryEloquent::class);
        //:end-bindings:
    }
}
