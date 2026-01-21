@extends('statamic::layout')
@section('title', Statamic::crumb(__('Logbook'), __('Utilities')))
@section('wrapper_class', 'max-w-full')

@section('content')

    <ui-header :title="__('Logbook')" icon="book-next-page" />

    @if(count($files))
        <ui-card class="mb-4">
            <div class="flex items-center justify-between">
                <form class="flex" method="GET" action="{{ cp_route('utilities.logbook.show') }}">
                    <ui-combobox
                        :options="{{ json_encode($files) }}"
                        placeholder="{{ $currentFile['label'] }}"
                        size="base"
                        @update:model-value="console.log(arguments);"
                    />
                </form>

                @if($currentFile)
                    <div class="flex items-center">
                        @if(count($files))
                            <form class="flex" method="GET" action="{{ cp_route('utilities.logbook.show') }}">
                                <input type="hidden" name="download">

                                <ui-button type="submit" variant="primary" name="log" value="{{ $currentFile['key'] }}">{{ __('Download Log') }}</ui-button>
                            </form>
                        @endif

                        <form method="POST" action="{{ cp_route('utilities.logbook.destroy') }}" class="ml-2">
                            @csrf
                            @method('delete')

                            <ui-button type="submit" variant="danger" name="log" value="{{ $currentFile['key'] }}" data-delete>{{ __('Delete Log') }}</ui-button>
                        </form>
                    </div>
                @endif
            </div>
        </ui-card>

        <ui-card>
            <ui-table>
                <ui-table-columns>
                    <ui-table-column>{{ __('Level') }}</ui-table-column>
                    <ui-table-column>{{ __('Context') }}</ui-table-column>
                    <ui-table-column>{{ __('Date') }}</ui-table-column>
                    <ui-table-column>{{ __('Content') }}</ui-table-column>
                </ui-table-columns>
                <ui-table-rows>
                    @foreach ($logs as $key => $log)
                        <ui-table-row @if($log['stack']) style="cursor: zoom-in;" data-expandable @endif>
                            <ui-table-cell style="min-width: 120px; vertical-align: top;"><ui-badge>{{ $log['level'] }}</ui-badge></ui-table-cell>
                            <ui-table-cell style="min-width: 120px; vertical-align: top;">{{ $log['context'] }}</ui-table-cell>
                            <ui-table-cell style="min-width: 200px; vertical-align: top;">{{ $log['date'] }}</ui-table-cell>
                            <ui-table-cell class="w-full font-mono text-xs">
                                {{ $log['text'] }}

                                @if($log['in_file'])) <br>{{ $log['in_file'] }} @endif

                                @if($log['stack']) <div class="hidden whitespace-pre-wrap" data-stack>{{ trim($log['stack']) }}</div> @endif
                            </ui-table-cell>
                        </ui-table-row>
                    @endforeach
                </ui-table-rows>
            </ui-table>
        </ui-card>
    @else
        <ui-text>No log files found.</ui-text>
    @endif

@stop
