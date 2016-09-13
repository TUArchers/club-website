@extends('layouts.error')

@section('code', 500)

@section('title', 'Something Went Wrong!')

@section('message')
    {{ isset($exception) && !empty($exception->getMessage())? $exception->getMessage(): 'Something broke. Sorry about that. Tell James he needs to fix it.' }}
@endsection