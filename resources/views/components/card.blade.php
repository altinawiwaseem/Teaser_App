@props([
    'title' => 'Form',
    'headerColor' => 'bg-green-600'
])

<div class="max-w-[960px] mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="{{ $headerColor }} text-white text-center py-4">
        <h2 class="text-lg font-medium">{{ $title }}</h2>
    </div>

    <!-- Content -->
    <div class="p-6">
        {{ $slot }}
    </div>
</div>