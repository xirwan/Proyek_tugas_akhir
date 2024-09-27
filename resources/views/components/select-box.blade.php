{{-- @props([
    'label' => 'Label',      // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'options' => [],          // Opsi untuk select box
    'selected' => '',        // Nilai yang terpilih kosong
    'required' => false      // Required default false
])

<div class="form-group row col-lg-6">
    <label class="col-lg-3 control-label text-lg-right pt-2" for="{{ $id }}">{{ $label }}</label>
    <div class="col-lg-9">
        <select class="form-control mb-3" name="{{ $name }}" id="{{ $id }}" {{ $required ? 'required' : '' }}>
            <!-- Placeholder -->
            <option value="" disabled {{ $selected == '' ? 'selected' : '' }}>{{ $placeholder }}</option>
            
            <!-- Loop melalui opsi yang diberikan -->
            @foreach($options as $value => $optionLabel)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
            @endforeach
        </select>
    </div>
</div> --}}

@props([
    'label' => 'Label',      // Default label
    'name',                  // Name yang wajib diberikan
    'id' => $name,           // Jika id tidak diberikan, gunakan name
    'placeholder' => '',     // Placeholder default kosong
    'options' => [],         // Opsi untuk select box
    'selected' => '',        // Nilai yang terpilih kosong (misalnya saat edit form)
    'required' => false      // Required default false
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" id="{{ $id }}" {{ $required ? 'required' : '' }}>
        <!-- Placeholder -->
        <option value="" disabled {{ old($name, $selected) == '' ? 'selected' : '' }}>{{ $placeholder }}</option>
        <!-- Loop melalui opsi yang diberikan -->
        @foreach($options as $value => $optionLabel)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>