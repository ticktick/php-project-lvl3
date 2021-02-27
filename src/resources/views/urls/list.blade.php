@extends('layout')

@section('title')
    Сайты
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Последняя проверка</th>
                <th>Код ответа</th>
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
