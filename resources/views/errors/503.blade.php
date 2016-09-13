@extends('layouts.error')

@section('code', 503)

@section('title', 'Temporarily Unavailable')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'Don\'t worry, things will be back online in a jiffy!' }}
@endsection