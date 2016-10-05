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
                            <h4>Choose a Session Time</h4>
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    Pick a date and time to come along for a free taster session.
                                </div>
                            </div>
                            <input type="hidden" id="event_id_input" name="event_id">
                            <input type="hidden" id="reservation_id_input" name="reservation_id">

                            @foreach($event_days as $title => $events)
                                <h4 class="card-inside-title">{{ $title }}</h4>
                                <div class="row clearfix">
                                    @foreach($events as $event)
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                            @if($event->is_full)
                                                <div class="info-box bg-grey">
                                                    <div class="icon bg-grey">
                                                        <div class="time font-24 m-t-10">{{ $event->starts_at->format('g:i') }}</div>
                                                        <div class="period font-16">{{ $event->starts_at->format('A') }}</div>
                                                    </div>
                                                    <div class="content">
                                                        <div class="number">{{ $event->name }}</div>
                                                        <div class="text">Full</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="info-box info-box-selectable waves-effect"
                                                     data-event-id="{{ $event->id }}"
                                                     data-event-name="{{ $event->name }}"
                                                     data-event-type="{{ $event->type->name }}"
                                                     data-event-start="{{ $event->starts_at }}"
                                                     data-event-end="{{ $event->ends_at }}"
                                                     data-event-location="{{ $event->location_name }}">
                                                    <div class="icon bg-{{ $event->type->colour }}">
                                                        <div class="time font-24 m-t-10">{{ $event->starts_at->format('g:i') }}</div>
                                                        <div class="period font-16">{{ $event->starts_at->format('A') }}</div>
                                                    </div>
                                                    <div class="content">
                                                        <div class="number">{{ $event->name }}</div>
                                                        @if($event->spaces_remaining < 5)
                                                            <div class="text col-red font-bold">{{ $event->spaces_remaining }} space{{ 1 == $event->spaces_remaining? null:'s' }}</div>
                                                        @else
                                                            <div class="text">{{ $event->spaces_remaining }} spaces</div>
                                                        @endif
                                                        <div class="event-description" style="display: none">
                                                            {{ $event->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </fieldset>

                        <!--Enter Basic Details-->
                        <h3>About You</h3>
                        <fieldset>
                            <h4>Tell Us About You</h4>
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    We need this to make it easier for us to register you when you come to your session.
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[first_name]', 'id' => 'attendee_first_name', 'label' => 'First Name *', 'required' => true])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[last_name]', 'id' => 'attendee_last_name', 'label' => 'Last Name *', 'required' => true])
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.email', ['name' => 'attendee[email]', 'id' => 'attendee_email', 'label' => 'Email *', 'required' => true])
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    @include('components.form.input.text', ['name' => 'attendee[phone]', 'id' => 'attendee_phone', 'label' => 'Phone Number *', 'required' => true])
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
                        <h3>Research Questions</h3>
                        <fieldset>

                            <h4>Research Stuff</h4>
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                	This bit is for research purposes only. While we'd love it if you could fill this in, you can skip it if you want!
                                </div>
                            </div>
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
                            <h4>Check Everything's Correct</h4>
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    Just a quick check to make sure everything looks good.
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <h5>Your Taster Session</h5>
                                    <div class="card">
                                        <div class="header bg-green">
                                            <h2>
                                                <span id="event_name_summary"></span>
                                                <small id="event_type_summary"></small>
                                            </h2>
                                        </div>
                                        <div class="body bg-blue-grey">
                                            <p>
                                                <i class="material-icons media-middle">access_time</i><span id="event_time_summary"></span>
                                            </p>
                                            <p>
                                                <i class="material-icons media-middle">av_timer</i><span id="event_duration_summary"></span>
                                            </p>
                                            <p>
                                                <i class="material-icons media-middle">location_on</i><span id="event_location_summary"></span>
                                            </p>
                                            <p id="event_description_summary" class="m-t-35"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <h5>Your Details</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Name: </strong><span id="attendee_name_summary">-</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Email: </strong><span id="attendee_email_summary">-</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Phone: </strong><span id="attendee_phone_summary">-</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Date of Birth: </strong><span id="attendee_date_of_birth_summary">-</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Student/Staff/Associate Number: </strong><span id="attendee_tusc_id_summary">-</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Archery GB Number: </strong><span id="attendee_agb_id_summary">-</span>
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
    // Make sure the button effect has been enabled
    function setButtonWavesEffect(event) {
        $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
        $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
    }

    // Summarise the chosen event details
    function summariseEvent($event){
        var start     = moment($event.data('event-start'));
        var end       = moment($event.data('event-end'));
        var time      = start.format('D MMMM [at] h:mm A') + ' - ' + end.format('h:mm A');
        var duration  = end.diff(start, 'hours') + ' hours';

        $('#event_name_summary').text($event.data('event-name'));
        $('#event_type_summary').text($event.data('event-type'));
        $('#event_time_summary').text(time);
        $('#event_duration_summary').text(duration);
        $('#event_location_summary').text($event.data('event-location'));

        $('#event_description_summary').text($event.find('.event-description').text());
    }

    // Generate the data summary for the confirmation view
    function summariseAttendee(data){
        $('#attendee_name_summary').text(data['attendee[first_name]'] + " " + data['attendee[last_name]']);
        $('#attendee_email_summary').text(data['attendee[email]']);
        $('#attendee_phone_summary').text(data['attendee[phone]']);
        $('#attendee_date_of_birth_summary').text(data['attendee[date_of_birth]']);
        $('#attendee_tusc_id_summary').text(data['attendee[tusc_id]']);
    }

    // Reserve a space to allow the user to add their details
    function reserveSpace(){
        var base    = '{{ url('/') }}';
        var eventId = $('#event_id_input').val();

        $.ajax({
            url: base + '/api/tasters/' + eventId + '/reservations',
            type: 'POST',
            data: {
                reservation_id: $('#reservation_id_input').val()
            },
            success: function(reservation){
                $('#reservation_id_input').val(reservation.id);
            }
        });
    }

    // Confirm the reservation
    function confirmReservation(form, successCallback, errorCallback){
        var base          = '{{ url('/') }}';
        var eventId       = $('#event_id_input').val();
        var reservationId = $('#reservation_id_input').val();

        $.ajax({
            url: base + '/api/tasters/' + eventId + '/reservations/' + reservationId,
            type: 'PUT',
            data: form.serialize(),
            success: successCallback,
            error: errorCallback
        });
    }

    // Ready!
    $(function(){
        Waves.attach('.waves-effect', ['waves-button', 'waves-float']);
        Waves.init();

        var form = $('#taster_wizard').show();

        // Enable form wizard
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

                if(0 == currentIndex && !$('#event_id_input').val()){
                    return false;
                }

                switch(newIndex){
                    case 1:
                        reserveSpace();
                        break;
                    case 3:
                        summariseAttendee(form.serializeObject());
                        break;
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
                $(event.currentTarget).find('[role="menu"] li').addClass('disabled');

                confirmReservation(form, function(reservation){
                    console.log(reservation);

                    swal({
                        title: "All Done!",
                        text: "Your taster session has been booked; See you there!",
                        type: "success"
                    },
                    function(){
                        location.reload();
                    });
                },
                function(){
                    swal({
                        title: "Whoops!",
                        text: "Something seems to have gone wrong; Let's start again...",
                        type: "error"
                    },
                    function(){
                        location.reload();
                    });
                });
            }
        });

        // Enable form validation
        form.validate({
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });

        // Enable date-time picker
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: false,
            weekStart: 1,
            time: false,
            maxDate: moment().subtract(16, 'years')
        });

        // Handle selectable info boxes
        $('body').on('click', '.info-box-selectable', function(e){
            var $event = $(e.target).closest('.info-box');

            $('#event_id_input').val($event.data('event-id'));
            summariseEvent($event);

            $('.info-box-selectable').removeClass('bg-green');
            $event.addClass('bg-green');
        });
    });
</script>
@endpush