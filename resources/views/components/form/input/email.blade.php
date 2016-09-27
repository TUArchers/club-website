<div class="form-group form-float">
    <div class="form-line{{ isset($value)? ' focused':null }}">
        <input type="email" id="{{ isset($id)? $id:$name }}_input" name="{{ $name }}" class="form-control" {{ isset($value)? 'value='.$value:null }}{{ isset($required) && $required? ' required':null }}>
        <label class="form-label" for="{{ isset($id)? $id:$name }}_input">{{ $label }}</label>
    </div>
</div>