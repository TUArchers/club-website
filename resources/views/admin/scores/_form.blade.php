{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'archer_id', 'label' => 'Select Archer', 'search_enabled' => true, 'options' => $users, 'option_value' => 'id', 'option_name' => 'full_name'])
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        @include('components.form.select', ['name' => 'scorer_id', 'label' => 'Select Scorer', 'search_enabled' => true, 'options' => $users, 'option_value' => 'id', 'option_name' => 'full_name'])
    </div>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.select', ['name' => 'round_id', 'label' => 'Select Round', 'search_enabled' => true, 'options' => $rounds, 'option_value' => 'id', 'option_name' => 'name'])
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.select', ['name' => 'bow_class', 'label' => 'Select Bow Class', 'search_enabled' => true, 'options' => $bow_classes, 'option_value' => 'id', 'option_name' => 'name'])
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.input.datetime', ['name' => 'shot_at', 'label' => 'Date and Time'])
    </div>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.input.number', ['name' => 'total_score', 'label' => 'Total Score', 'min' => 0, 'max' => 1440, 'step' => 1])
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.input.number', ['name' => 'hit_count', 'label' => 'Hit Count', 'min' => 0, 'max' => 144, 'step' => 1])
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('components.form.input.number', ['name' => 'gold_count', 'label' => 'Gold Count', 'min' => 0, 'max' => 144, 'step' => 1])
    </div>
</div>

@include('components.form.button.submit', ['colour' => 'btn-primary', 'label' => $submitLabel])

@push('scripts')
<script>
    $(function(){
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm',
            clearButton: true,
            weekStart: 1,
            maxDate: moment()
        });
    });
</script>
@endpush