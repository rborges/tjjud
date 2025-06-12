<?php

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'App\Domains\Book\Controllers\BookController@index');
    $router->get('/{id}', 'App\Domains\Book\Controllers\BookController@show');
    $router->post('/', 'App\Domains\Book\Controllers\BookController@store');
    $router->put('/{id}', 'App\Domains\Book\Controllers\BookController@update');
    $router->delete('/{id}', 'App\Domains\Book\Controllers\BookController@destroy');
});

$router->group(['prefix' => 'authors'], function () use ($router) {
    $router->get('/', 'App\Domains\Author\Controllers\AuthorController@index');
    $router->get('/{id}', 'App\Domains\Author\Controllers\AuthorController@show');
    $router->post('/', 'App\Domains\Author\Controllers\AuthorController@store');
    $router->put('/{id}', 'App\Domains\Author\Controllers\AuthorController@update');
    $router->delete('/{id}', 'App\Domains\Author\Controllers\AuthorController@destroy');
});

$router->group(['prefix' => 'subjects'], function () use ($router) {
    $router->get('/', 'App\Domains\Subject\Controllers\SubjectController@index');
    $router->get('/{id}', 'App\Domains\Subject\Controllers\SubjectController@show');
    $router->post('/', 'App\Domains\Subject\Controllers\SubjectController@store');
    $router->put('/{id}', 'App\Domains\Subject\Controllers\SubjectController@update');
    $router->delete('/{id}', 'App\Domains\Subject\Controllers\SubjectController@destroy');
});

$router->group(['prefix' => 'report'], function () use ($router) {
    $router->get('/', 'App\Domains\Report\Controllers\ReportController@index');
    $router->get('/books-by-author', 'App\Domains\Report\Controllers\ReportController@booksByAuthor');
    $router->get('/pdf', 'App\Domains\Report\Controllers\ReportController@exportPdf');
});
