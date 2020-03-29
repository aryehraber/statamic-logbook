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
                    <div class="select-input-container relative">
                        <select class="pr-4" name="log">
                            @foreach($files as $file)
                                <option value="{{ urlencode($file) }}" @if($file === $currentFile) selected @endif>{{ $file }}</option>
                            @endforeach
                        </select>

                        <svg-icon name="chevron-down-xs" class="absolute pin-y pin-r w-2 h-full mr-1.5 pointer-events-none"></svg-icon>
                    </div>
                </form>

                @if($currentFile)
                    <div class="flex items-center">
                        @if(count($files))
                            <form class="flex" method="GET" action="{{ cp_route('utilities.logbook.show') }}">
                                <input type="hidden" name="download">

                                <button class="btn-primary" name="log" value="{{ urlencode($currentFile) }}">{{ __('Download Log') }}</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ cp_route('utilities.logbook.destroy') }}">
                            @csrf
                            @method('delete')

                            @if(count($files) > 1)
                                <dropdown-list class="inline-block ml-1">
                                    <template #trigger>
                                        <button class="btn-danger flex items-center pr-2" type="button">
                                            {{ __('Delete Log') }} <svg-icon name="chevron-down-xs" class="w-2 ml-1"></svg-icon>
                                        </button>
                                    </template>

                                    <button name="log" value="{{ urlencode($currentFile) }}" data-delete>{{ __('Delete Current Log') }}</button>

                                    <button name="log" value="all" data-delete>{{ __('Delete All Logs') }}</button>
                                </dropdown-list>
                            @else
                                <button class="btn-danger ml-1" name="log" value="{{ urlencode($currentFile) }}" data-delete>{{ __('Delete Log') }}</button>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="card p-0">
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
    @else
        <p>No log files found.</p>
    @endif

@stop
