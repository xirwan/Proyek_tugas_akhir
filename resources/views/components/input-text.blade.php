@props([
    'label' => '',           // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'value' => '',           // Nilai default untuk input
    'required' => false,     // Required default false
    'readonly' => false,     // Readonly default false
    'errorMessage' => null,  // Pesan error kustom jika ada
    'disabled' => false,      // Disabled default false
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input type="text" class="form-control" name="{{ $name }}" placeholder="{{ $placeholder }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $readonly ? 'readonly' : '' }}  {{ $disabled ? 'disabled' : '' }} >
    @if ($errorMessage)
        <div class="text-danger">{{ $errorMessage }}</div>
    @endif
</div>