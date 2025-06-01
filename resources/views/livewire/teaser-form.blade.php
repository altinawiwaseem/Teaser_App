<div class="max-w-4xl mx-auto px-4">
    <x-card title="Inhalte hochladen">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column - Überschrift & Text -->
                <div class="space-y-4">
                    <x-inputs.title wire-model="title" :required="true" />

                    <x-inputs.text wire-model="text" rows="8" :required="true" />
                </div>

                <!-- Right Column - Image Upload -->
                <div>
                    <x-inputs.image-upload wire-model="image" label="Bild hochladen" />
                </div>
            </div>

            <div class="flex justify-center md:justify-end pt-4">
                <x-buttons.custom-button text="Inhalte ausspielen" />
            </div>

        </form>
    </x-card>
</div>

{{-- Upload-image JavaScript --}}
@push('scripts')
    <script src="{{ asset('js/components/image-upload.js') }}"></script>
@endpush
