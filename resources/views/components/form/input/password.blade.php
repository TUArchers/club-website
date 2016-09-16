<div class="form-group form-float">
    <div class="form-line">
        <input type="password" id="{{ isset($id)? $id:$name }}_input" name="{{ $name }}" class="form-control" title="{{ $label }}">
        <label class="form-label" for="{{ isset($id)? $id:$name }}_input">{{ $label }}</label>
    </div>
</div>