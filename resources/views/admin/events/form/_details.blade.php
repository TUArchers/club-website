<form id="event_details_form" action="{{ $action }}" method="POST">
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">event</i> Event Details
            </h2>
        </div>
        <div class="body">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                	@include('components.form.select', ['name' => 'type_id', 'options' => $event_types, 'label' => 'Event Type'])
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                	@include('components.form.input.text', ['name' => 'name', 'label' => 'Event Name'])
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                	@include('components.form.input.text', ['name' => 'location_name', 'label' => 'Location'])
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.datetime', ['name' => 'starts_at', 'label' => 'Start Date/Time'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.datetime', ['name' => 'ends_at', 'label' => 'End Date/Time'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.number', ['name' => 'capacity', 'label' => 'Event Capacity', 'min' => 1, 'value' => 30])
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                	@include('components.form.textarea', ['name' => 'description', 'rows' => '3', 'label' => 'Description'])
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.checkbox', ['name' => 'has_waiting_list', 'colour' => 'orange', 'label' => 'Has Waiting List'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.checkbox', ['name' => 'members_only', 'colour' => 'orange', 'label' => 'Members Only'])
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.checkbox', ['name' => 'invite_only', 'colour' => 'orange', 'label' => 'Invite Only'])
                </div>
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-link waves-effect">PLAN EVENT</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Profile form
    var eventDetailsForm = {
        element: '#event_details_form',
        ready: function(){
            // Enable date/time picker
            $(this.element).find('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                clearButton: false,
                weekStart: 1,
                time: true
            });

            var $startDateInput = $(this.element).find('#starts_at_input');
            var $endDateInput   = $(this.element).find('#ends_at_input');

            // Prevent the end date from being before the start date
            $startDateInput.on('change', function(){
                $endDateInput.bootstrapMaterialDatePicker('setMinDate', $(this).val());
            });
        }
    };
</script>
@endpush