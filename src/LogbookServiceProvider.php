<?php

namespace AryehRaber\Logbook;

use Illuminate\Routing\Router;
use Statamic\Facades\Utility;
use Statamic\Providers\AddonServiceProvider;

class LogbookServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'logbook';

    protected $scripts = [
        __DIR__.'/../resources/js/logbook.js'
    ];

    public function bootAddon()
    {
        Utility::extend(function () {
            Utility::register('logbook')
                ->title(__('Logbook'))
                ->icon('book-pages')
                ->description(__('Manage and view log files.'))
                ->routes(function (Router $router) {
                    $router->get('/', [LogbookController::class, 'show'])->name('show');
                    $router->delete('/delete', [LogbookController::class, 'destroy'])->name('destroy');
                });
        });
    }
}
