@extends('layouts.master')

@section('title', 'Choose A Taster Session')

@section('content')
    <form action="/join/taster/reserve" method="post">
        {{ csrf_field() }}

        <select name="event_id" id="event_select">
            <option value="" selected disabled>Choose a session...</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}" @if($event->spacesRemaining < 1) disabled @endif>{{ $event->name }} ({{ $event->spacesRemaining }} spaces)</option>
            @endforeach
        </select>

        <button type="submit">Next</button>
    </form>
@endsection