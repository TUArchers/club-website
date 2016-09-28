<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!--Title and Icon-->
        <title>Teesside University Archers</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

        <!--Bootstrap and Main Styles-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    </head>

    <body class="home">
        <!-- Cover page -->
        <div id="cover" class="container full-height vertical-center">
            <div id="brand-front" class="row full-width">
                <div class="col-xs-5 text-right">
                    <img class="logo-front" src="{{ asset('img/tua-club-logo.png') }}" alt="Teesside University Archers logo">
                </div>
                <div class="col-xs-7 text-left">
                    <div class="push-down">
                        <h1 class="title-front">Teesside University</h1>
                        <h2 class="title-front thin">Archers</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login form (modal) -->
        <div class="modal fade" id="login-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Members Area | Login</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="alert alert-info" role="alert">
                                <i class="glyphicon glyphicon-info-sign"></i> <span>The members' area is currently unavailable</span>
                            </div>
                            <div class="form-group">
                                <label for="username-input">Username/Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="username-input" name="username" placeholder="Username" required disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-input">Password</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </div>
                                    <input type="password" class="form-control" id="password-input" name="password" placeholder="Password" required disabled>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default btn-circle btn-back" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                            <button id="btn-login" type="submit" class="btn btn-github pull-right" disabled>Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact form (modal) -->
        <div class="modal fade" id="contact-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Contact Teesside University Archers</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('api.contact') }}" method="post" id="contact-form">
                            <div class="form-group">
                                <label class="control-label" for="name-input">Name *</label>
                                <input type="text" class="form-control" id="name-input" name="name" placeholder="Name" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label class="control-label" for="email-input">Email Address *</label>
                                    <input type="email" class="form-control" id="email-input" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label class="control-label" for="phone-input">Phone Number</label>
                                    <input type="text" class="form-control" id="phone-input" name="phone" placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="enquiry-input">Enquiry *</label>
                                <textarea class="form-control" id="enquiry-input" cols="30" rows="6" name="enquiry" required></textarea>
                            </div>
                            <button type="button" class="btn btn-default btn-circle btn-back" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                            <button type="submit" class="btn btn-github pull-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer menu -->
        <footer id="menu" class="sticky-footer footer-links">
            <div class="container">
                <p class="text-center">
                    <a href="#" id="members-area-link" data-toggle="modal" data-target="#login-modal">Members Area</a>
                    |
                    <a href="#" id="contact-us-link" data-toggle="modal" data-target="#contact-modal">Contact Us</a>
                </p>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ asset('js/jquery-validate.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                // Disable the login action
                $('#btn-login').on('click', function(){
                    return false;
                });

                // Clear forms when the back button is pressed
                $('.btn-back').on('click', function(){
                    $(this).closest('form').trigger('reset').find('.alert').remove();
                });

                // Validate the contact form
                $('#contact-form').validate({
                    errorClass: 'has-error',
                    errorElement: 'em',
                    validClass: 'has-success',
                    highlight: function(element, errorClass, validClass){
                        $(element).parent().removeClass(validClass).addClass(errorClass);
                    },
                    unhighlight: function(element, errorClass, validClass){
                        $(element).parent().removeClass(errorClass).addClass(validClass);
                    },
                    submitHandler: function(form){
                        var formData = {},
                                token = '{{ csrf_token() }}';
                        $.each($(form).serializeArray(), function(i, item){
                            formData[item.name] = item.value;
                        });

                        $.ajax($(form).attr('action'), {
                            method: 'post',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        }).done(function(){
                            $(form).find('.alert').remove();
                            $(form).prepend(
                                    $('<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button><i class="glyphicon glyphicon-ok-sign"></i> <span>Your message has been sent!</span> </div>')
                            );
                        }).fail(function(){
                            $(form).find('.alert').remove();
                            $(form).prepend(
                                    $('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button><i class="glyphicon glyphicon-remove-sign"></i> <span>Your message could not be sent. Please try again later.</span> </div>')
                            );
                        });
                    }
                });
            });
        </script>

        @include('partials.analytics')
    </body>
</html>