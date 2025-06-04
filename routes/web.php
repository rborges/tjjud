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
