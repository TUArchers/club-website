{{ csrf_field() }}

<div class="row clearfix">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <select id="archer_select" name="archer_id" class="form-control show-tick" data-live-search="true" title="Select Archer">
            <option value="" selected disabled>-- Select Archer --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <select id="scorer_select" name="scorer_id" class="form-control show-tick" data-live-search="true" title="Select Scorer">
            <option value="" selected disabled>-- Select Scorer --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <select id="round_select" name="round_id" class="form-control show-tick" data-live-search="true" title="Select Round">
            <option value="" selected disabled>-- Select Round --</option>
            @foreach($rounds as $round)
                <option value="{{ $round->id }}">{{ $round->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <select id="bow_class_select" name="bow_class" class="form-control show-tick" data-live-search="true" title="Select Bow Class">
            <option value="" selected disabled>-- Select Bow Class --</option>
            @foreach($bow_classes as $bow_class)
                <option value="{{ $bow_class->id }}">{{ $bow_class->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <div class="form-line">
                <input type="text" id="shot_at_input" name="shot_at" class="datetimepicker form-control" placeholder="Date and Time" title="Date and Time">
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group form-float">
            <div class="form-line {{ isset($score) && !is_null($score->total_score)? 'focused':''}}">
                <input type="number" id="total_score_input" name="total_score" class="form-control" title="Total Score" min="0" max="1440" step="1">
                <label class="form-label" for="total_score_input">Total Score</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group form-float">
            <div class="form-line {{ isset($score) && !is_null($score->hit_count)? 'focused':''}}">
                <input type="number" id="hit_count_input" name="hit_count" class="form-control" title="Hits" min="0" max="144" step="1">
                <label class="form-label" for="hit_count_input">Hits</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group form-float">
            <div class="form-line {{ isset($score) && !is_null($score->gold_count)? 'focused':''}}">
                <input type="number" id="gold_count_input" name="gold_count" class="form-control" title="Golds" min="0" max="144" step="1">
                <label class="form-label" for="gold_count_input">Golds</label>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary m-t-15 waves-effect">{{ $submitLabel }}</button>

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