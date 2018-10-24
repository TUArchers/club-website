@extends('layouts.admin')

@section('title', 'Event Invites')

@section('content')
    <div class="block-header">
        <h2>
            EVENT INVITES <br>
            <small>All event invitations issued, both expired and active</small>
        </h2>
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
                            <th>Email</th>
                            <th>Event(s)</th>
                            <th>Invited</th>
                            <th>Expires</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($invites as $invite)
                            <tr>
                                <td><img src="{{ $invite->user->picture_url?: asset('img/user-profile-default.png') }}" alt="{{ $invite->user->name }}'s profile picture" class="img-circle" style="max-width: 50px;"></td>
                                <td><a href="{{ route('admin.users.show', $invite->user->id) }}">{{ $invite->user->name }}</a></td>
                                <td>{{ $invite->email }}</td>
                                <td>{{ $invite->event_names }}</td>
                                <td>{{ $invite->created_at->toFormattedDateString() }}</td>
                                <td>{{ $invite->expires_at->toFormattedDateString() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center">No event invitations sent. Boooo!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection