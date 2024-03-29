@extends('statamic::layout')
@section('title', Statamic::crumb(__('Logbook'), __('Utilities')))
@section('wrapper_class', 'max-w-full')

@section('content')

    <header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <h1>{{ __('Logbook') }}</h1>
    </header>

    @if(count($files))
        <div class="card mb-2">
            <div class="flex items-center justify-between">
                <form class="flex" method="GET" action="{{ cp_route('utilities.logbook.show') }}">
                    <div class="select-input-container">
                        <select class="select-input" name="log">
                            @foreach($files as $file)
                                <option value="{{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}" @if($file === $currentFile) selected @endif>{{ $file }}</option>
                            @endforeach
                        </select>

                        <div class="select-input-toggle">
                            <svg-icon name="micro/chevron-down-xs" class="w-2"></svg-icon>
                        </div>
                    </div>
                </form>

                @if($currentFile)
                    <div class="flex items-center">
                        @if(count($files))
                            <form class="flex" method="GET" action="{{ cp_route('utilities.logbook.show') }}">
                                <input type="hidden" name="download">

                                <button class="btn-primary" name="log" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($currentFile) }}">{{ __('Download Log') }}</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ cp_route('utilities.logbook.destroy') }}">
                            @csrf
                            @method('delete')

                            <button class="btn-danger ml-2" name="log" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($currentFile) }}" data-delete>{{ __('Delete Log') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="card p-0">
            <div class="w-full overflow-auto">
                <table class="data-table">
                    <thead class="pb-1">
                        <th>{{ __('Level') }}</th>
                        <th>{{ __('Context') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Content') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                            <tr @if($log['stack']) style="cursor: zoom-in;" data-expandable @endif>
                                <td style="min-width: 120px; vertical-align: top;">{{ $log['level'] }}</td>
                                <td style="min-width: 120px; vertical-align: top;">{{ $log['context'] }}</td>
                                <td style="min-width: 200px; vertical-align: top;">{{ $log['date'] }}</td>
                                <td class="w-full font-mono text-xs">
                                    {{ $log['text'] }}

                                    @if($log['in_file'])) <br>{{ $log['in_file'] }} @endif

                                    @if($log['stack']) <div class="hidden whitespace-pre-wrap" data-stack>{{ trim($log['stack']) }}</div> @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>No log files found.</p>
    @endif

@stop
