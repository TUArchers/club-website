    {{ csrf_field() }}

    <div class="row clearfix">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group form-float">
                <div class="form-line {{ isset($user) && !is_null($user->first_name)? 'focused':''}}">
                    <input type="text" id="first_name_input" name="first_name" class="form-control" title="First Name" @if(isset($user))value="{{ $user->first_name }}"@endif>
                    <label class="form-label">First Name</label>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group form-float">
                <div class="form-line {{ isset($user) && !is_null($user->last_name)? 'focused':''}}">
                    <input type="text" id="last_name_input" name="last_name" class="form-control" title="Last Name" @if(isset($user))value="{{ $user->last_name }}"@endif>
                    <label class="form-label">Last Name</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group form-float">
                <div class="form-line {{ isset($user) && !is_null($user->email_address)? 'focused':''}}">
                    <input type="email" id="email_address_input" name="email_address" class="form-control" title="Email Address" @if(isset($user))value="{{ $user->email }}"@endif>
                    <label class="form-label">Email Address</label>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group form-float">
                <div class="form-line {{ isset($user) && !is_null($user->phone_number)? 'focused':''}}">
                    <input type="text" id="phone_number_input" name="phone_number" class="form-control" title="Phone Number" @if(isset($user))value="{{ $user->phone_number }}"@endif>
                    <label class="form-label">Phone Number</label>
                </div>
            </div>
        </div>
    </div>

    @unless(isset($user))
        <div class="row clearfix">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" id="password_input" name="password" class="form-control" title="Password">
                        <label class="form-label">Password</label>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" id="password_confirm_input" name="password_confirm" class="form-control" title="Confirm Password">
                        <label class="form-label">Confirm Password</label>
                    </div>
                </div>
            </div>
        </div>
    @endunless

    <div class="row clearfix">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <select name="role_id" id="role_select" class="form-control show-tick" title="Role">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(isset($user) && $role->id == $user->role_id) selected @elseif('member' == $role->slug) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group form-float">
                <div class="form-line {{ isset($user) && !is_null($user->tusc_id)? 'focused':''}}">
                    <input type="text" id="tusc_id_input" name="tusc_id" class="form-control" title="TUSC ID"  @if(isset($user))value="{{ $user->tusc_id }}"@endif>
                    <label class="form-label">TUSC ID</label>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary m-t-15 waves-effect">{{ $submitLabel }}</button>