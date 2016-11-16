@extends('layouts.admin')

@section('title', 'Scoring Summary')

@section('content')
    <div class="block-header">
        <h2>SCORE SUMMARY</h2>
    </div>
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            @include('components.infobox', ['colour' => 'teal', 'icon' => 'grade', 'title' => 'SCORES RECORDED', 'value' => $all_scores])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
        	@include('components.infobox', ['colour' => 'green', 'icon' => 'trending_up', 'title' => 'SCORES THIS YEAR', 'value' => $yearly_scores])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            @include('components.infobox', ['colour' => 'light-green', 'icon' => 'event', 'title' => 'SCORES THIS MONTH', 'value' => $monthly_scores])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            @include('components.infobox', ['colour' => 'lime', 'icon' => 'new_releases', 'title' => 'SCORES THIS WEEK', 'value' => $weekly_scores])
        </div>
    </div>

    <div class="block-header">
        <h2>SCORE STATISTICS</h2>
    </div>
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Bow Classes
                    <small>Number of scores recorded for each bow class</small></h2>
                </div>
                <div class="body">
                    @include('components.chart.donut', ['id' => 'bow_class', 'height' => 150, 'data' => $bow_class_popularity, 'label_property' => 'bow_class.name', 'value_property' => 'count'])
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Rounds
                        <small>Number of scores recorded for each round</small></h2>
                </div>
                <div class="body">
                    @include('components.chart.donut', ['id' => 'round', 'height' => 150, 'data' => $round_popularity, 'label_property' => 'name', 'value_property' => 'count'])
                </div>
            </div>
        </div>
    </div>

    <div class="block-header">
        <h2>SCORE LOG</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">history</i> Recent Scores
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    	<table class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>Date</th>
                    				<th>Archer</th>
                    				<th class="hidden-sm hidden-xs">Bow Class</th>
                    				<th>Round</th>
                    				<th>Score</th>
                    				<th class="hidden-sm hidden-xs">%</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                            @foreach($recent_scores as $score)
                    			<tr>
                    				<td>{{ $score->shot_at->toFormattedDateString() }}</td>
                    				<td>{{ $score->archer->name }}</td>
                    				<td class="hidden-sm hidden-xs">{{ $score->bow_class->name }}</td>
                    				<td>{{ $score->round->name }}</td>
                    				<td>{{ $score->total_score }} <span class="col-grey">/ {{ $score->round->max_score }}</span></td>
                    				<td class="hidden-sm hidden-xs">@include('components.progress', ['value' => round(($score->total_score/$score->round->max_score)*100), 'classes' => 'bg-green'])</td>
                    			</tr>
                            @endforeach
                    		</tbody>
                    	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="header">
                    <h2>
                        <i class="material-icons media-middle">assignment_turned_in</i> E-League Scores
                    </h2>
                </div>
                <div class="body">
                    <!--Nav Tabs-->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    @foreach($eleague_scores as $stage_number => $stage)
                        <li role="presentation" {{ 0 == $loop->index? 'class=active':null }}>
                            <a href="#stage_{{ $stage_number }}_panel" data-toggle="tab">
                                STAGE {{ $stage_number }} ({{ $stage['name'] }})
                            </a>
                        </li>
                    @endforeach
                    </ul>

                    <!--Panes-->
                    <div class="tab-content">
                    @foreach($eleague_scores as $stage_number => $stage)
                        <div id="stage_{{ $stage_number }}_panel" role="tabpanel" class="tab-pane animated fadeIn{{ 0 == $loop->index? ' active':null }}">
                            <h3 class="card-inside-title">Team Scores</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Team</th>
                                        <th>Score</th>
                                        <th>Mean Score</th>
                                        <th class="hidden-xs">Members</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stage['teams'] as $name => $team)
                                        @if($team->total_score > 0)
                                            <tr>
                                                <td>{{ $name }}</td>
                                                <td>{{ $team->total_score }}</td>
                                                <td>{{ round($team->total_score/$team->size) }}</td>
                                                <td class="hidden-xs">{{ implode(', ', $team->members) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @if(count($stage['scores']) < 1)
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No team results to show for this stage
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <h3 class="card-inside-title">Individual Scores</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Archer</th>
                                        <th>Level</th>
                                        <th class="hidden-sm hidden-xs">Bow Class</th>
                                        <th class="hidden-sm hidden-xs">Round</th>
                                        <th>Score</th>
                                        <th class="hidden-sm hidden-xs">%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($stage['scores'] as $score)
                                        <tr {{ $score->created_at->gt($stage['end'])? 'class=col-red':null }}>
                                            <td>{{ $score->shot_at->toFormattedDateString() }}</td>
                                            <td>{{ $score->archer_name }}</td>
                                            <td>{{ $score->experience_level }}</td>
                                            <td class="hidden-sm hidden-xs">{{ $score->bow_class }}</td>
                                            <td class="hidden-sm hidden-xs">{{ $score->round_name }}</td>
                                            <td>{{ $score->total_score }} <span class="col-grey hidden-xs">/ {{ $score->round_max_score }}</span></td>
                                            <td class="hidden-sm hidden-xs">@include('components.progress', ['value' => round(($score->total_score/$score->round_max_score)*100), 'classes' => 'bg-green'])</td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                No results to show for this stage
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection