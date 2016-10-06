@extends('layouts.auth')

@section('title', 'Reset Your Password')

@section('content')
    <form id="password_reset_request_form" role="form" method="POST" action="{{ route('auth.password-reset-request.attempt') }}">
        <div class="msg">Enter your email address and you will be sent a link to reset your password.</div>

        {{ csrf_field() }}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <button id="form_submit" class="btn btn-block bg-orange waves-effect" type="submit">SEND PASSWORD RESET EMAIL</button>
                <div id="form_spinner" class="md-preloader pl-size-xs pull-right" style="display: none">
                    <svg viewBox="0 0 75 75">
                        <circle cx="37.5" cy="37.5" r="33.5" class="pl-orange" stroke-width="5"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    $(function(){
        var $form = $('#password_reset_request_form');

        $form.on('submit', function(e){
            e.preventDefault();

            $('#form_submit').hide();
            $('#form_spinner').show();

            $.ajax({
                url:    $form.attr('action'),
                method: $form.attr('method'),
                data:   $form.serializeObject(),
                success: function(response){
                    $('#form_spinner').hide();
                    swal({
                        title:              'Done!',
                        text:               'A password reset link has been sent to your email address.',
                        type:               'success',
                        confirmButtonColor: "#FF9800"
                    }, function(){
                        window.history.back();
                    });
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