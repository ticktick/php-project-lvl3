@extends('layout')

@section('title')
    {{ __('main.urls') }}
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>{{ __('columns.id') }}</th>
                <th>{{ __('columns.name') }}</th>
                <th>{{ __('columns.last_check') }}</th>
                <th>{{ __('columns.code') }}</th>
            </tr>
        @foreach ($urls as $url)
            <tr>
                <td>{{ $url->id }}</td>
                <td><a href="{{ route('urls.one', ['id' => $url->id]) }}">{{ url($url->name) }}</a></td>
                <td>{{ $lastChecks->get($url->id)->created_at ?? '' }}</td>
                <td>{{ $lastChecks->get($url->id)->status_code ?? '' }}</td>
            </tr>
        @endforeach
        </table>
    </div>
@endsection
