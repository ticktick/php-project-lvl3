<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header class="flex-shrink-0">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('home') }}">{{ __('main.site_name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('home')) ? 'active' : '' }}" href="{{ route('home') }}">{{ __('main.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('urls.list')) ? 'active' : '' }}" href="{{ route('urls.list') }}">{{ __('main.urls') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main class="flex-grow-1">
    @include('flash::message')

    <div class="container">
        <div class="row">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-10">
                <h1 class="mt-5 mb-3">
                @section('title')
                @show
                </h1>
            </div>
            <div class="col-lg-1">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-10">
                @section('content')
                @show
            </div>
            <div class="col-lg-1">
            </div>
        </div>
    </div>
</main>
</body>
</html>