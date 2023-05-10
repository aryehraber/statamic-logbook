<?php

namespace AryehRaber\Logbook;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;
use Statamic\Http\Controllers\Controller;

class LogbookController extends Controller
{
    public function show(Request $request, LaravelLogViewer $logviewer)
    {
        if ($file = $request->log) {
            $logviewer->setFile(urldecode($file));
        }

        if ($request->has('download')) {
            return response()->download($logviewer->pathToLogFile(urldecode($file)));
        }

        return view('logbook::show', [
            'logs' => $this->sanitize($logviewer->all() ?? []),
            'files' => $logviewer->getFiles(true),
            'currentFile' => $logviewer->getFileName(),
        ]);
    }

    public function destroy(Request $request, LaravelLogViewer $logviewer)
    {
        if (! $file = $request->log) {
            return redirect(cp_route('utilities.logbook.show'));
        }

        File::delete($logviewer->pathToLogFile(urldecode($file)));

        return redirect(cp_route('utilities.logbook.show'))->with('success', 'Log file deleted.');
    }

    protected function sanitize(array $log)
    {
        return array_map(function ($val) {
            return str_replace(['{{', '}}'], ['&#123;&#123;', '&#125;&#125;'], $val);
        }, $log);
    }
}
