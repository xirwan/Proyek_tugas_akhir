@props([
    'label' => '',
    'name' => '',            // Nama default untuk input
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'value' => '',           // Nilai default (jika ada, misalnya edit form)
    'required' => false      // Secara default tidak required
])

<div class="form-group row col-lg-6">
    <label class="col-lg-3 control-label text-lg-right pt-2" for="{{ $id }}">{{ $label }}</label>
    <div class="col-lg-9">
        <input type="date" class="form-control mb-3" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
    </div>
</div>
