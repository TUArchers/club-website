@extends('layouts.admin')

@section('title', 'Define Round')

@section('content')
    <div class="block-header">
        <h2>
            DEFINE A ROUND <br>
            <small>Define a new round for people to use when scoring</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="body">
                    <form action="{{ route('admin.rounds.store') }}" method="post">
                        @include('admin.rounds._form', ['submitLabel' => 'Define'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection