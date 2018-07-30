<select name="{{ $name }}" id="{{ $name }}" class="form-control select2-accountNumber" required
        data-placeholder="{{ $placeholder ?? "" }}" {{ isset($disabled) && $disabled ? "disabled" : "" }}>
    <option value="{{ $value }}">{{ $value }}</option>
</select>