@extends('layouts.admin')

@section('title', $round->name . ' | Rounds')

@section('content')
    <div class="block-header">
        <h2>
            {{ strtoupper($round->name) }}<br/>
            <small>{{ $round->organisation->name }} {{ $round->season->name }} Round</small>
        </h2>
        {{--<ul class="header-dropdown m-r-10">--}}
            {{--<li class="dropdown">--}}
                {{--<a href="javascript:void(0);" class="dropdown-toggle no-hover" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
                    {{--<i class="material-icons">more_vert</i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu pull-right">--}}
                    {{--<li><a href="{{ route('admin.users.edit', $user->id) }}" class=" waves-effect waves-block">Edit User Profile</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}
    </div>

    <div class="row clearfix">
        <!--Rounds Details Column-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <!--Basic Information-->
        	<div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">details</i> Round Details
                    </h2>
                </div>
                <div class="body">
                    <div class="p-l-30">
                        <dl class="dl-horizontal">
                            <dt>Organisation</dt>
                            <dd>{{ $round->organisation->name }}</dd>

                            <dt>Season</dt>
                            <dd>{{ $round->season->name }}</dd>

                            <dt>Scoring System</dt>
                            <dd>{{ $round->scoring_system }}</dd>

                            <dt>Distances</dt>
                            <dd>{{ $round->total_targets }}</dd>

                            <dt>Total Shots</dt>
                            <dd>{{ $round->total_shots }}</dd>

                            <dt>Maximum Score</dt>
                            <dd>{{ $round->max_score }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{--<!--Distances-->--}}
            {{--<div class="card">--}}
                {{--<div class="header">--}}
                    {{--<h2>--}}
                        {{--<i class="material-icons media-middle">label</i> Distances--}}
                    {{--</h2>--}}
                {{--</div>--}}
                {{--<div class="body">--}}
                    {{--//--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>

        <!--Associated Scores Column-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <!--Record Holders-->
        	<div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">bookmark</i> Record Holders
                    </h2>
                </div>
                <div class="body">
                    <ul class="list-unstyled list-scores">
                        @foreach($record_scores as $score)
                            <li>
                                <div class="date">{{ $score->shot_at->toFormattedDateString() }}</div>
                                <div class="details">
                                    <strong>{{ $score->total_score }}</strong> <span class="col-grey">/ {{ $score->round->max_score }}</span><br>
                                    @if(!$score->archer)
                                        <s>Deleted User</s>
                                    @else
                                        <a href="{{ route('admin.users.show', $score->archer_id) }}" class="no-hover">{{ $score->archer->name }}</a>
                                    @endif
                                </div>
                                <div class="bow-style">
                                    <span class="badge bg-{{ $score->bow_class->colour }}">{{ $score->bow_class->name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!--Recent Scores-->
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">history</i> Recent Scores
                    </h2>
                </div>
                <div class="body">
                    <ul class="list-unstyled list-scores">
                        @foreach($recent_scores as $score)
                            <li>
                                <div class="date">{{ $score->shot_at->toFormattedDateString() }}</div>
                                <div class="details">
                                    <strong>{{ $score->total_score }}</strong> <span class="col-grey">/ {{ $score->round->max_score }}</span><br>
                                    @if(!$score->archer)
                                        <s>Deleted User</s>
                                    @else
                                        <a href="{{ route('admin.users.show', $score->archer_id) }}" class="no-hover">{{ $score->archer->name }}</a>
                                    @endif
                                </div>
                                <div class="bow-style">
                                    <span class="badge bg-{{ $score->bow_class->colour }}">{{ $score->bow_class->name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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