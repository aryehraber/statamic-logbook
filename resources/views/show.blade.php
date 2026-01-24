@extends('statamic::layout')
@section('title', Statamic::crumb(__('Logbook'), __('Utilities')))
@section('wrapper_class', 'max-w-full')

@section('content')

    <ui-header :title="__('Logbook')" icon="book-next-page" />

    @if(count($files))
        <ui-card class="mb-4">
            <div class="flex items-center justify-between">
                <form class="flex">
                    <ui-combobox
                        :options="{{ json_encode($files) }}"
                        modelValue="{{ $currentFile['key'] }}"
                        placeholder="{{ $currentFile['label'] }}"
                        size="base"
                        :closeOnSelect="true"
                        @update:model-value="function (value) {
                            this.location.href = '{{ cp_route('utilities.logbook.show') }}?log=' + value;
                        }"
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

        <ui-card class="w-full">
            <ui-table class="w-full overflow-x-auto">
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
                            <ui-table-cell style="min-width: 120px; vertical-align: top;"><ui-text>{{ $log['context'] }}</ui-text></ui-table-cell>
                            <ui-table-cell style="min-width: 200px; vertical-align: top;"><ui-text>{{ $log['date'] }}</ui-text></ui-table-cell>
                            <ui-table-cell class="font-mono text-xs" style="width:calc(100% - 440px);">
                                <div class="overflow-x-scroll">
                                    <ui-text>
                                        {{ $log['text'] }}
                                        @if($log['in_file'])) <br>{{ $log['in_file'] }} @endif
                                    </ui-text>

                                    @if($log['stack']) <ui-text class="hidden" data-stack>{{ trim($log['stack']) }}</ui-text> @endif
                                </div>
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
