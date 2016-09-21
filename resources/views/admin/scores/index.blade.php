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
        <h2>RECENT SCORES</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
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
                    				<td>{{ $score->archer->full_name }}</td>
                    				<td class="hidden-sm hidden-xs">{{ \TuaWebsite\Domain\Records\BowClass::find($score->bow_class)->name }}</td>
                    				<td>{{ $score->round->name }}</td>
                    				<td>{{ $score->total_score }} <span class="col-grey">/ {{ $score->round->max_score }}</span></td>
                    				<td class="hidden-sm hidden-xs">@include('components.progress', ['value' => round(($score->total_score/$score->round->max_score)*100), 'classes' => 'bg-deep-orange'])</td>
                    			</tr>
                            @endforeach
                    		</tbody>
                    	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection