@extends('layouts.admin')

@section('title', 'Add Member')

@section('content')
    <div class="block-header">
        <h2>USER MANAGEMENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>ADD USER</h2>
                </div>
                <div class="body">
                    <form action="{{ route('users.store') }}" method="post">
                        @include('admin.users._form', ['submitLabel' => 'Add User'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection