<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--Title and Icon-->
    <title>@yield('title') | Teesside University Archers</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!--Bootstrap and Main Styles-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/preloader.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-theme.css') }}">
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo text-center">
        <img src="{{ asset('img/tua-club-logo.svg') }}" alt="Teesside University Archers club logo" width="100" class="m-b-5">
        <a href="#" class="font-16">Teesside University <b>Archers</b></a>
        <small>@yield('title')</small>
    </div>
    <div class="card animated">
        <div class="body">
            @yield('content')
        </div>
    </div>
</div>

<!--Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')

<!--Google Analytics-->
@include('partials.analytics')
</body>
</html>