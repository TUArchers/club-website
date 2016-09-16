@extends('layouts.error')

@section('code', 405)

@section('title', 'We can\'t do that!')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): "We don't know how to do that. Maybe one day we'll learn..." }}
@endsection