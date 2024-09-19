@props([
    'label' => 'Password',   // Default label untuk password
    'name',                  // Nama yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default untuk password
    'value' => '',           // Nilai default (biasanya kosong untuk input password)
    'required' => false      // Secara default tidak required
])

<div class="form-group row col-lg-6">
    <label class="col-lg-3 control-label text-lg-right pt-2" for="{{ $id }}">{{ $label }}</label>
    <div class="col-lg-9">
        <input type="password" class="form-control" name="{{ $name }}" placeholder="{{ $placeholder }}" id="{{ $id }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>
    </div>
</div>