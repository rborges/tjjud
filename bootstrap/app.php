<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->register(Illuminate\Validation\ValidationServiceProvider::class);
$app->withFacades();
$app->withEloquent();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->configure('app');

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

$app->register(App\Providers\AppServiceProvider::class);
$app->register(Barryvdh\DomPDF\ServiceProvider::class);

$app->router->group([
    'namespace' => null,
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
