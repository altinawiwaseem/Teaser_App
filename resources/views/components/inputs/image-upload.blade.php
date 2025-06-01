@props([
    'label' => 'Bild hochladen',
    'wireModel' => 'image',
    'maxSize' => '2MB',
    'acceptedTypes' => 'JPG, PNG, GIF, WEBP',
    'accept' => 'image/*',
    'currentImage' => null,
    'currentImageAlt' => 'Current image',
    'removeMethod' => null,
    'showCurrentImage' => true,
])

@php
    $tempImageUrl = null;
    $hasExistingImage = false;

    // Check for current image
    if ($currentImage) {
        if (is_string($currentImage)) {
            $tempImageUrl = $currentImage;
            $hasExistingImage = true;
        } elseif (is_object($currentImage) && method_exists($currentImage, 'temporaryUrl')) {
            $tempImageUrl = $currentImage->temporaryUrl();
            $hasExistingImage = false;
        }
    }
@endphp

<div x-data="imageUpload({
    tempImageUrl: @js($tempImageUrl),
    hasExistingImage: @js($hasExistingImage),
    livewireMethod: @js($removeMethod)
})" x-init="init()">

    <label class="block text-gray-700 text-sm font-medium mb-2">{{ $label }}</label>

    <!-- Current Image Display (if showCurrentImage is true and we have an existing image) -->
    {{-- @if ($showCurrentImage && $currentImage && $hasExistingImage)
        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Aktuelles Bild:</p>
            <div class="relative inline-block">
                <img src="{{ $tempImageUrl }}" alt="{{ $currentImageAlt }}" 
                     class="max-w-48 max-h-32 object-cover rounded-lg border-2 border-gray-300">
                @if ($removeMethod)
                    <button type="button" 
                            wire:click="{{ $removeMethod }}"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 transition-colors">
                        ×
                    </button>
                @endif
            </div>
        </div>
    @endif --}}

    <!-- Upload Area -->
    <div class="border-2 border-dashed rounded-lg p-4 text-center transition-all duration-200 cursor-pointer"
        :class="isDragging ? 'border-green-500 bg-green-50 scale-105' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
        @dragenter.prevent="handleDragEnter($event)" @dragover.prevent="handleDragOver($event)"
        @dragleave.prevent="handleDragLeave($event)" @drop.prevent="handleDrop($event)" @click="$refs.fileInput.click()">

        <input x-ref="fileInput" wire:model="{{ $wireModel }}" type="file" accept="{{ $accept }}"
            class="hidden" @change="handleFileSelect($event)" />

        <div x-show="!imagePreview">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <span class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium inline-block mb-2">
                📁 {{ $hasExistingImage ? 'Neues Bild hochladen' : 'Datei hochladen' }}
            </span>
            <p class="text-gray-500 text-sm">oder Drag and Drop</p>
            <p class="text-gray-400 text-xs mt-1">Max. {{ $maxSize }} - {{ $acceptedTypes }}</p>
        </div>

        <!-- New Image Preview -->
        <div x-show="imagePreview" x-transition class="relative">
            <img :src="imagePreview" alt="Preview"
                class="max-w-full max-h-48 object-cover rounded-lg border-2 border-gray-300 mx-auto">
            <button type="button" @click.stop="removeImage()"
                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 transition-colors">
                ×
            </button>
        </div>
    </div>

    <!-- Image Info -->
    <div x-show="imagePreview && imageInfo" x-transition class="mt-4">
        <p x-text="imageInfo" class="text-sm text-gray-600"></p>
    </div>

    <!-- Error Messages -->
    @error($wireModel)
        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
    @enderror

    <div x-show="errorMessage" x-transition class="text-red-500 text-sm mt-2" x-text="errorMessage"></div>

    <!-- Loading indicator -->
    <div wire:loading wire:target="{{ $wireModel }}" class="mt-2">
        <p class="text-sm text-blue-600">Bild wird hochgeladen...</p>
    </div>
</div>
