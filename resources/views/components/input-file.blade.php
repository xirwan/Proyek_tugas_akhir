@props([
    'label' => '',           // Label for the file input
    'name',                  // Name attribute (required)
    'id' => $name,           // Default id is the name
    'accept' => '',          // File types to accept (default: empty, accepts all)
    'required' => false,     // Whether the field is required
    'errorMessage' => null,  // Custom error message
])

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    <input 
        type="file" 
        class="form-control" 
        name="{{ $name }}" 
        id="{{ $id }}" 
        {{ $accept ? 'accept=' . $accept : '' }} 
        {{ $required ? 'required' : '' }}>
    @if ($errorMessage)
        <div class="text-danger">{{ $errorMessage }}</div>
    @endif
</div>