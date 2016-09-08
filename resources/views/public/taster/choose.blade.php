@extends('layouts.master')

@section('title', 'Choose A Taster Session')

@section('content')
    @foreach($events as $event)
        <form action="/join/taster/reserve" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div>
                <strong>{{ $event->name }}</strong>
            </div>
            <div>
                {{ $event->starts_at->format('H:i') }} <br>
                {{ $event->duration }} mins<br>
                {{ $event->spacesRemaining }} spaces left
            </div>
            <div>
                @unless($event->is_full)
                    <button type="submit">Choose</button>
                @endunless
            </div>
        </form>
        <hr>
    @endforeach
@endsection