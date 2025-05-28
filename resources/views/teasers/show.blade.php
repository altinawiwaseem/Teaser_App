@extends('layouts.app')

@section('content')
<div class="max-w-[960px] mx-auto px-4 py-4">
    <!-- Teaser Detail Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">


        <!-- Teaser Content -->
        <div class="relative">
            <!-- Image with 16:9 aspect ratio -->
            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                @if($teaser->image_path)
                <img src="{{ asset('storage/' . $teaser->image_path) }}" alt="{{ $teaser->title }}"
                    class="w-full h-full object-cover" />
                @else
                <!-- Placeholder for missing image -->
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                @endif

                <!-- Title Overlay -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                    <h1 class="text-white text-2xl font-bold">{{ $teaser->title }}</h1>
                </div>
            </div>

            <!-- Text Content -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed text-base">{{ $teaser->text }}</p>
                </div>
            </div>

            <!-- Back to Overview Button -->
            <div class="p-6 pt-0 flex justify-center md:justify-start">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Zurück zur Übersicht
                </a>
            </div>
        </div>
    </div>
</div>
@endsection