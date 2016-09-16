<div class="form-group form-float">
    <div class="form-line {{ !is_null($value)? 'focused':null }}">
        <textarea id="{{ $name }}_textarea" name="{{ $name }}" class="form-control no-resize" title="{{ $label }}" rows="{{ $rows?:2 }}">{{ $value }}</textarea>
        <label class="form-label" for="{{ $name }}_textarea">{{ $label }}</label>
    </div>
</div>