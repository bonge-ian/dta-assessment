<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kibeng') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #app {
            background-image: url("./img/chat.png");
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>

<body>
    <div id="app"
        class="uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-overflow-hidden uk-light"
        uk-height-viewport>
        <div class="uk-position-cover uk-overlay-primary"></div>

        <main>

            @yield('content')
        </main>


    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
