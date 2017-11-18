<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Lift Journal</title>

    {{--  Fonts  --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    {{--  Icons  --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--  css  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.min.css">

    <style>
        .footer {
            width: 100% !important;
            padding: 1.3rem 1.5rem 2rem;
        }
    </style>
</head>
<body>
    @include ('emails.header')

    @yield ('content')

    @include ('emails.footer')
    
</body>
</html>