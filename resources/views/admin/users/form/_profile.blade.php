<form id="profile_form" action="{{ $action }}" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">person</i> Profile
            </h2>
        </div>
        <div class="body">
            <div class="row clearfix">
                <!--Picture-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
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

                <!--Name, Gender and Birth Date-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.input.text', ['name' => 'first_name', 'label' => 'First Name', 'value' => isset($user)? $user->first_name:null ])
                    @include('components.form.input.text', ['name' => 'last_name', 'label' => 'Last Name', 'value' => isset($user)? $user->last_name:null ])
                    @include('components.form.select', ['name' => 'gender', 'label' => 'Select Gender', 'options' => $genders, 'selected' => isset($user)? $user->gender->id:null ])
                    @include('components.form.input.datetime', ['name' => 'birth_date', 'label' => 'Birth Date', 'value' => isset($user) && $user->birth_date? $user->birth_date->format('Y-m-d'):null ])
                </div>

                <div class="clearfix"></div>

                <!--Contact Details-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <h3 class="card-inside-title">Contact Details</h3>
                    @include('components.form.input.text', ['name' => 'phone', 'label' => 'Phone Number', 'value' => isset($user)? $user->phone:null ])
                </div>

                <!--Status-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <h3 class="card-inside-title">Status</h3>
                    @include('components.form.select', ['name' => 'experience_level', 'label' => 'Select Experience Level', 'options' => $experience_levels, 'selected' => isset($user)? $user->experience_level->id:null ])
                    @include('components.form.input.checkbox', ['name' => 'is_student', 'label' => 'Has student status', 'checked' => isset($user)? $user->is_student:true, 'colour' => 'orange' ])
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

    // Profile form
    var profileForm = {
        element: '#profile_form',
        ready: function(){
            // Enable image editor
            imageEditor.start();

            // Enable date/time picker
            $(this.element).find('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: false,
                weekStart: 1,
                time: false,
                maxDate: moment().subtract(16, 'years')
            });

            // Ensure image data is copied
            $(this.element).on('submit', function(){
                if(imageEditor.hasChanged){
                    imageEditor.setImageData();
                }
                return true;
            });
        }
    };
</script>
@endpush