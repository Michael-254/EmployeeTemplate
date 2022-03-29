<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Employee Template</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet">
    <script defer src="{{asset('fontawesome/js/all.js')}}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.user = @json(auth()->user());
        window.loggedIn = @json(auth()->check());
    </script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div id="app">
       @if(auth()->check())
        <main-component :user="{{auth()->user()}}" />
       @endif
    </div>

</body>

</html>