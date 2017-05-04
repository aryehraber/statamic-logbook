<?php

namespace Statamic\Addons\Logbook;

use Statamic\Extend\Controller;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class LogbookController extends Controller
{
    public function index()
    {
        if (! auth()->check()) {
            return redirect('/');
        }

        if ($file = request('log')) {
            LaravelLogViewer::setFile(base64_decode($file));
        }

        if ($file = request('dl')) {
            return response()->download(LaravelLogViewer::pathToLogFile(base64_decode($file)));
        }

        if ($file = request('del')) {
            app('files')->delete(LaravelLogViewer::pathToLogFile(base64_decode($file)));
            
            return redirect(request()->url());
        }

        if (request()->has('delall')) {
            foreach (LaravelLogViewer::getFiles(true) as $file) {
                app('files')->delete(LaravelLogViewer::pathToLogFile($file));
            }

            return redirect(request()->url());
        }

        $data = [
            'logs' => LaravelLogViewer::all(),
            'files' => LaravelLogViewer::getFiles(true),
            'current_file' => LaravelLogViewer::getFileName(),
            'action_path' => strtolower('/'.CP_ROUTE.'/addons/'.$this->getAddonName()),
        ];

        return $this->view('index', $data);
    }
}
