<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Book\Services\Contracts\BookServiceInterface;
use App\Domains\Book\Services\BookService;
use App\Domains\Book\Repositories\Contracts\BookRepositoryInterface;
use App\Domains\Book\Repositories\BookRepository;

use App\Domains\Author\Services\Contracts\AuthorServiceInterface;
use App\Domains\Author\Services\AuthorService;
use App\Domains\Author\Repositories\Contracts\AuthorRepositoryInterface;
use App\Domains\Author\Repositories\AuthorRepository;
use App\Domains\Report\Repositories\Contracts\ReportRepositoryInterface;
use App\Domains\Report\Repositories\ReportRepository;
use App\Domains\Report\Services\Contracts\ReportServiceInterface;
use App\Domains\Report\Services\ReportService;
use App\Domains\Subject\Services\Contracts\SubjectServiceInterface;
use App\Domains\Subject\Services\SubjectService;
use App\Domains\Subject\Repositories\Contracts\SubjectRepositoryInterface;
use App\Domains\Subject\Repositories\SubjectRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra os serviços da aplicação.
     *
     * @return void
     */
    public function register()
    {
        // Book
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);

        // Author
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);

        // Subject
        $this->app->bind(SubjectServiceInterface::class, SubjectService::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);

        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
    }
}
