@extends('layouts.auth')

@section('title', 'Log In')

@section('content')
    <form id="log_in_form" role="form" method="POST" action="{{ route('auth.login.attempt') }}">
        {{ csrf_field() }}
        <div class="msg">Log in to access this section</div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
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
                <button id="form_submit" class="btn btn-block bg-orange waves-effect" type="submit">SIGN IN</button>
                <div id="form_spinner" class="md-preloader pl-size-xs pull-right" style="display: none">
                    <svg viewBox="0 0 75 75">
                        <circle cx="37.5" cy="37.5" r="33.5" class="pl-orange" stroke-width="5"></circle>
                    </svg>
                </div>
            </div>
        </div>
        <div class="row m-t-15 m-b--20">
            {{--<div class="col-xs-6">--}}
            {{--<a href="sign-up.html">Register Now!</a>--}}
            {{--</div>--}}
            <div class="col-xs-6">
                <a href="{{ route('auth.password-reset-request.show') }}">Forgot Password?</a>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    $(function(){
        var $form = $('#log_in_form');

        $form.on('submit', function(e){
            e.preventDefault();

            $('#form_submit').hide();
            $('#form_spinner').show();

            $.ajax({
                url:    $form.attr('action'),
                method: $form.attr('method'),
                data:   $form.serializeObject(),
                success: function(response){
                    window.location.href = response.redirect;
                },
                error: function(xhr){
                    $('#form_submit').show();
                    $('#form_spinner').hide();

                    $form.closest('.card').animateCss('shake');
                    $form.find('.msg').first().text(xhr.responseJSON.message).addClass('col-red')
                }
            });
        });
    });
</script>
@endpush