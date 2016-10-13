@extends('layouts.admin')

@section('title', 'Users')

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
                                <li><a href="{{ route('admin.users.create') }}"><i class="material-icons">add</i> Add User</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive">
                    <table class="table table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>TUSC ID</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th><i class="material-icons">build</i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tusc_id?:'N/A' }}</td>
                                <td>{{ $user->role->name}}</td>
                                <td>{{ $user->registered_at->toFormattedDateString() }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', [$user->id]) }}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                    @if(1 != $user->id)
                                        <form style="display: inline-block;" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-alert-type="confirm" data-user-name="{{ $user->first_name }}">
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
        $('.dataTable').DataTable();

        $('button[data-alert-type="confirm"]').on('click', function(e){
            e.preventDefault();

            var $form = $(this).closest('form');
            var $user = $(this).data('user-name');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover " + $user + "'s account!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fb483a",
                confirmButtonText: "Yes, delete them!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $form.submit();
                } else {
                    swal("Cancelled", $user + " is safe :)", "error");
                }
            });
        })
    });
</script>
@endpush