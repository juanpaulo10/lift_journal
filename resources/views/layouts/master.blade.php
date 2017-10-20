<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--  <link rel="stylesheet" href="/css/app.css">  --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    {{--  <script src="//0.0.0.0:6001/socket.io/socket.io.js"></script>  --}}
</head>

<body>
    <div id="app">
        @include ('layouts.nav')

        @yield ('content')
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
    {{--  <script src="/js/app.js"></script>  --}}
</body>

</html>