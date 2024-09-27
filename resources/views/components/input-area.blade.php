@props([
    'label' => 'Label',      // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'value' => '',           // Nilai default untuk input
    'required' => false      // Required default false
])
<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
</div>