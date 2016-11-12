<div class="form-group form-float">
    <div class="form-line{{ isset($value)? ' focused':null }}">
        <textarea id="{{ $name }}_textarea" name="{{ $name }}" class="form-control no-resize" title="{{ $label }}" rows="{{ isset($rows)? $rows:2 }}">{{ isset($value)? $value:null }}</textarea>
        <label class="form-label" for="{{ $name }}_textarea">{{ $label }}</label>
    </div>
</div>