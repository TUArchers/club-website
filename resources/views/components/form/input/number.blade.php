<div class="form-group form-float">
    <div class="form-line{{ isset($value)? ' focused':null }}">
        <input type="number" id="{{ isset($id)? $id:$name }}_input" name="{{ $name }}" class="form-control" title="{{ $label }}" {{ isset($min)? 'min='.$min.' ':null }}{{ isset($max)? 'max='.$max.' ':null }}{{ isset($step)? 'step='.$step.' ':null }}{{ isset($value)? ' value='.$value.'':null }}>
        <label class="form-label" for="{{ isset($id)? $id:$name }}_input">{{ $label }}</label>
    </div>
</div>