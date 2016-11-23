@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="block-header">
        <h2>ALL CONTACTS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="body table-responsive">
                    <table class="table table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Experience Level</th>
                            <th>Joined</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><img src="{{ $user->picture_url?: asset('img/user-profile-default.png') }}" alt="{{ $user->name }}'s profile picture" class="img-circle" style="max-width: 50px;"></td>
                                <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->role->name}}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->experience_level->name }}</td>
                                <td>{{ $user->registered_at->toFormattedDateString() }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.users.edit', [$user->id]) }}" class="btn btn-link btn-circle waves-effect waves-circle">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                    @if(1 != $user->id)
                                        <form style="display: inline-block;" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-link btn-circle waves-effect waves-circle" data-alert-type="confirm" data-user-name="{{ $user->first_name }}">
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
        $('.dataTable').DataTable({
            "columnDefs": [
                { "targets": [0, 6], "orderable": false, "searchable": false }
            ],
            "order": [[ 1, 'asc']]
        });

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