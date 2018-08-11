<select name="{{ $name }}" id="{{ $name }}" class="form-control select2-accountNumber {{ $class ?? "" }}" required
        data-placeholder="{{ $placeholder ?? "" }}" {{ isset($disabled) && $disabled ? "disabled" : "" }}
        data-bind="{{ $name }}">
    <option value="{{ $value }}">{{ $value }}</option>
</select>