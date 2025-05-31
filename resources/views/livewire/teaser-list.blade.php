<div class="max-w-[960px] mx-auto px-4">
  
    <div class="max-w-[960px] mx-auto space-y-6">
        @foreach($teasers as $teaser)
        <div
            class="relative bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 p-2 hover:shadow-md transition-shadow">
            <a href="{{ route('teasers.show', $teaser) }}" class="block ">
                <div class="flex flex-col md:flex-row">
                    <!-- Image - 1/3 on desktop, full width on mobile with 16:9 aspect ratio -->
                    <div class="w-full md:w-1/3">
                        <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if($teaser->image_path)
                            <img src="{{ asset('storage/' . $teaser->image_path) }}" class="w-full h-full object-cover"
                                alt="{{ $teaser->title }}" />
                            @else
                            <!-- Placeholder for missing image -->
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Content - 2/3 on desktop, full width on mobile -->
                    <div class="w-full md:w-2/3 p-6">
                        <h2 class="font-bold text-xl mb-3 text-gray-900 leading-tight">{{ $teaser->title }}</h2>
                        <p class="text-gray-700 leading-relaxed text-sm">{{ Str::limit($teaser->text, 200) }}</p>
                    </div>
                </div>
            </a>
            @auth
            @if(auth()->id() == $teaser->user_id)
            <a href="{{ route('teasers.edit', $teaser) }}"
                class="absolute top-3 right-3 bg-white bg-opacity-90 hover:bg-opacity-100 p-2 rounded-full shadow-sm transition-all hover:shadow-md">
                <svg class="w-4 h-4 text-gray-600 hover:text-gray-800" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </a>
            @endif
            @endauth
        </div>
        @endforeach
    </div>
</div>