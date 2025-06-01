@props([
    'label' => 'Text',
    'placeholder' => '',
    'wireModel' => 'text',
    'rows' => 8,
    'required' => false
])

<div>
    <label class="block text-gray-700 text-sm font-medium mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <textarea 
        wire:model="{{ $wireModel }}" 
        placeholder="{{ $placeholder }}" 
        rows="{{ $rows }}"
        class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none resize-none"
        {{ $attributes }}
    ></textarea>
    @error($wireModel) 
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
    @enderror
</div>