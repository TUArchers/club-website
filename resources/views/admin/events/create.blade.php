@extends('layouts.admin')

@section('title', 'Plan Event | Events')

@section('content')
    <div class="block-header">
        <h2>PLAN AN EVENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <!--Event Details Card-->
        	@include('admin.events.form._details')
        </div>

        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <!--Attendance Card-->
            @include('admin.events.form._attendance')
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
        eventDetailsForm.ready();
    });
</script>
@endpush