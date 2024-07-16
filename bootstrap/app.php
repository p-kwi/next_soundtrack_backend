<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Header;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'admin' => Admin::class,
      'header' => Header::class
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (Throwable $e) {

      if ($e instanceof ModelNotFoundException) {
        return response()->json([
          'status' => 404,
          'message' => 'Music is not available.'
        ], 404);
      }
    });
  })->create();
