@extends('layouts.admin')

@section('title', 'Send Invitation | Event Invites')

@section('content')
    <div class="block-header">
        <h2>SEND AN EVENT INVITATION</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--Event Details Card-->
            @include('admin.invites.form._details')
        </div>
    </div>
@endsection