@extends('layouts.email')

@section('title', 'Your Reservation Confirmation')

@section('content')
    {{--Logo and Header--}}
    @include('mail.components.media-left', ['src' => '', 'title' => '', 'body' => ''])
    {{--Date and Time--}}
    @include('mail.components.date-right-box', ['month' => '', 'day' => '', 'title' => '', 'body' => ''])
    {{--Important Stuff--}}
    @include('mail.components.full-width', ['title' => '', 'body' => ''])
    {{--Cancellations--}}
    @include('mail.components.full-width', ['title' => '', 'body' => ''])
@endsection