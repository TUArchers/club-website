@extends('layouts.master')

@section('title', 'Reserve A Taster Session')

@section('content')
    <form action="/join/taster/reserve/confirm" method="post">
        {{ csrf_field() }}

        <input type="hidden" id="event_input" name="event_id" value="{{ $event_id }}">
        <input type="hidden" id="attendee_input" name="attendee_id" value="{{ $attendee_id }}">
        <p>
            Event: {{ $event_name }}
        </p>

        <input type="text" id="first_name_input" name="first_name" placeholder="First Name">
        <input type="text" id="last_name_input" name="last_name" placeholder="Last Name">
        <input type="email" id="email_input" name="email_address" placeholder="Email Address">
        <input type="text" id="phone_input" name="phone_number" placeholder="Phone Number">

        <button type="submit">Confirm</button>
    </form>
@endsection