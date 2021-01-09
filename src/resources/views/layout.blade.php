<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<main class="flex-grow-1">
    @include('flash::message')

    <div class="container">
        <div class="row">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-10">
                <h1 class="mt-5 mb-3">
                @section('title')
                    No title
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
                    No content
                @show
            </div>
            <div class="col-lg-1">
            </div>
        </div>
    </div>
</main>
</body>
</html>