<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerBindings()
    {
        $this->app->bind(UserRepository::class, function (){

            $repository = new EloquentUserRepository(new User());

            return $repository;

        });
    }
}
