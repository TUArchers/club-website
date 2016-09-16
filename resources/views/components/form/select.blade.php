<select id="{{ $name }}_select" name="{{ $name }}" class="form-control show-tick" title="{{ $label }}"{{ isset($search_enabled) && $search_enabled? ' data-live-search="true"':null }}{{ isset($disabled) && $disabled? ' disabled':null }}>
    <option value="" disabled>-- {{ $label }} --</option>
    @foreach($options as $option)
        <option value="{{ isset($option_value)? $option->$option_value:$option->id }}"{{ isset($selected) && $selected == $option->id? ' selected':null }}>{{ isset($option_name)? $option->$option_name:$option->name }}</option>
    @endforeach
</select>