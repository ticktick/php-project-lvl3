@extends('layout')

@section('title')
    {{ __('main.url') }}: {{ $url->name }}
@endsection

@section('content')
    <table class="table table-bordered table-hover text-nowrap">
        <tr><td>{{ __('columns.id') }}</td><td>{{ $url->id }}</td></tr>
        <tr><td>{{ __('columns.name') }}</td><td>{{ $url->name }}</td></tr>
        <tr><td>{{ __('columns.created_at') }}</td><td>{{ $url->created_at }}</td></tr>
        <tr><td>{{ __('columns.updated_at') }}</td><td>{{ $url->updated_at }}</td></tr>
    </table>

    <form method="POST" action="{{ route('urls.makeCheck', ['id' => $url->id]) }}" enctype="multipart/form-data" class="d-flex justify-content-center">
        @csrf

        <button type="submit" class="btn btn-primary">
            {{ __('buttons.run_check') }}
        </button>
    </form>

    <h2>{{ __('main.checks') }}</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>{{ __('columns.id') }}</th>
                <th>{{ __('columns.code') }}</th>
                <th>{{ __('columns.h1') }}</th>
                <th>{{ __('columns.keywords') }}</th>
                <th>{{ __('columns.description') }}</th>
                <th>{{ __('columns.created_at') }}</th>
            </tr>
            @foreach ($checks as $check)
                <tr>
                    <td>{{ $check->id }}</td>
                    <td>{{ $check->status_code }}</td>
                    <td>{{ Str::limit($check->h1, 20, '...') }}</td>
                    <td>{{ Str::limit($check->keywords, 20, '...') }}</td>
                    <td>{{ Str::limit($check->description, 20, '...') }}</td>
                    <td>{{ $check->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection