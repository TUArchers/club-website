<form id="memberships_form" action="{{ $action }}" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="card">
        <div class="header">
            <h2>
                <i class="material-icons media-middle">card_membership</i> Memberships
            </h2>
        </div>
        <div class="body table-responsive">
            <table id="memberships_table" class="table table-hover">
                <thead>
                <tr>
                    <th>Organisation</th>
                    <th>Number</th>
                    <th class="hidden-xs">Description</th>
                    <th>Valid From</th>
                    <th>Expires At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($memberships as $membership)
                    <tr class="{{ $membership->has_expired? 'col-grey':null }}">
                        <td>
                            <input type="hidden" name="memberships[{{ $loop->index }}][organisation]" value="{{ $membership->organisation->id }}">
                            {{ $membership->organisation->name }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[{{ $loop->index }}][number]" value="{{ $membership->number }}">
                            {{ $membership->number }}
                        </td>
                        <td class="hidden-xs">
                            <input type="hidden" name="memberships[{{ $loop->index }}][description]" value="{{ $membership->description }}">
                            {{ $membership->description }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[{{ $loop->index }}][valid_from]" value="{{ $membership->valid_from->format('Y-m-d') }}">
                            {{ $membership->valid_from->toFormattedDateString() }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[{{ $loop->index }}][expires_at]" value="{{ $membership->expires_at->format('Y-m-d') }}">
                            {{ $membership->expires_at->toFormattedDateString() }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[{{ $loop->index }}][id]" value="{{ $membership->id }}">
                            <a href="javascript:void(0)" class="delete-membership btn btn-link btn-circle waves-effect waves-circle">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr id="membership_composer" class="hidden no-hover">
                    <td>
                        @include('components.form.select', ['name' => null, 'id' => 'organisation_temp_select', 'label' => 'Select Organisation', 'options' => $organisations])
                    </td>
                    <td>
                        @include('components.form.input.text', ['name' => null, 'id' => 'number_temp_input', 'label' => 'Number'])
                    </td>
                    <td class="hidden-xs">
                        @include('components.form.input.text', ['name' => null, 'id' => 'description_temp_input', 'label' => 'Description'])
                    </td>
                    <td>
                        @include('components.form.input.datetime', ['name' => null, 'id' => 'valid_from_temp_input', 'label' => 'Valid From'])
                    </td>
                    <td>
                        @include('components.form.input.datetime', ['name' => null, 'id' => 'expires_at_temp_input', 'label' => 'Expires At'])
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="add-membership btn btn-link btn-circle waves-effect waves-circle">
                            <i class="material-icons">check</i>
                        </a>
                    </td>
                </tr>
                <!--Row template-->
                <template id="membership_row_template">
                    <tr class="col-blue">
                        <td>
                            <input type="hidden" name="memberships[@{{ index }}][organisation]" value="@{{ organisationId }}">
                            @{{ organisation }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[@{{ index }}][number]" value="@{{ number }}">
                            @{{ number }}
                        </td>
                        <td class="hidden-xs">
                            <input type="hidden" name="memberships[@{{ index }}][description]" value="@{{ description }}">
                            @{{ description }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[@{{ index }}][valid_from]" value="@{{ valid_from }}">
                            @{{ valid_from }}
                        </td>
                        <td>
                            <input type="hidden" name="memberships[@{{ index }}][expires_at]" value="@{{ expires_at }}">
                            @{{ expires_at }}
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="delete-membership btn btn-link btn-circle waves-effect waves-circle">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <button type="button" class="show-add-membership btn btn-link waves-effect">ADD MEMBERSHIP</button>
            <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Memberships form
    var membershipsForm = {
        element: '#memberships_form',
        nextIndex: '{{ $memberships->count() }}',
        resetComposer : function(){
            var composer = $('#membership_composer');

            composer.find('input').val('').closest('.focused').removeClass('focused');
            composer.find(':selected').removeAttr('selected');
            composer.find('select').selectpicker('refresh');
        },
        ready: function(){
            // Enable membership removal
            $(this.element).on('click', '.delete-membership', function () {
                $(this).closest('tr').remove();
            });

            // Enable date pickers for membership additions
            $('#membership_composer').find('.datetimepicker')
                .bootstrapMaterialDatePicker({
                    format: 'YYYY-MM-DD',
                    clearButton: false,
                    weekStart: 1,
                    time: false
                });

            // Enable membership additions
            $(this.element).on('click', '.show-add-membership', function () {
                var button   = $(this);
                var composer = $('#membership_composer');

                button.addClass('hidden');
                composer.removeClass('hidden');
            });

            $(this.element).on('click', '.add-membership', function () {
                var button   = $('.show-add-membership').first();
                var composer = $('#membership_composer');
                var inputs   = composer.find(':input');
                var template = _.template($('#membership_row_template').html());

                $(template({
                    index: membershipsForm.nextIndex,
                    organisationId: inputs.eq(1).find(':selected').val(),
                    organisation: inputs.eq(1).find(':selected').text(),
                    number: inputs.eq(2).val(),
                    description: inputs.eq(3).val(),
                    valid_from: inputs.eq(4).val(),
                    expires_at: inputs.eq(5).val()
                })).insertBefore(composer);

                // Reset the composer
                composer.addClass('hidden');
                button.removeClass('hidden');
                membershipsForm.resetComposer();

                membershipsForm.nextIndex ++;
            });
        }
    };
</script>
@endpush