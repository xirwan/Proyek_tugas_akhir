@props([
    'label' => '',
    'name' => '',            // Nama default untuk input
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'value' => '',           // Nilai default (jika ada, misalnya edit form)
    'required' => false      // Secara default tidak required
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input type="date" class="form-control mb-3" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
</div>
