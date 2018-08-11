<select name="{{ $name }}" id="{{ $name }}" class="form-control select2-courier {{ $class ?? "" }}" required
        data-placeholder="{{ $placeholder ?? "" }}" {{ isset($disabled) && $disabled ? "disabled" : "" }}
        data-bind="{{ $name }}">
    <option value="{{ $value }}">{{ $text }}</option>
</select>