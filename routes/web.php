<?php

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'BookController@index');
    $router->get('/{id}', 'BookController@show');
    $router->post('/', 'BookController@store');
    $router->put('/{id}', 'BookController@update');
    $router->delete('/{id}', 'BookController@destroy');
});

$router->group(['prefix' => 'authors'], function () use ($router) {
    $router->get('/', 'AuthorController@index');
    $router->get('/{id}', 'AuthorController@show');
    $router->post('/', 'AuthorController@store');
    $router->put('/{id}', 'AuthorController@update');
    $router->delete('/{id}', 'AuthorController@destroy');
});

$router->group(['prefix' => 'subjects'], function () use ($router) {
    $router->get('/', 'SubjectController@index');
    $router->get('/{id}', 'SubjectController@show');
    $router->post('/', 'SubjectController@store');
    $router->put('/{id}', 'SubjectController@update');
    $router->delete('/{id}', 'SubjectController@destroy');
});

$router->get('/report/books-by-author', 'ReportController@booksByAuthor');

$router->get('/report', 'ReportController@index');
$router->get('/relatorio/pdf', 'ReportController@exportPdf');
