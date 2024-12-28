@props([
    'label' => '',           // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'value' => '',           // Nilai default untuk input
    'required' => false,     // Required default false
    'readonly' => false,     // Readonly default false
    'errorMessage' => null,  // Pesan error kustom jika ada
    'disabled' => false,     // Disabled default false
    'maxlength' => null,     // Panjang maksimum input (opsional)
    'pattern' => null,       // Pola validasi input (opsional)
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input 
        type="tel" 
        class="form-control" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
        id="{{ $id }}" 
        value="{{ old($name, $value) }}" 
        {{ $required ? 'required' : '' }} 
        {{ $readonly ? 'readonly' : '' }} 
        {{ $disabled ? 'disabled' : '' }} 
        {{ $maxlength ? 'maxlength='.$maxlength : '' }} 
        {{ $pattern ? 'pattern='.$pattern : '' }}
    >
    @if ($errorMessage)
        <div class="text-danger">{{ $errorMessage }}</div>
    @endif
</div>
