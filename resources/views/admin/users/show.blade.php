@extends('layouts.admin')

@section('title', $user->name . ' | Users')

@section('content')
    <div class="block-header">
        <h2>USERS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="header">
                    <h2>{{ strtoupper($user->name) }}'S PROFILE</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('admin.users.edit', $user->id) }}">Edit User Profile</a></li>
                                {{--<li><a href="#">Resend Welcome Email</a></li>--}}
                                {{--<li><a href="#">Reset Password</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">

                    <!--Basic Information-->
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                            <img src="{{ $user->picture_url?: asset('img/user-profile-default.png') }}" alt="{{ $user->name }}'s profile picture" class="img-circle img-thumbnail center-block">
                        </div>
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
                            <h3>
                                {{ $user->name }} <br />
                                <small>{{ $user->role->name }}</small>
                            </h3>
                            <p>
                                @if('E' == $user->experience_level->id)
                                    <span class="label bg-brown">{{ $user->experience_level->name }}</span>
                                @elseif('N' == $user->experience_level->id)
                                    <span class="label bg-orange">{{ $user->experience_level->name }}</span>
                                @else
                                    <span class="label bg-green">{{ $user->experience_level->name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!--Additional Information-->
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h4>Contact Information</h4>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    <i class="material-icons media-middle pull-right">email</i>
                                </li>
                                <li class="list-group-item">
                                    <span>{{ $user->phone }}</span>
                                    <i class="material-icons media-middle pull-right">phone</i>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h4>Additional Information</h4>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    @if($user->birth_date)
                                        <span>{{ $user->age }} <small>years old</small></span>
                                    @else
                                        <span>Unknown age</span>
                                    @endif
                                    <i class="material-icons media-middle pull-right">cake</i>
                                </li>
                                <li class="list-group-item">
                                    @if(in_array($user->gender->id, ['U', 'O']))
                                        <span>{{ $user->gender->name }} gender</span>
                                    @else
                                        <span>{{ $user->gender->name }}</span>
                                    @endif
                                    <i class="material-icons media-middle pull-right">label_outline</i>
                                </li>
                                <li class="list-group-item">
                                    <span>{{ $user->is_student? 'Student':'Non-Student' }}</span>
                                    <i class="material-icons media-middle pull-right">school</i>
                                </li>
                                <li class="list-group-item">
                                    <span>{{ $user->tusc_id?: 'Unknown' }} <small>(TUSC ID)</small></span>
                                    <i class="material-icons media-middle pull-right">perm_identity</i>
                                </li>
                                <li class="list-group-item">
                                    <span>{{ $user->agb_id?: 'Unknown' }} <small>(AGB Number)</small></span>
                                    <i class="material-icons media-middle pull-right">card_membership</i>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--Score History-->
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        	<h4>Recent Scores</h4>
                            <ul class="list-group">
                                @foreach($recent_scores as $score)
                                <li class="list-group-item">
                                    {{ $score->total_score }} <span class="col-grey">/ {{ $score->round->max_score }}</span> ({{ $score->round->name }} on {{ $score->shot_at->toFormattedDateString() }})
                                    <span class="badge bg-teal">{{ $score->bow_class->name }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        	<h4>Personal Best Scores</h4>
                            <ul class="list-group">
                                @foreach($personal_bests as $score)
                                    <li class="list-group-item">
                                        {{ $score->total_score }} <span class="col-grey">/ {{ $score->round_max_score }}</span> ({{ $score->round_name }})
                                        <span class="badge bg-teal">{{ \TuaWebsite\Domain\Records\BowClass::find($score->bow_class)->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection