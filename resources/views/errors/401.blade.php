@extends('layouts.error')

@section('code', 401)

@section('title', 'You Can\'t Do That!')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'You found a super secret section. Ssshhh! Don\'t tell anyone!' }}
@endsection