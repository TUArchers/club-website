@extends('layouts.admin')

@section('title', 'Round Definitions')

@section('content')
    <div class="block-header">
        <h2>ROUND DEFINITIONS</h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="body table-responsive">
                    <table class="table table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Organisation</th>
                            <th>Season</th>
                            <th>Max Score</th>
                            <th>Multi-Distance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rounds as $round)
                            <tr>
                                <td><a href="{{ route('admin.rounds.show', $round->id) }}">{{ $round->name }}</a></td>
                                <td>{{ $round->organisation->name }}</td>
                                <td>{{ $round->season->name }}</td>
                                <td>{{ $round->max_score }}</td>
                                <td>{{ $round->is_multi_distance? 'Yes':'No' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('.dataTable').DataTable();
    });
</script>
@endpush