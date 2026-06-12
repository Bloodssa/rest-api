<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // handle 404 not found to return json
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                "message" => 'The requested resource could not be found.'
            ], 404);
        });

        // auth exeption handler
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if($request->is("api/*")) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 201);
            }
        });
    })->create();
