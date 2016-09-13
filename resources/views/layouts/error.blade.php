<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        {{--Title and Icon--}}
        <title>@yield('title') | Teesside University Archers</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        {{--Google Fonts--}}
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

        {{--Bootstrap and Material Design--}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/error.css') }}">
    </head>

    <body class="error-page">
        <div class="error-page-container">
            <div class="error-code">@yield('code')</div>
            <div class="error-message">@yield('title')</div>
            <div class="error-description">@yield('message')</div>
            <div class="button-place">
                <a href="{{ url('/') }}" class="btn btn-default btn-lg">GO TO HOMEPAGE</a>
            </div>
        </div>

        {{--Scripts--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        {{--Google Analytics--}}
        @include('partials.analytics')
    </body>

</html>