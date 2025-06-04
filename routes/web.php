<?php

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'BookController@index');
    $router->get('/{id}', 'BookController@show');
    $router->post('/', 'BookController@store');
    $router->put('/{id}', 'BookController@update');
    $router->delete('/{id}', 'BookController@destroy');
});
