@extends('layouts.admin')

@section('title', 'Add Member')

@section('content')
    <div class="block-header">
        <h2>USERS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>ADD MEMBER</h2>
                </div>
                <div class="body">
                    <form method="post" action="{{ url('/admin/members/add') }}">
                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="first_name_input" name="first_name" class="form-control" title="First Name">
                                        <label class="form-label">First Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="last_name_input" name="last_name" class="form-control" title="Last Name">
                                        <label class="form-label">Last Name</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" id="email_address_input" name="email_address" class="form-control" title="Email Address">
                                        <label class="form-label">Email Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="phone_number_input" name="phone_number" class="form-control" title="Phone Number">
                                        <label class="form-label">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                        </div>

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

                        <div class="row clearfix">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <select name="role_id" id="role_select" class="form-control show-tick" title="Role">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if('member' == $role->slug) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="tusc_id_input" name="tusc_id" class="form-control" title="TUSC ID">
                                        <label class="form-label">TUSC ID</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection