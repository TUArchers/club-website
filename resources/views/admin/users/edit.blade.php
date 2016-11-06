@extends('layouts.admin')

@section('title', $user->name . ' | Edit User')

@section('content')
    <div class="block-header">
        <h2>
            {{ strtoupper($user->name) }}<br/>
            <small>Edit user details</small>
        </h2>
        <ul class="header-dropdown m-r-10">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle no-hover" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">more_vert</i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ route('admin.users.show', $user->id) }}" class=" waves-effect waves-block">View User Profile</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="row clearfix">
        <!--Profile Column-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <!--Profile Card-->
            @include('admin.users.form._profile')
        </div>

        <!--Account Column-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <!--Account Card-->
            @include('admin.users.form._account')
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--Emergency Contact Card-->
            @include('admin.users.form._emergencyContact')
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--Memberships Card-->
            @include('admin.users.form._memberships')
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker.css') }}">
@endpush

@push('scripts')
<script>
    // Go!
    $(function(){
        // Declare the forms ready
        profileForm.ready();
        accountForm.ready();
        emergencyContactForm.ready();
        membershipsForm.ready();
    });
</script>
@endpush