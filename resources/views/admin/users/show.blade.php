@extends('layouts.admin')

@section('title', $user->name . ' | Users')

@section('content')
    <div class="block-header">
        <h2>
            {{ strtoupper($user->name) }}<br/>
            <small>{{ $user->role->name }}</small>
        </h2>
        <ul class="header-dropdown m-r-10">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle no-hover" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">more_vert</i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ route('admin.users.edit', $user->id) }}" class=" waves-effect waves-block">Edit User Profile</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="row clearfix">
        <!--Identity Column-->
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">

            <!--Image and Contact Details-->
            <div class="card">
                <div class="body">
                    <img src="{{ $user->picture_url?: asset('img/user-profile-default.png') }}" alt="{{ $user->name }}'s profile picture" class="img-circle img-thumbnail center-block m-b-10">
                    <p class="text-center font-20 m-b-40">
                        @if('E' == $user->experience_level->id)
                            <span class="label bg-brown">{{ $user->experience_level->name }}</span>
                        @elseif('N' == $user->experience_level->id)
                            <span class="label bg-orange">{{ $user->experience_level->name }}</span>
                        @else
                            <span class="label bg-green">{{ $user->experience_level->name }}</span>
                        @endif
                    </p>
                    <h2 class="card-inside-title">Contact</h2>
                    <ul class="list-unstyled">
                        <li class="m-b-10">
                            <a href="mailto: {{ $user->email }}" class="no-hover">
                                <i class="material-icons font-18 media-middle m-r-10">email</i> {{ $user->email }}
                            </a>
                        </li>
                        <li class="m-b-10">
                            <a href="tel: {{ $user->phone }}" class="no-hover">
                                <i class="material-icons font-18 media-middle m-r-10">phone</i> {{ $user->phone }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--Information Column-->
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-5">
            <!--Basic Information-->
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">person</i> Basic Information
                    </h2>
                </div>
                <div class="body">
                    <div class="p-l-30">
                        <dl class="dl-horizontal">
                            <dt>Full Name</dt>
                            <dd>{{ $user->name }}</dd>

                            <dt>Gender</dt>
                            <dd>{{ $user->gender->name }}</dd>
                            @if($user->birth_date)

                                <dt>Birthday</dt>
                                <dd>{{ $user->birth_date->toFormattedDateString() }} ({{ $user->age }} <small>years old</small>)</dd>
                            @endif

                            <dt>Student Status</dt>
                            <dd>{{ $user->is_student? 'Student':'Non-Student' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!--Emergency Contact-->
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">contacts</i> Emergency Contact
                    </h2>
                </div>
                <div class="body">
                    @if(!$emergency_contact)
                        @include('components.empty', ['iconName' => 'warning', 'iconColour' => 'orange', 'message' => "Hmm... there doesn't seem to be an emergency contact on record for {$user->first_name }."])
                    @else
                    <div class="p-l-30">
                        <dl class="dl-horizontal">
                            <dt>Name</dt>
                            <dd>{{ $emergency_contact->name }}</dd>

                            <dt>Relationship</dt>
                            <dd>{{ $emergency_contact->relationship }}</dd>

                            <dt>Phone Number</dt>
                            <dd><a href="tel: {{ $emergency_contact->phone }}" class="no-hover">{{ $emergency_contact->phone }}</a></dd>

                            <dt>Email Address</dt>
                            <dd><a href="mailto: {{ $emergency_contact->email }}" class="no-hover">{{ $emergency_contact->email }}</a></dd>

                            <dt>Address</dt>
                            <dd><a href="http://map.google.com?q={{ $emergency_contact->address }}" class="no-hover" target="_blank">{{ $emergency_contact->address }}</a></dd>
                        </dl>
                    </div>
                    @endif
                </div>
            </div>

            <!--Memberships-->
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">card_membership</i> Memberships
                    </h2>
                </div>
                <div class="body">
                    @if($memberships->isEmpty())
                        @include('components.empty', ['iconName' => 'assignment', 'message' => "{$user->first_name} has no known memberships. They must be a spy."])
                    @else

                    @endif
                    <ul class="list-unstyled list-memberships">
                    @foreach($memberships as $membership)
                        <li>
                            <div class="number">{{ $membership->number }}</div>
                            <div class="details">
                                <strong>{{ $membership->organisation->name }}</strong>
                                @if($membership->description) <br> {{ $membership->description }}@endif
                                <br><span class="col-grey">{{ $membership->is_valid? 'Valid until ': 'Expired on ' }} {{ $membership->expires_at->toFormattedDateString() }}</span>
                            </div>
                            <div class="validity">
                                <span class="badge {{ $membership->is_valid? 'bg-green':'bg-red' }}">{{ $membership->is_valid? 'Valid':'Expired' }}</span>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!--Scores Column-->
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-4 col-sm-offset-4 col-md-offset-3 col-lg-offset-0">
            <!--Personal Bests-->
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">bookmark</i> Personal Best Scores
                    </h2>
                </div>
                <div class="body">
                    @if($personal_bests->isEmpty())
                        @include('components.empty', ['iconName' => 'assignment', 'message' => "There are no personal bests on record for {$user->first_name}. How tragic."])
                    @else
                        <ul class="list-unstyled list-scores">
                            @foreach($personal_bests as $score)
                                <li>
                                    <div class="date">{{ $score->shot_at->toFormattedDateString() }}</div>
                                    <div class="details">
                                        <strong>{{ $score->total_score }}</strong> <span class="col-grey">/ {{ $score->round->max_score }}</span><br>
                                        <a href="{{ route('admin.rounds.show', $score->round_id) }}" class="no-hover">{{ $score->round->name }}</a>
                                    </div>
                                    <div class="bow-style">
                                        <span class="badge bg-{{ $score->bow_class->colour }}">{{ $score->bow_class->name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!--Recently Scored-->
        	<div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">history</i> Recent Scores
                    </h2>
                </div>
                <div class="body">
                    @if($recent_scores->isEmpty())
                        @include('components.empty', ['iconName' => 'assignment', 'message' => "There are no scores on record for {$user->first_name}. Lazy."])
                    @else
                        <ul class="list-unstyled list-scores">
                            @foreach($recent_scores as $score)
                                <li>
                                    <div class="date">{{ $score->shot_at->toFormattedDateString() }}</div>
                                    <div class="details">
                                        <strong>{{ $score->total_score }}</strong> <span class="col-grey">/ {{ $score->round->max_score }}</span><br>
                                        <a href="{{ route('admin.rounds.show', $score->round_id) }}" class="no-hover">{{ $score->round->name }}</a>
                                    </div>
                                    <div class="bow-style">
                                        <span class="badge bg-{{ $score->bow_class->colour }}">{{ $score->bow_class->name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
    });
</script>
@endpush