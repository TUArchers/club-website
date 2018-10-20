<form id="invite_details_form" action="{{ route('admin.event-invites.store') }}" method="POST">
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">insert_invitation</i> Invitation Details
            </h2>
        </div>
        <div class="body">
            <div class="row clearfix">
                {{--Event and Invitees--}}
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	@include('components.form.select', ['name' => 'event_ids[]', 'options' => $events, 'label' => 'Events', 'multiple' => true, 'search_enabled' => true])
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    @include('components.form.select', ['name' => 'user_ids[]', 'options' => $users, 'label' => 'Users', 'multiple' => true, 'search_enabled' => true])
                </div>
            </div>

            {{--Usage count--}}
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @include('components.form.input.number', ['name' => 'uses', 'label' => 'Invitation Uses', 'min' => 1, 'value' => 1])
                </div>
            </div>

            {{--Message to invitees--}}
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('components.form.textarea', ['name' => 'message', 'rows' => '5', 'label' => 'Message to invitees'])
                </div>
            </div>

        </div>
        <div class="footer">
            <button type="submit" class="btn btn-link waves-effect">SEND INVITATION</button>
        </div>
    </div>
</form>