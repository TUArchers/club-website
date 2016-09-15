{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group form-float">
            <div class="form-line {{ isset($role) && !is_null($role->name)? 'focused':''}}">
                <input type="text" id="name_input" name="name" class="form-control" title="Name" @if(isset($role))value="{{ $role->name }}"@endif>
                <label class="form-label" for="name_input">Name</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group form-float">
            <div class="form-line {{ isset($role) && !is_null($role->description)? 'focused':''}}">
                <textarea name="description" id="description_textarea" class="form-control no-resize" rows="1">@if(isset($role)){{ $role->description }}@endif</textarea>
                <label class="form-label" for="description_textarea">Description</label>
            </div>
        </div>
    </div>
</div>

<h3 class="card-inside-title">Permissions</h3>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <select name="parent_id" id="parent_select" class="form-control show-tick" title="Inherits from" {{ isset($role) && $role->has_full_access? 'disabled': null }}>
            <option value="" disabled>-- Inherits from --</option>
            @foreach($other_roles as $other_role)
                <option value="{{ $other_role->id }}" {{ isset($role) && $role->parent == $other_role? 'selected' : null }}>{{ $other_role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <input type="checkbox" id="full_access_checkbox" name="has_full_access" value="1" class="filled-in chk-col-deep-orange" {{ isset($role) && $role->has_full_access? 'checked' : null }}>
        <label for="full_access_checkbox" class="form-label">Grant all permissions</label>
    </div>
</div>

<div id="permission_list" class="row clearfix">
@foreach($permission_groups as $group => $permissions)
    <div class="permission-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
    	<p>{{ ucfirst($group) }} Actions</p>

        @foreach($permissions as $permission)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @if(isset($role))
                    <input type="checkbox" id="{{ $permission->slug }}_checkbox" name="permissions[]" value="{{ $permission->id }}"
                           class="filled-in {{ $role->hasInheritedPermission($permission)? 'inherited': ($role->has_full_access? 'assigned': 'assigned chk-col-deep-orange') }}"
                            {{ $role->hasPermission($permission)? 'checked':null }}
                            {{ $role->hasInheritedPermission($permission) || $role->has_full_access? 'disabled':null }}>
                @else
                    <input type="checkbox" id="{{ $permission->slug }}_checkbox" name="permissions[]" value="{{ $permission->id }}" class="filled-in chk-col-deep-orange">
                @endif
                <label for="{{ $permission->slug }}_checkbox" class="form-label">{{ $permission->name }}</label>
            </div>
        @endforeach
    </div>
@endforeach
</div>

<button type="submit" class="btn btn-primary m-t-15 waves-effect">{{ $submitLabel }}</button>

@push('scripts')
<script>
    $(function(){
        $('#full_access_checkbox').on('change', function(){
            if($(this).is(':checked')){
                $('#permission_list')
                        .find('input[type=checkbox].assigned')
                        .prop('disabled', true)
                        .removeClass('chk-col-deep-orange');

                $('#parent_select').prop('disabled', true).val('').selectpicker('refresh');
            }
            else{
                $('#permission_list')
                        .find('input[type=checkbox]:not(.inherited)')
                        .prop('disabled', false)
                        .addClass('chk-col-deep-orange');

                $('#parent_select').prop('disabled', false).selectpicker('refresh');
            }
        });
    });
</script>
@endpush