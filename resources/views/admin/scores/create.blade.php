@extends('layouts.admin')

@section('title', 'Record Score')

@section('content')
    <div class="block-header">
        <h2>SCORE MANAGEMENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>RECORD SCORE</h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.scores.store') }}" method="post">
                        @include('admin.scores._form', ['submitLabel' => 'Record'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker.css') }}">
@endpush