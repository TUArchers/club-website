@extends('layouts.admin')

@section('title', 'Add Roles')

@section('content')
    <div class="block-header">
        <h2>ROLE MANAGEMENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>ADD ROLE</h2>
                </div>
                <div class="body">
                    <form action="{{ route('roles.store') }}" method="post">
                        @include('admin.roles._form', ['submitLabel' => 'Add Role'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection