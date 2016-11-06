<form id="emergency-contact_form" action="{{ $action }}" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">contacts</i> Emergency Contact
            </h2>
        </div>
        <div class="body">
            <!--Name and Relationship-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.text', ['name' => 'emergencyContact[first_name]', 'label' => 'First Name', 'value' => isset($emergency_contact)? $emergency_contact->first_name:null ])
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.text', ['name' => 'emergencyContact[last_name]', 'label' => 'Last Name', 'value' => isset($emergency_contact)? $emergency_contact->last_name:null ])
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.text', ['name' => 'emergencyContact[relationship]', 'label' => 'Relationship', 'value' => isset($emergency_contact)? $emergency_contact->relationship:null ])
                </div>
            </div>

            <!--Contact Details-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.input.text', ['name' => 'emergencyContact[phone]', 'label' => 'Phone Number', 'value' => isset($emergency_contact)? $emergency_contact->phone:null ])
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.input.text', ['name' => 'emergencyContact[email]', 'label' => 'Email Address', 'value' => isset($emergency_contact)? $emergency_contact->email:null ])
                </div>
            </div>

            <!--Address-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('components.form.input.text', ['name' => 'emergencyContact[address]', 'label' => 'Address', 'value' => isset($emergency_contact)? $emergency_contact->address:null ])
                </div>
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Profile form
    var emergencyContactForm = {
        element: '#emergency-contact_form',
        ready: function(){}
    };
</script>
@endpush