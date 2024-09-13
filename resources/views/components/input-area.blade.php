@props([
    'label' => 'Label',      // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'value' => '',           // Nilai default untuk input
    'required' => false      // Required default false
])
<div class="form-group row col-lg-6">
    <label class="col-lg-3 control-label text-lg-right pt-2" for="{{ $id }}">{{ $label }}</label>
    <div class="col-lg-9">
        <textarea class="form-control" rows="3" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
    </div>
</div>