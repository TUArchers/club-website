{{ csrf_field() }}

<h3 class="card-inside-title">Personal Information</h3>
<div class="row clearfix">
    <!--Photo-->
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        <div class="image-editor">
            <input type="file" class="cropit-image-input">
            <input type="hidden" name="picture" class="hidden-image-data">

            <div class="cropit-preview"></div>

            <div class="image-controls">
                <div class="image">
                    <i class="material-icons btn-icon change-image" data-toggle="tooltip" data-placement="bottom" title="Change Image">image</i>
                </div>
                <div class="rotation">
                    <i class="material-icons btn-icon rotate-ccw" data-toggle="tooltip" data-placement="bottom" title="Rotate Counter-Clockwise">rotate_left</i>
                    <i class="material-icons btn-icon rotate-cw" data-toggle="tooltip" data-placement="bottom" title="Rotate Clockwise">rotate_right</i>
                </div>
                <div class="zoom">
                    <input type="range" class="cropit-image-zoom-input"  data-toggle="tooltip" data-placement="bottom" title="Zoom In/Out">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
        <!--Name-->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @include('components.form.input.text', ['name' => 'first_name', 'label' => 'First Name', 'value' => isset($user)? $user->first_name:null ])
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @include('components.form.input.text', ['name' => 'last_name', 'label' => 'Last Name', 'value' => isset($user)? $user->last_name:null ])
            </div>
        </div>
        <!--Birth Date and Gender-->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @include('components.form.select', ['name' => 'gender', 'label' => 'Select Gender', 'options' => $genders, 'selected' => isset($user)? $user->gender->id:null ])
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @include('components.form.input.datetime', ['name' => 'birth_date', 'label' => 'Birth Date'])
            </div>
        </div>
    </div>
</div>

<h3 class="card-inside-title">Contact Information</h3>
<!--Email and Phone-->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.email', ['name' => 'email', 'label' => 'Email Address', 'value' => isset($user)? $user->email:null ])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'phone', 'label' => 'Phone Number', 'value' => isset($user)? $user->phone:null ])
    </div>
</div>

<h3 class="card-inside-title">Account Details</h3>
<!--Password-->
@unless(isset($user))
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            @include('components.form.input.password', ['name' => 'password', 'label' => 'Password'])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            @include('components.form.input.password', ['name' => 'password_confirm', 'label' => 'Confirm Password'])
        </div>
    </div>
@endunless

<!--Role and TUSC ID-->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'role_id', 'label' => 'Select Role', 'options' => $roles, 'selected' => isset($user)? $user->role_id:null ])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'tusc_id', 'label' => 'TUSC ID', 'value' => isset($user)? $user->tusc_id:null ])
    </div>
</div>

<h3 class="card-inside-title">Additional Information</h3>
<!--AGB ID and Student Status-->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'agb_id', 'label' => 'AGB ID', 'value' => isset($user)? $user->agb_id:null ])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.checkbox', ['name' => 'is_student', 'label' => 'Current Student?', 'checked' => isset($user)? $user->is_student:true, 'colour' => 'orange' ])
    </div>
</div>

@include('components.form.button.submit', ['colour' => 'btn-primary', 'label' => $submitLabel])

{{--Required Styles--}}
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker.css') }}">
@endpush

{{--Required Scripts--}}
@push('scripts')
<script src="{{ asset('js/jquery-cropit.js') }}"></script>
<script>
    // Image editor
    var imageEditor = {
        element: '.image-editor',
        previewElement: '.cropit-preview',
        hasChanged: false,
        start: function(){
            var $editor = $(this.element);

            $editor.cropit({
                height: 200,
                width: 200,
                smallImage: 'allow',
                imageState: {
                    src: '{{ isset($user) && $user->picture_url? $user->picture_url:asset('img/user-profile-default.png') }}'
                },
                onImageError: function(error){
                    swal('Whoops!', 'Looks like something went wrong. If this happens again, please report it.', 'error');
                },
                onOffsetChange: function(offset){
                    if(0 != offset.x && 0 != offset.y){
                        imageEditor.hasChanged = true;
                    }
                }
            });

            $('.rotate-cw').click(function() {
                $editor.cropit('rotateCW');
            });
            $('.rotate-ccw').click(function() {
                $editor.cropit('rotateCCW');
            });
            $('.change-image').click(function(){
                $('.cropit-image-input').click();
            });
        },
        setImageData: function(){
            var imageData = $(this.element).cropit('export');
            $('.hidden-image-data').val(imageData);
        }
    };

    // Date/Time Picker
    var dateTimePicker = {
        start: function(){
            // Birth date picker
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: false,
                weekStart: 1,
                time: false,
                maxDate: moment().subtract(16, 'years')
            });

            @if(isset($user) && $user->birth_date)
            $('.datetimepicker').bootstrapMaterialDatePicker('setDate', '{{ $user->birth_date->format('Y-m-d') }}');
            @endif
        }
    };

    // Ready!
    $(function(){
        imageEditor.start();
        dateTimePicker.start();

        $('#user_form').on('submit', function(e){
            if(imageEditor.hasChanged){
                imageEditor.setImageData();
            }

            return true;
        });

        //Tooltip
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });

        //Popover
        $('[data-toggle="popover"]').popover();
    });
</script>
@endpush