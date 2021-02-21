@extends('layout')

@section('title')
    Site: {{ $url->name }}
@endsection

@section('content')
    <table class="table table-bordered table-hover text-nowrap">
        <tr><td>Id</td><td>{{ $url->id }}</td></tr>
        <tr><td>Site</td><td>{{ $url->name }}</td></tr>
        <tr><td>Created</td><td>{{ $url->created_at }}</td></tr>
        <tr><td>Updated</td><td>{{ $url->updated_at }}</td></tr>
    </table>

    <form method="POST" action="{{ route('urls.makeCheck', ['id' => $url->id]) }}" enctype="multipart/form-data" class="d-flex justify-content-center">
        @csrf

        <button type="submit" class="btn btn-primary">
            Запустить проверку
        </button>
    </form>

    <h2>Проверки</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Дата создания</th>
            </tr>
            @foreach ($checks as $check)
                <tr>
                    <td>{{ $check->id }}</td>
                    <td>{{ $check->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection