@extends('layouts.admin')

@section('title', 'Members')

@section('content')
    <div class="block-header">
        <h2>USERS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="header">
                    <h2>
                        ALL USERS
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ url('/admin/members/add') }}">Add User</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive">
                    <table class="table table-striped table-hover">
                    	<thead>
                    		<tr>
                    			<th>Name</th>
                    			<th>Email</th>
                    			<th>TUSC ID</th>
                    			<th>Role</th>
                    			<th>Joined</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->tusc_id?:'N/A' }}</td>
                                    <td>{{ $user->role->name}}</td>
                                    <td>{{ $user->registered_at->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                    	</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection