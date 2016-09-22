@extends('layouts.admin')

@section('title', $event->name . ' (Event Details)')

@section('content')
    <!--Details-->
    <div class="block-header">
        <h2>EVENT DETAILS</h2>
    </div>
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>{{ $event->name }}<br><small>{{ $event->type->name }}</small></h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#" class=" waves-effect waves-block"><i class="material-icons">mode_edit</i> Edit event details</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <p>
                        <i class="material-icons media-middle">local_play</i> Hosted by Teesside University Archers
                    </p>
                    <p>
                        <i class="material-icons media-middle">access_time</i> {{ $event->starts_at->format('j F \a\t g:i A') }} - {{ $event->ends_at->format('g:i A') }}
                    </p>
                    <p>
                        <i class="material-icons media-middle">av_timer</i> {{ $event->duration }} minutes long
                    </p>
                    <p>
                        <i class="material-icons media-middle">location_on</i> {{ $event->location_name }}
                    </p>
                    @if($event->description)
                        <h4>Description</h4>
                        <p>
                            {{ $event->description }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>RESERVATIONS <br><small>{{ $event->spaces_remaining }} / {{ $event->capacity }} spaces remaining</small></h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#" class=" waves-effect waves-block"><i class="material-icons">add</i> Add reservation</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="list-group">
                        @foreach($reservations as $reservation)
                            @if($reservation->is_confirmed)
                                <li class="list-group-item">
                                    <i class="material-icons media-middle">person</i> {{ $reservation->attendee->full_name }}
                                    <span class="badge bg-green">ATTENDED</span>
                                </li>
                            @elseif($reservation->is_cancelled)
                                <li class="list-group-item">
                                    <i class="material-icons media-middle">person</i> {{ $reservation->attendee->full_name }}
                                    <span class="badge bg-red">CANCELLED</span>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <i class="material-icons media-middle">person</i> {{ $reservation->attendee->full_name }}
                                    <span class="pull-right">
                                        <a href="#" class="col-black m-r-10">
                                            <i class="material-icons">check</i>
                                        </a>
                                        <a href="#" class="col-black">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--Discussion-->
    <div class="block-header">
        <h2>DISCUSSION</h2>
    </div>
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>COMMENTS</h2>
                </div>
                <div class="body text-center">
                    None yet...
                </div>
            </div>
        </div>
    </div>

    <!--Media-->
    <div class="block-header">
        <h2>MEDIA</h2>
    </div>
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        	<div class="card">
                <div class="header">
                    <h2>PHOTOS &amp; VIDEO</h2>
                </div>
                <div class="body text-center">
                    Available soon...
                </div>
            </div>
        </div>
    </div>
@endsection