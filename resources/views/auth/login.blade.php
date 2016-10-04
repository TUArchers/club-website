<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!--Title and Icon-->
        <title>Log In | Teesside University Archers</title>
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
                <small>Members' Content</small>
            </div>
            <div class="card animated">
                <div class="body">
                    <form id="log_in_form" method="POST">
                        {{ csrf_field() }}
                        <div class="msg">Log in to access this section</div>
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                            <div class="form-line">
                                <input type="email" class="form-control" name="email_address" placeholder="Email" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 p-t-5">
                                <input type="checkbox" name="remember" id="remember" class="filled-in chk-col-orange">
                                <label for="remember">Remember Me</label>
                            </div>
                            <div class="col-xs-4">
                                <button id="log_in_submit" class="btn btn-block bg-orange waves-effect" type="submit">SIGN IN</button>
                                <div id="log_in_spinner" class="md-preloader pl-size-xs pull-right" style="display: none">
                                    <svg viewBox="0 0 75 75">
                                        <circle cx="37.5" cy="37.5" r="33.5" class="pl-orange" stroke-width="5"></circle>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row m-t-15 m-b--20">--}}
                            {{--<div class="col-xs-6">--}}
                                {{--<a href="sign-up.html">Register Now!</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-6 align-right">--}}
                                {{--<a href="forgot-password.html">Forgot Password?</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </form>
                </div>
            </div>
        </div>

        <!--Scripts-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        <script>
            $(function(){
                var $form = $('#log_in_form');

                $form.on('submit', function(e){
                    e.preventDefault();
                    var formData = $form.serializeObject();

                    $('#log_in_submit').hide();
                    $('#log_in_spinner').show();

                    $.ajax({
                        url: '{{ route('auth.login.attempt') }}',
                        method: 'POST',
                        data: formData,
                        success: function(response){
                            $('#log_in_submit').show();
                            $('#log_in_spinner').hide();
                            window.location.href = response.redirect;
                        },
                        error: function(xhr){
                            $form.closest('.card').animateCss('shake');
                            $form.find('.msg').first().text(xhr.responseJSON.message).addClass('col-red')
                        }
                    });
                });
            });
        </script>

        <!--Google Analytics-->
        @include('partials.analytics')
    </body>
</html>