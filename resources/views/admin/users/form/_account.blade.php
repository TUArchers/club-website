<form id="account_form" action="{{ $action }}" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">account_circle</i> Account
            </h2>
        </div>
        <div class="body">
            <div class="row clearfix">
                <!--Email-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.input.email', ['name' => 'email', 'label' => 'Email Address', 'value' => isset($user)? $user->email:null ])
                </div>

                <!--Role-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.select', ['name' => 'role_id', 'label' => 'Select Role', 'options' => $roles, 'selected' => isset($user)? $user->role_id:null ])
                </div>
            @if($is_self)
                <!--Toggle Password Fields-->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="password-button" type="button" class="btn bg-blue waves-effect">Change Password</button>
                    </div>

                    <!--New Password-->
                    <div id="password-fields" class="hidden">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            @include('components.form.input.password', ['name' => 'password', 'label' => 'New Password'])
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            @include('components.form.input.password', ['name' => 'password_confirm', 'label' => 'Confirm New Password'])
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Account form
    var accountForm = {
        element: '#account_form',
        ready: function(){
            // Reveal password fields
            $(this.element).on('click', '#password-button', function(e){
                var button = $(e.target);
                var fields = $('#password-fields');

                button.parent().addClass('hidden');
                fields.show().removeClass('hidden');
            });
        }
    };
</script>
@endpush