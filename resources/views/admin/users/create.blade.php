@extends('layouts.admin')

@section('title', 'Register | Users')

@section('content')
    <div class="block-header">
        <h2>
            REGISTER PERSON <br>
            <small>Add a new member, past member or associate</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	@include('admin.users.form._register')
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        registerForm.ready();
    });
</script>
@endpush