@extends('layouts.auth')

@section('title', 'Set Your New Password')

@section('content')
    <form id="password_reset_form" role="form" method="POST" action="{{ route('auth.password-reset.attempt') }}">
        <div class="msg">Enter and confirm your new password.</div>

        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
                <input type="password" id="password_input" class="form-control" name="password" placeholder="New Password" required>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
                <input type="password" id="password_confirmation_input" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <button id="form_submit" class="btn btn-block bg-orange waves-effect" type="submit">CHANGE PASSWORD</button>
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
    $(function() {
        var $form = $('#password_reset_form');

        $form.on('submit', function (e) {
            e.preventDefault();

            $('#form_submit').hide();
            $('#form_spinner').show();

            $.ajax({
                url:    $form.attr('action'),
                method: $form.attr('method'),
                data:   $form.serializeObject(),
                success: function (response) {
                    $('#form_spinner').hide();
                    swal({
                        title: 'Done!',
                        text: 'Your password has been changed. Please log in to continue.',
                        type: 'success',
                        closeOnConfirm: false
                    }, function(){
                        window.location.href = '{{ route('admin.index') }}';
                    });
                },
                error: function (xhr) {
                    var message = xhr.responseJSON.message || xhr.responseJSON.email[0];

                    $('#form_submit').show();
                    $('#form_spinner').hide();

                    $form.closest('.card').animateCss('shake');
                    $form.find('.msg').first().text(message).addClass('col-red')
                }
            });
        });
    });
</script>
@endpush
