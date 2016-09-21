@extends('layouts.admin')

@section('title', 'Scoring Summary')

@section('content')
    <div class="block-header">
        <h2>SCORE SUMMARY</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        	@include('components.infobox', ['colour' => 'green', 'icon' => 'trending_up', 'title' => 'SCORES THIS YEAR', 'value' => $yearly_scores])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            @include('components.infobox', ['colour' => 'light-green', 'icon' => 'trending_up', 'title' => 'SCORES THIS MONTH', 'value' => $monthly_scores])
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
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
        <h2>CLUB RECORDS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        @foreach($records as $record)
            @include('components.infobox', ['colour' => 'red', 'icon' => 'star', 'title' => strtoupper($record->round->name), 'value' => $record->total_score])
        @endforeach
        </div>
    </div>
@endsection