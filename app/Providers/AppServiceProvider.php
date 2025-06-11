<?php

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\SubjectRepository;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\Contracts\AuthorServiceInterface;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\SubjectServiceInterface;
use App\Services\SubjectService;
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
        $this->app->bind(
            \App\Domains\Book\Services\Contracts\BookServiceInterface::class,
            \App\Domains\Book\Services\BookService::class
        );

        $this->app->bind(
            \App\Domains\Book\Repositories\Contracts\BookRepositoryInterface::class,
            \App\Domains\Book\Repositories\BookRepository::class
        );


        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);

        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(SubjectServiceInterface::class, SubjectService::class);
    }
}
