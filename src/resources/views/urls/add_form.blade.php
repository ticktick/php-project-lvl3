@extends('layout')

@section('title')
    Page Analyzer
@endsection

@section('content')
    <form method="POST" action="{{ route('urls.add') }}" enctype="multipart/form-data" class="d-flex justify-content-center">
        @csrf

        <input name="url[name]" type="text" class="@error('url.name') is-invalid @enderror form-control form-control-lg" placeholder="https://www.example.com">

        <button type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase">
            Add
        </button>
    </form>
@endsection