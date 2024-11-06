@props([
    'label' => '',           // Label default kosong
    'name',                  // Name wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'value' => '',           // Nilai default untuk input
    'required' => false,     // Required default false
    'readonly' => false,     // Readonly default false
    'min' => null,           // Nilai minimum untuk input
    'max' => null,           // Nilai maksimum untuk input
    'step' => 1,             // Langkah untuk input angka, default 1
    'errorMessage' => null,  // Pesan error kustom jika ada
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input 
        type="number" 
        class="form-control" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
        id="{{ $id }}" 
        value="{{ old($name, $value) }}" 
        {{ $required ? 'required' : '' }} 
        {{ $readonly ? 'readonly' : '' }}
        {{ is_numeric($min) ? "min=$min" : '' }} 
        {{ is_numeric($max) ? "max=$max" : '' }} 
        step="{{ $step }}"
    >
    @if ($errorMessage)
        <div class="text-danger">{{ $errorMessage }}</div>
    @endif
</div>
