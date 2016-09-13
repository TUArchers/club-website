@extends('layouts.error')

@section('code', 404)

@section('title', 'Not Found')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'You missed! Have another shot.' }}
@endsection