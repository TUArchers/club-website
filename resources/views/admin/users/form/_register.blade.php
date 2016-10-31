<form id="register_form" action="{{ $action }}" method="POST">
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">account_circle</i> Account Details
            </h2>
        </div>
        <div class="body">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sm-offset-2">
                    @include('components.form.input.text', ['name' => 'first_name', 'label' => 'First Name'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.text', ['name' => 'last_name', 'label' => 'Last Name'])
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sm-offset-2">
                    @include('components.form.input.email', ['name' => 'email', 'label' => 'Email Address'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.text', ['name' => 'phone', 'label' => 'Phone Number'])
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sm-offset-2">
                    @include('components.form.select', ['name' => 'role_id', 'label' => 'Select Role', 'options' => $roles, 'selected' => isset($user)? $user->role_id:null ])
                </div>
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-link waves-effect">REGISTER USER</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Register form
    var registerForm = {
        element: '#register_form',
        ready: function(){
            //
        }
    };

</script>
@endpush