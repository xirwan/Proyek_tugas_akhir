@props([
    'label' => 'Password',   // Default label untuk password
    'name',                  // Nama yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default untuk password
    'value' => '',           // Nilai default (biasanya kosong untuk input password)
    'required' => false,     // Secara default tidak required
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input type="password" class="form-control" name="{{ $name }}" placeholder="{{ $placeholder }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>