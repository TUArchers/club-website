@extends('layouts.error')

@section('code', 403)

@section('title', 'You Can\'t Do That!')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'This section requires adult supervision. Go find one.' }}
@endsection