{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'name', 'label' => 'Name', 'value' => isset($role)? $role->name:null ])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.textarea', ['name' => 'description', 'label' => 'Description', 'rows' => 1, 'value' => isset($role)? $role->descrption:null ])
    </div>
</div>

<h3 class="card-inside-title">Permissions</h3>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'parent_id', 'label' => 'Inherits from', 'disabled' => (isset($role) && $role->has_full_access), 'options' => $other_roles, 'option_value' => 'id', 'option_name' => 'name'])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.checkbox', ['name' => 'has_full_access', 'label' => 'Grant all permissions', 'colour' => 'deep-orange', 'checked' => isset($role) && $role->has_full_access])
    </div>
</div>

<div id="permission_list" class="row clearfix">
@foreach($permission_groups as $group => $permissions)
    <div class="permission-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
    	<p>{{ ucfirst($group) }} Actions</p>

        @foreach($permissions as $permission)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @if(isset($role))
                    @include('components.form.input.checkbox', [
                         'id'            => $permission->slug,
                         'name'          => 'permissions[]',
                         'label'         => $permission->name,
                         'colour'        => ($role->hasInheritedPermission($permission) || $role->has_full_access)? null:'deep-orange',
                         'classes'       => $role->hasInheritedPermission($permission)? 'inherited':'assigned',
                         'checked_value' => $permission->id,
                         'checked'       => $role->hasPermission($permission),
                         'disabled'      => ($role->hasInheritedPermission($permission) || $role->has_full_access)])
                @else
                    @include('components.form.input.checkbox', ['id' => $permission->slug, 'name' => 'permissions[]', 'label' => $permission->name, 'colour' => 'deep-orange', 'checked_value' => $permission->id])
                @endif
            </div>
        @endforeach
    </div>
@endforeach
</div>

@include('components.form.button.submit', ['colour' => 'btn-primary', 'label' => $submitLabel])

@push('scripts')
<script>
    $(function(){
        $('#has_full_access_checkbox').on('change', function(){
            if($(this).is(':checked')){
                $('#permission_list')
                        .find('input[type=checkbox].assigned')
                        .prop('disabled', true)
                        .removeClass('chk-col-deep-orange');

                $('#parent_id_select').prop('disabled', true).val('').selectpicker('refresh');
            }
            else{
                $('#permission_list')
                        .find('input[type=checkbox]:not(.inherited)')
                        .prop('disabled', false)
                        .addClass('chk-col-deep-orange');

                $('#parent_id_select').prop('disabled', false).selectpicker('refresh');
            }
        });
    });
</script>
@endpush