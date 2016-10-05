{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'first_name', 'label' => 'First Name', 'value' => isset($user)? $user->first_name:null ])
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'last_name', 'label' => 'Last Name', 'value' => isset($user)? $user->last_name:null ])
    </div>
</div>

<div class="row clearfix">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.email', ['name' => 'email', 'label' => 'Email Address', 'value' => isset($user)? $user->email:null ])
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'phone', 'label' => 'Phone Number', 'value' => isset($user)? $user->phone:null ])
    </div>
</div>

@unless(isset($user))
    <div class="row clearfix">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @include('components.form.input.password', ['name' => 'password', 'label' => 'Password'])
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @include('components.form.input.password', ['name' => 'password_confirm', 'label' => 'Confirm Password'])
        </div>
    </div>
@endunless

<div class="row clearfix">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'role_id', 'label' => 'Select Role', 'options' => $roles, 'selected' => isset($user)? $user->role_id:null ])
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'tusc_id', 'label' => 'TUSC ID', 'value' => isset($user)? $user->tusc_id:null ])
    </div>
</div>

@include('components.form.button.submit', ['colour' => 'btn-primary', 'label' => $submitLabel])