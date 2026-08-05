<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'vendor.approved'   => \App\Http\Middleware\VendorApproved::class,
            'supply_chain.only' => \App\Http\Middleware\SupplyChainOnly::class,
            'engineer.only'     => \App\Http\Middleware\EngineerOnly::class,
            'planner.only'      => \App\Http\Middleware\PlannerOnly::class,
            'gudang.only'       => \App\Http\Middleware\GudangOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
