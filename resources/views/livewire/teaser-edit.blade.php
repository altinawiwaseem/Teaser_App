<div class="max-w-[960px] mx-auto px-4">
    <div class="max-w-[960px] mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-green-600 text-white text-center py-4">
            <h2 class="text-lg font-medium">Teaser bearbeiten</h2>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="update" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Überschrift</label>
                            <input wire:model="title" type="text"
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" />
                            @error('title') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Text</label>
                            <textarea wire:model="text" rows="8"
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none resize-none"></textarea>
                            @error('text') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Right Column - Image Upload -->
                    <div x-data="imageUpload()" wire:ignore>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Bild hochladen</label>

                        <!-- Current Image Preview - Larger Container -->
                        @if($teaser->image_path)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Aktuelles Bild:</p>
                            <div
                                class="border-2 border-gray-200 rounded-lg overflow-hidden h-64 flex items-center justify-center bg-gray-50">
                                <img src="{{ asset('storage/' . $teaser->image_path) }}" alt="{{ $teaser->title }}"
                                    class="max-h-full max-w-full object-contain p-2" />
                            </div>
                        </div>
                        @endif

                        <!-- Upload Area - Smaller Container -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-gray-100 transition-all duration-200 h-48 flex flex-col items-center justify-center cursor-pointer"
                            :class="isDragging ? 'border-green-500 bg-green-50 scale-105' : ''"
                            @dragenter.prevent="handleDragEnter" @dragover.prevent="handleDragOver"
                            @dragleave.prevent="handleDragLeave" @drop.prevent="handleDrop"
                            @click="$refs.fileInput.click()">

                            <input x-ref="fileInput" wire:model="image" type="file" accept="image/*" class="hidden"
                                @change="handleFileSelect($event)" />

                            <!-- Upload area (shown when no preview) -->
                            <div x-show="!imagePreview" class="flex flex-col items-center justify-center h-full w-full">
                                <div class="mb-3">
                                    <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <span
                                    class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium inline-block mb-1">
                                    📁 Neues Bild hochladen
                                </span>
                                <p class="text-gray-500 text-xs">oder Datei hierher ziehen</p>
                            </div>

                            <!-- Preview (shown when image selected) -->
                            <div x-show="imagePreview" x-transition
                                class="relative w-full h-full flex items-center justify-center">
                                <img :src="imagePreview" alt="Preview" class="max-h-full max-w-full object-contain" />
                                <button type="button" @click.stop="removeImage()"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Image Info (outside drop zone) -->
                        <div x-show="imagePreview" x-transition class="mt-4">
                            <p x-text="imageInfo" class="text-sm text-gray-600"></p>
                        </div>

                        <!-- Error Messages -->
                        @error('image')
                        <div class="text-red-500 text-sm mt-2">
                            @if($message == 'The image field must be an image.')
                            Bitte wählen Sie ein gültiges Bild aus (JPG, PNG, GIF, WEBP)
                            @else
                            {{ $message }}
                            @endif
                        </div>
                        @enderror
                        <div x-show="errorMessage" x-transition class="text-red-500 text-sm mt-2" x-text="errorMessage">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center pt-4">
                    <div class="flex justify-center space-x-4 mb-4 w-full max-w-md">
                        <a href="{{ route('home') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-6 rounded-lg font-medium transition-colors flex-1 text-center item-center">
                            Abbrechen
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition-colors flex-1 text-center">
                            Änderungen speichern
                        </button>
                    </div>

                    <button type="button"
                        @click="confirm('Möchten Sie diesen Teaser wirklich löschen?') && $wire.deleteTeaser()"
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-colors w-full max-w-md mt-2">
                        Teaser löschen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function imageUpload() {
    return {
        isDragging: false,
        dragCounter: 0,
        imagePreview: null,
        imageInfo: '',
        errorMessage: '',
        selectedFile: null,

        init() {
            this.resetState();
            
            // Initialize with existing temp image if available
            @if($tempImageUrl)
                this.imagePreview = '{{ $tempImageUrl }}';
                this.imageInfo = 'Neues Bild ausgewählt';
            @endif
        },

        handleDragEnter(e) {
            e.preventDefault();
            e.stopPropagation();
            this.dragCounter++;
            this.isDragging = true;
            this.clearError();
        },

        handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            this.isDragging = true;
        },

        handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            this.dragCounter--;
            
            if (this.dragCounter <= 0) {
                this.dragCounter = 0;
                this.isDragging = false;
            }
        },

        handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.isDragging = false;
            this.dragCounter = 0;
            
            const files = e.dataTransfer.files;
            if (files && files.length > 0) {
                this.processFile(files[0], true); 
            }
        },

        handleFileSelect(e) {
            e.preventDefault();
            const file = e.target.files?.[0];
            if (file) {
                this.processFile(file, false); 
            }
        },

        processFile(file, fromDrop = false) {
            this.clearError();
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                this.setError('Bitte wählen Sie eine gültige Bilddatei aus (JPG, PNG, GIF, WEBP).');
                this.clearFileInput();
                return;
            }
            
            // Validate file size (2MB limit)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                this.setError(`Das Bild ist zu groß (${sizeMB}MB). Die maximale Dateigröße beträgt 2MB.`);
                this.clearFileInput();
                return;
            }
            
            
            this.selectedFile = file;
            
          
            if (fromDrop) {
                this.setFileToInput(file);
            }
            
           
            this.showPreview(file);
        },

        setFileToInput(file) {
           
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            // Set the files to the input element
            if (this.$refs.fileInput) {
                this.$refs.fileInput.files = dataTransfer.files;
                
                // Trigger the change event for Livewire
                const changeEvent = new Event('change', { bubbles: true });
                this.$refs.fileInput.dispatchEvent(changeEvent);
            }
        },

        showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                this.imageInfo = `${file.name} (${sizeMB}MB)`;
            };
            reader.onerror = () => {
                this.setError('Fehler beim Laden der Bildvorschau.');
            };
            reader.readAsDataURL(file);
        },

        removeImage() {
            this.resetState();
            this.clearFileInput();
            
            if (typeof @this !== 'undefined' && @this.removeImage) {
                @this.removeImage();
            }
        },

        clearFileInput() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
                            const changeEvent = new Event('change', { bubbles: true });
                this.$refs.fileInput.dispatchEvent(changeEvent);
            }
        },

        resetState() {
            this.isDragging = false;
            this.dragCounter = 0;
            this.imagePreview = null;
            this.imageInfo = '';
            this.selectedFile = null;
            this.clearError();
        },

        setError(message) {
            this.errorMessage = message;
        },

        clearError() {
            this.errorMessage = '';
        }
    }
}
</script>