<div class="form-group">
    <div class="form-line">
        <input type="text" id="{{ isset($id)? $id:$name }}_input" name="{{ $name }}" class="datetimepicker form-control" value="{{ isset($value)? $value:'' }}" title="{{ $label }}" placeholder="{{ isset($placeholder)? $placeholder:$label }}">
    </div>
</div>