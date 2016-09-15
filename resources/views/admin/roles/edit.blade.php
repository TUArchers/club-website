@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
    <div class="block-header">
        <h2>ROLE MANAGEMENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>EDIT ROLE</h2>
                </div>
                <div class="body">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        {{ method_field('PATCH') }}
                        @include('admin.roles._form', ['submitLabel' => 'Save Changes'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection