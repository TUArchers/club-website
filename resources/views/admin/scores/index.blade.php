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