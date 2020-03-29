<?php

namespace AryehRaber\Logbook;

use Statamic\Facades\Utility;
use Illuminate\Routing\Router;
use Statamic\Providers\AddonServiceProvider;

class LogbookServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../resources/js/logbook.js'
    ];

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'logbook');

        Utility::make('logbook')
            ->title(__('Logbook'))
            ->icon('book-pages')
            ->description(__('Manage and view log files.'))
            ->routes(function (Router $router) {
                $router->get('/', [LogbookController::class, 'show'])->name('show');
                $router->delete('/delete', [LogbookController::class, 'destroy'])->name('destroy');
            })
            ->register();
    }
}
