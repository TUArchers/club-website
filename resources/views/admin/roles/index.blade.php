@extends('layouts.admin')

@section('title', 'All Roles')

@section('content')
    <div class="block-header">
        <h2>ROLES</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL ROLES
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('admin.roles.create') }}"><i class="material-icons">add</i> Add Role</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive">
                    <table class="table table-striped table-hover">
                    	<thead>
                    		<tr>
                    			<th>Name</th>
                                <th class="hidden-xs hidden-sm">Description</th>
                    			<th class="hidden-xs">Inherits From</th>
                    			<th>Permissions</th>
                                <th><i class="material-icons">build</i></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td class="hidden-xs hidden-sm">{{ $role->description }}</td>
                                <td class="hidden-xs">{{ $role->parent? $role->parent->name : '-' }}</td>
                                <td>
                                @if($role->has_full_access)
                                    <span class="badge bg-grey">All</span>
                                @else
                                    <span class="badge bg-green">{{ $role->all_permissions->count() }}</span>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.roles.edit', [$role->id]) }}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                    @if(1 != $role->id)
                                        <form style="display: inline-block;" action="{{ route('admin.roles.destroy', $role->id) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-alert-type="confirm" data-role-name="{{ $role->name }}">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    	</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('button[data-alert-type="confirm"]').on('click', function(e){
            e.preventDefault();

            var $form = $(this).closest('form');
            var $role = $(this).data('role-name');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the \"" + $role + "\" role!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fb483a",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $form.submit();
                } else {
                    swal("Cancelled", $role + " is safe :)", "error");
                }
            });
        })
    });
</script>
@endpush