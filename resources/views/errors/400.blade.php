@extends('layouts.error')

@section('code', 400)

@section('title', 'Err... What?')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'We don\'t understand the request you just made. It\'s probably just us being derpy.' }}
@endsection