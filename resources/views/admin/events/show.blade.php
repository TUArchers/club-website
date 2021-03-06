@extends('layouts.admin')

@section('title', $event->name . ' (Event Details)')

@section('content')
    <!--Modal-->
    <div id="modal-cancel-event" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancel Event</h4>
                </div>
                <div class="modal-body">
                    <form id="form-cancel-event" action="{{ route('admin.events.destroy', ['id' => $event->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        @include('components.form.textarea', ['name' => 'reason', 'rows' => '3', 'label' => 'Message to Attendees'])
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="button-cancel-event">Confirm</button>
                </div>
            </div>
        </div>
    </div>

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
                                <li><a href="{{ route('admin.events.edit', ['id' => $event->id])  }}" class="waves-effect waves-block"><i class="material-icons">mode_edit</i> Edit event details</a></li>
                                <li><a href="javascript:void(0)" class="waves-effect waves-block" data-toggle="modal" data-target="#modal-cancel-event"><i class="material-icons">delete</i> Cancel event</a></li>
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
                        <i class="material-icons media-middle">av_timer</i> {{ $event->duration }} long
                    </p>
                    <p>
                        <i class="material-icons media-middle">location_on</i> <a href="http://map.google.com?q={{ $event->location_name }}" class="no-hover"  target="_blank">{{ $event->location_name }}</a>
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
                            <li class="list-group-item">
                                @if(!$reservation->attendee)
                                    <i class="material-icons media-middle">person</i><s>Deleted User</s>
                                @else
                                    <i class="material-icons media-middle">person</i> {{ $reservation->attendee->name }}
                                @endif
                                @if($reservation->is_used)
                                    <span class="badge bg-green">ATTENDED</span>
                                @elseif($reservation->is_cancelled)
                                    <span class="badge bg-red">CANCELLED</span>
                                @else
                                    <span class="pull-right">
                                        <a href="javascript:void(0);" class="col-black m-r-10 mark-reservation" data-event-id="{{ $event->id }}" data-reservation-id="{{ $reservation->id }}" data-response="used">
                                            <i class="material-icons">check</i>
                                        </a>
                                        <a href="javascript:void(0);" class="col-black mark-reservation" data-event-id="{{ $event->id }}" data-reservation-id="{{ $reservation->id }}" data-response="cancelled">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </span>
                                @endif
                            </li>
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

@push('scripts')
<script>
    $(function(){

        $('body').on('click', '.mark-reservation', function(e){
            var action        = $(e.target).closest('a');
            var eventId       = action.data('event-id');
            var reservationId = action.data('reservation-id');
            var base          = '{{ url('/') }}';

            var dataObj = {};
            dataObj[action.data('response')] = true;

            $.ajax({
                url: base + '/api/events/' + eventId + '/reservations/' + reservationId,
                method: 'PATCH',
                data: dataObj,
                success: function(){
                    location.reload()
                }
            });
        });

        $('#modal-cancel-event').on('shown.bs.modal', function () {
            $('#reason_textarea').focus();
        });

        $('#button-cancel-event').on('click', function(e){
            e.preventDefault();
            $('#form-cancel-event').submit();
        });
    });
</script>
@endpush;