@props([
    'label' => 'Überschrift',
    'placeholder' => '',
    'wireModel' => 'title',
    'required' => false
])

<div>
    <label class="block text-gray-700 text-sm font-medium mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input 
        wire:model="{{ $wireModel }}" 
        type="text" 
        placeholder="{{ $placeholder }}"
        class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
        {{ $attributes }}
    />
    @error($wireModel) 
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
    @enderror
</div>