@extends('layouts.admin')

@section('title', 'Committee Tools')

@section('content')
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alert bg-blue-grey">
                <strong>Information: </strong>{!! $message !!}
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-teal">
                    <div class="font-bold m-b--35">
                        UPCOMING EVENTS
                    </div>
                    <ul class="dashboard-stat-list">
                        @forelse($events as $event)
                            <li>{{ $event->name }} <span class="pull-right">{{ $event->starts_at->format('D jS \a\t g:ia') }}</span></li>
                        @empty
                            <li>None... stick your feet up</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-blue">
                    <div class="font-bold m-b--35">
                        RECENT SCORES
                    </div>
                    <ul class="dashboard-stat-list">
                        @foreach($scores as $score)
                            <li>{{ $score->total_score }} <small>{{ strtoupper($score->round->name) }}</small> <span class="pull-right">{{ $score->archer->name }} <small>{{ strtoupper($score->bow_class->name) }}</small></span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="body bg-green">
                    <div class="font-bold m-b--35">
                        ACTIVE USERS
                    </div>
                    <ul class="dashboard-stat-list">
                        @foreach($users as $user)
                            <li>{{ $user->name }} <span class="pull-right">{{ $user->updated_at->format('D jS \a\t g:ia') }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection