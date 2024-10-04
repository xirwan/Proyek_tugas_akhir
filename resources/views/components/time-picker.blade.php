@props([
    'label' => 'Time',        // Label default untuk input jam
    'name' => '',             // Nama default untuk input
    'id' => $name,            // Jika id tidak diberikan, gunakan name
    'value' => '',            // Nilai default (jika ada, misalnya untuk edit form)
    'required' => false       // Secara default tidak required
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input type="time" class="form-control mb-3" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
</div>