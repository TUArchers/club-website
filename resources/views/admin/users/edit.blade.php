@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="block-header">
        <h2>USER MANAGEMENT</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>EDIT USER</h2>
                </div>
                <div class="body">
                    <form id="user_form" action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @include('admin.users._form', ['submitLabel' => 'Save Changes'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection