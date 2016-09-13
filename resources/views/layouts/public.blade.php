<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{--The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags--}}
        {{--<meta name="description" content="Page Description">--}}
        {{--<meta name="author" content="jdrew">--}}
        <title>Teesside University Archers | @yield('title')</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/public.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        {{--Header--}}
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <a href="/">
                            <img src="http://tuarchers.org.uk/assets/images/tua-club-logo.png" alt="Club logo" style="max-height: 100px">
                            <span>Teesside University Archers</span><br>
                            <span>Since 2012</span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        Social and login
                    </div>
                </div>
            </div>
        </header>

        {{--Navigation--}}
        <div class="navigation container">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav nav-justified">
                        <li class="active"><a href="#">Link</a></li>
                        <li><a href="#">Link</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        {{--Main Content--}}
        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>

        {{--Footer--}}
        <footer>
            <div class="container">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <p class="title">Teesside University Archers</p>
                    <p>Copyright &copy; <em>{{ date('Y') }}</em></p>
            	</div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <h3>Useful Information</h3>
                    <ul>
                        <li>Contact Information</li>
                        <li>Club Records</li>
                        <li>Find Us on Facebook</li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <h3>Contact Us</h3>
                    <p>
                        Teesside University Archers <br>
                        Teesside University Students' Union <br>
                        Borough Road, Middlesbrough <br>
                        TS1 3BA
                    </p>
                    <p>Email: <a href="mailto:{{ 'committee@tuarchers.org.uk' }}">{{ 'committee@tuarchers.org.uk' }}</a></p>
                </div>
            </div>
        </footer>

        {{--Scripts--}}
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        {{--Include all compiled plugins (below), or include individual files as needed--}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>