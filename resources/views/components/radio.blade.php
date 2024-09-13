@props([
    'label' => 'Label',              // Label untuk grup radio
    'name',                          // Nama untuk grup radio (wajib diberikan)
    'options' => [],                 // Opsi radio dalam bentuk array
    'value' => null,                 // Nilai default (data dari database, bisa null)
    'required' => false              // Menentukan apakah tombol radio harus required
])

<div class="form-group row col-lg-6">
    <label class="col-lg-3 control-label text-lg-right pt-2">{{ $label }}</label>
    <div class="col-lg-9">
        @foreach ($options as $optionValue => $optionLabel)
            <div class="radio">
                <label>
                    <input type="radio" name="{{ $name }}" id="{{ $name }}{{ $loop->index }}" 
                    value="{{ $optionValue }}" 
                    {{ old($name, $value) == $optionValue ? 'checked' : '' }} 
                    {{ $required ? 'required' : '' }}>
                    {{ $optionLabel }}
                </label>
            </div>
        @endforeach
    </div>
</div>
