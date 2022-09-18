<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use App\Repositories\Eloquent\EloquentPostRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\PostRepository;
use App\Repositories\RoleRepository;
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

        $this->app->bind(RoleRepository::class, function (){

            $repository = new EloquentRoleRepository(new Role());

            return $repository;

        });

        $this->app->bind(CategoryRepository::class, function (){

            $repository = new EloquentCategoryRepository(new Category());

            return $repository;

        });

        $this->app->bind(PostRepository::class, function (){

            $repository = new EloquentPostRepository(new Post());

            return $repository;

        });
    }
}
