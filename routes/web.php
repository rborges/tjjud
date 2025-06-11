<?php

use App\Domains\Book\Controllers\BookController;
use App\Domains\Author\Controllers\AuthorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ReportController;

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', [BookController::class, 'index']);
    $router->get('/{id}', [BookController::class, 'show']);
    $router->post('/', [BookController::class, 'store']);
    $router->put('/{id}', [BookController::class, 'update']);
    $router->delete('/{id}', [BookController::class, 'destroy']);
});

$router->group(['prefix' => 'authors'], function () use ($router) {
    $router->get('/', [AuthorController::class, 'index']);
    $router->get('/{id}', [AuthorController::class, 'show']);
    $router->post('/', [AuthorController::class, 'store']);
    $router->put('/{id}', [AuthorController::class, 'update']);
    $router->delete('/{id}', [AuthorController::class, 'destroy']);
});

$router->group(['prefix' => 'subjects'], function () use ($router) {
    $router->get('/', [SubjectController::class, 'index']);
    $router->get('/{id}', [SubjectController::class, 'show']);
    $router->post('/', [SubjectController::class, 'store']);
    $router->put('/{id}', [SubjectController::class, 'update']);
    $router->delete('/{id}', [SubjectController::class, 'destroy']);
});

$router->get('/report/books-by-author', [ReportController::class, 'booksByAuthor']);
$router->get('/report', [ReportController::class, 'index']);
$router->get('/relatorio/pdf', [ReportController::class, 'exportPdf']);
