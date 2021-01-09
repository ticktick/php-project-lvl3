@extends('layout')

@section('title')
    Domains
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        @foreach ($domains as $domain)
            <tr>
                <td>{{ $domain->id }}</td>
                <td><a href="{{ route('domains.one', ['id' => $domain->id]) }}">{{ url($domain->name) }}</a></td>
            </tr>
        @endforeach
        </table>
    </div>
@endsection
