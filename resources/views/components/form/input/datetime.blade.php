<div class="form-group">
    <div class="form-line">
        <input type="text" id="{{ isset($id)? $id:$name }}_input" name="{{ $name }}" class="datetimepicker form-control" {{ isset($value)? 'value='.$value:null }} title="{{ $label }}" placeholder="{{ isset($placeholder)? $placeholder:$label }}">
    </div>
</div>