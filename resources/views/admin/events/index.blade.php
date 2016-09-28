@extends('layouts.admin')

@section('title', 'Event Schedule')

@section('content')
    <div class="block-header">
        <h2>TODAY'S EVENTS</h2>
    </div>
    <div class="row clearfix">
        @each('admin.events._event', $events_today, 'event', 'admin.events._empty')
    </div>

    <div class="block-header">
        <h2>THIS WEEK'S EVENTS</h2>
    </div>
    <div class="row clearfix">
        @each('admin.events._event', $events_week, 'event', 'admin.events._empty')
    </div>

    <div class="block-header">
        <h2>MORE EVENTS</h2>
    </div>
    <div class="row clearfix">
        @each('admin.events._event', $events_future, 'event', 'admin.events._empty')
    </div>
@endsection