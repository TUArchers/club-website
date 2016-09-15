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
                                <li><a href="{{ route('roles.create') }}"><i class="material-icons">add</i> Add Role</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive">
                    <table class="table table-striped table-hover">
                    	<thead>
                    		<tr>
                    			<th>Name</th>
                    			<th>Inherits From</th>
                    			<th>Permissions</th>
                                <th><i class="material-icons">build</i></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->parent? $role->parent->name : '-' }}</td>
                                <td>
                                @if($role->has_full_access)
                                    <span class="badge bg-grey">All</span>
                                @else
                                    <span class="badge bg-green">{{ $role->all_permissions->count() }}</span>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
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