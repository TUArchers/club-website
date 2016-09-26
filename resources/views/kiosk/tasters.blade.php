@extends('layouts.kiosk')

@section('title', 'Taster Sessions')

@section('content')
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="header">
                    <h2>Book a Taster Session</h2>
                </div>
                <div class="body">
                    <form id="taster_wizard" action="" method="post">
                        <!--Choose Session Time-->
                        <h3>Session Time</h3>
                        <fieldset>
                            @include('components.form.input.number', ['name' => 'event_id', 'label' => 'Session ID'])
                        </fieldset>

                        <!--Enter Basic Details-->
                        <h3>Basic Details</h3>
                        <fieldset>
                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[first_name]', 'id' => 'attendee_first_name', 'label' => 'First Name *'])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[last_name]', 'id' => 'attendee_last_name', 'label' => 'Last Name *'])
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.email', ['name' => 'attendee[email_address]', 'id' => 'attendee_email_address', 'label' => 'Email *'])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[phone_number]', 'id' => 'attendee_phone_number', 'label' => 'Phone Number *'])
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[tusc_id]', 'id' => 'attendee_tusc_id', 'label' => 'Student/Staff/Associate ID'])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[agb_id]', 'id' => 'attendee_agb_id', 'label' => 'Archery GB Membership Number'])
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.datetime', ['name' => 'attendee[date_of_birth]', 'id' => 'attendee_date_of_birth', 'label' => 'Date of Birth'])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.select', ['name' => 'attendee[gender]', 'id' => 'attendee_gender', 'label' => 'Select Gender', 'options' => $genders])
                                </div>
                            </div>
                        </fieldset>

                        <!--Enter Extra Details-->
                        <h3>Extra Details</h3>
                        <fieldset>
                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.select', ['name' => 'demographics[school]', 'id' => 'demographics_school', 'label' => 'Select School', 'options' => $schools])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.select', ['name' => 'demographics[subject]', 'id' => 'demographics_subject', 'label' => 'Select Subject Area', 'options' => $subjects])
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.select', ['name' => 'demographics[qualification]', 'id' => 'demographics_qualification', 'label' => 'Select Qualification', 'options' => $qualifications])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.select', ['name' => 'demographics[year]', 'id' => 'demographics_year', 'label' => 'Select Year of Study', 'options' => $years])
                                </div>
                            </div>
                        </fieldset>

                        <!--Confirm-->
                        <h3>Confirm</h3>
                        <fieldset>
                            <h4>Confirm Your Details</h4>
                            <div id="wizard-summary" class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    Reservation
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Name: </strong><span id="attendee_name_summary"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Email: </strong><span id="attendee_email_summary"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Phone: </strong><span id="attendee_phone_summary"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker.css') }}">
@endpush

@push('scripts')
<script>
    function setButtonWavesEffect(event) {
        $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
        $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
    }

    function generateSummary(data){
        $('#attendee_name_summary').text(data['attendee[first_name]'] + " " + data['attendee[last_name]']);
        $('#attendee_email_summary').text(data['attendee[email_address]']);
        $('#attendee_phone_summary').text(data['attendee[phone_number]']);
    }

    $(function(){
        var form = $('#taster_wizard').show();

        form.steps({
            headerTag: 'h3',
            bodyTag: 'fieldset',
            transitionEffect: 'slideLeft',
            onInit: function (event, currentIndex) {
                $.AdminBSB.input.activate();
                $.AdminBSB.select.activate();

                //Set tab width
                var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
                var tabCount = $tab.length;
                $tab.css('width', (100 / tabCount) + '%');

                //set button waves effect
                setButtonWavesEffect(event);
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                if (currentIndex > newIndex) { return true; }

                if (currentIndex < newIndex) {
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }

                if(3 == newIndex){
                    generateSummary(form.serializeObject());
                }

                form.validate().settings.ignore = ':disabled,:hidden';
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                setButtonWavesEffect(event);
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ':disabled';
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                console.log(form.serializeObject());
                swal("Good job!", "Submitted!", "success");
            }
        });

        form.validate({
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            },
            rules: {}
        });

        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: false,
            weekStart: 1,
            time: false,
            maxDate: moment().subtract(16, 'years')
        });
    });
</script>
@endpush