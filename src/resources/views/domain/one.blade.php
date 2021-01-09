@extends('layout')

@section('title')
    Site: {{ $domain->name }}
@endsection

@section('content')
    <table class="table table-bordered table-hover text-nowrap">
        <tr><td>Id</td><td>{{ $domain->id }}</td></tr>
        <tr><td>Site</td><td>{{ $domain->name }}</td></tr>
        <tr><td>Created</td><td>{{ $domain->created_at }}</td></tr>
        <tr><td>Updated</td><td>{{ $domain->updated_at }}</td></tr>
    </table>
@endsection