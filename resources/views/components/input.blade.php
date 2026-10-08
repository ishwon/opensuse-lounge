@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'helpText' => null,
])

@php
    $isNonInteractive = $attributes->has('readonly') || $attributes->has('disabled');
    $baseClasses = 'block w-full px-4 py-2 rounded-lg shadow-sm transition-colors duration-200';
    $interactiveClasses = 'bg-card text-primary placeholder-muted/50 focus:ring-2 focus:ring-accent focus:border-accent border ' . ($error ? 'border-danger focus:ring-danger focus:border-danger' : 'border-default');
    $nonInteractiveClasses = 'bg-muted/15 text-secondary placeholder-muted/60 cursor-not-allowed border border-dashed border-default focus:ring-0 focus:border-default';
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-primary">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => trim($baseClasses . ' ' . ($isNonInteractive ? $nonInteractiveClasses : $interactiveClasses))
        ]) }}
    >
    
    @if($helpText)
        <p class="text-sm text-muted">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="text-sm text-danger">{{ $error }}</p>
    @endif
    
    @error($name)
        <p class="text-sm text-danger">{{ $message }}</p>
    @enderror
</div>

