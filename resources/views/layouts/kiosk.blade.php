<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/preloader.css') }}">
    @stack('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/kiosk.css') }}">
</head>

<body class="theme-orange ls-closed">

<!--Branding-->
<div class="navbar bg-grey">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">
                <img src="http://freshers.tuarchers.org.uk/assets/images/tua-club-logo.svg" alt="Teesside University Archers" class="navbar-logo m-t--15">
                Teesside University Archers
            </a>
        </div>
    </div>
</div>

<!--Content-->
<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>

<!--Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/jquery-steps.js') }}"></script>
<script src="{{ asset('js/jquery-validate.js') }}"></script>
<script src="{{ asset('js/kiosk.js') }}"></script>
@stack('scripts')

<!--Google Analytics-->
@include('partials.analytics')
</body>

</html>