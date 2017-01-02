{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.input.text', ['name' => 'name', 'label' => 'Round Name'])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'organisation_id', 'label' => 'Select Organisation', 'options' => $organisations, 'option_value' => 'id', 'option_name' => 'name'])
    </div>
</div>

<div class="row cleafix">
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        @include('components.form.input.radio', ['id' => 'outdoor_radio', 'name' => 'season', 'value' => 'O', 'label' => 'Outdoor', 'colour' => 'deep-orange', 'checked' => true])
        @include('components.form.input.radio', ['id' => 'indoor_radio', 'name' => 'season', 'value' => 'I', 'label' => 'Indoor', 'colour' => 'deep-orange'])
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        @include('components.form.input.number', ['name' => 'total_targets', 'label' => 'Targets', 'min' => 0, 'max' => 6, 'step' => 1])
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        @include('components.form.input.number', ['name' => 'total_shots', 'label' => 'Shots', 'min' => 1, 'max' => 144, 'step' => 1])
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        @include('components.form.select', ['name' => 'scoring_system_id', 'label' => 'Select Scoring System', 'options' => $scoring_systems, 'option_value' => 'id', 'option_name' => 'name'])
    </div>
</div>

@include('components.form.button.submit', ['colour' => 'btn-primary', 'label' => $submitLabel])