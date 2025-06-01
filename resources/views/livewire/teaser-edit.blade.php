<div class="max-w-4xl mx-auto px-4">
    <x-card title="Teaser bearbeiten">
        <div class="p-6">
            <form wire:submit.prevent="update" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column Überschrift & Text -->
                    <div class="space-y-4">
                        <div class="space-y-4">
                            <x-inputs.title wire-model="title" :required="true" />
                            <x-inputs.text wire-model="text" rows="8" :required="true" />
                        </div>
                    </div>

                    <!-- Right Column - Image Upload -->
                    <div>
                        <!-- Current Image Preview - Larger Container -->

                        @if ($teaser->image_path)
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-2">Aktuelles Bild:</p>
                                <div
                                    class="border-2 border-gray-200 rounded-lg overflow-hidden max-h-48 flex items-center justify-center bg-gray-50">
                                    <img src="{{ asset('storage/' . $teaser->image_path) }}" alt="{{ $teaser->title }}"
                                        class="max-h-full max-w-full object-contain p-2" />
                                </div>
                            </div>
                        @endif

                        <x-inputs.image-upload wire-model="image" label="Bild ändern" />
                    </div>

                </div>

                <!-- Buttons Section -->

                <div class="max-w-[960px] flex justify-center">
                    <div class="flex flex-col items-center pt-4">
                        <div class="flex justify-center space-x-4 mb-4 w-full max-w-md">
                            <!-- Cancel Button -->
                            <div class="flex-1">
                                <x-buttons.custom-button text="Abbrechen" type="button" variant="secondary"
                                    size="lg" fullWidth="true" onclick="window.location.href='{{ route('home') }}'"
                                    class="h-14 flex items-center justify-center whitespace-nowrap" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex-1">
                                <x-buttons.custom-button text="Änderungen speichern" type="submit" variant="success"
                                    size="default" fullWidth="true"
                                    class="h-14 flex items-center justify-center whitespace-nowrap" />
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <div class="w-full max-w-md mt-2">
                            <x-buttons.custom-button text="Teaser löschen" type="button" variant="danger"
                                size="default" fullWidth="true"
                                @click="confirm('Möchten Sie diesen Teaser wirklich löschen?') && $wire.deleteTeaser()"
                                class="h-14 flex items-center justify-center whitespace-nowrap" />
                        </div>
                    </div>
                </div>

            </form>
    </x-card>
</div>



{{-- Upload-image JavaScript --}}
@push('scripts')
    <script src="{{ asset('js/components/image-upload.js') }}"></script>
@endpush
