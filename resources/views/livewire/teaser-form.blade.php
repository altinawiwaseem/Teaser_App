<div class="max-w-4xl mx-auto px-4">
    <!-- Form Section with Green Header -->
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Green Header -->
        <div class="bg-green-600 text-white text-center py-4">
            <h2 class="text-lg font-medium">Inhalte hochladen</h2>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column - Überschrift & Text -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Überschrift</label>
                            <input wire:model="title" type="text" placeholder=""
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" />
                            @error('title') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Text</label>
                            <textarea wire:model="text" placeholder="" rows="8"
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none resize-none"></textarea>
                            @error('text') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Right Column - Image Upload -->
                    <div x-data="imageUpload()">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Bild hochladen</label>
                        <div class="border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200 cursor-pointer"
                            :class="isDragging ? 'border-green-500 bg-green-50 scale-105' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
                            @dragenter.prevent="handleDragEnter" @dragover.prevent="handleDragOver"
                            @dragleave.prevent="handleDragLeave" @drop.prevent="handleDrop"
                            @click="$refs.fileInput.click()">

                            <input x-ref="fileInput" wire:model="image" type="file" accept="image/*" class="hidden"
                                @change="handleFileSelect($event)" />

                            <div x-show="!imagePreview">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <span
                                    class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium inline-block mb-2">
                                    📁 Datei hochladen
                                </span>
                                <p class="text-gray-500 text-sm">oder Drag and Drop</p>
                                <p class="text-gray-400 text-xs mt-1">Max. 2MB - JPG, PNG, GIF</p>
                            </div>

                            <!-- Image Preview inside drop zone -->
                            <div x-show="imagePreview" x-transition class="relative">
                                <img :src="imagePreview" alt="Preview"
                                    class="max-w-full max-h-48 object-cover rounded-lg border-2 border-gray-300 mx-auto">
                                <button type="button" @click.stop="removeImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 transition-colors">
                                    ×
                                </button>
                            </div>
                        </div>

                        <!-- Image Info (outside drop zone) -->
                        <div x-show="imagePreview" x-transition class="mt-4">
                            <p x-text="imageInfo" class="text-sm text-gray-600"></p>
                        </div>

                        <!-- Error Messages -->
                        @error('image') <div class="text-red-500 text-sm mt-2">{{ $message }}</div> @enderror
                        <div x-show="errorMessage" x-transition class="text-red-500 text-sm mt-2" x-text="errorMessage">
                        </div>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end pt-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                        Inhalte ausspielen
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
                this.setError('Bitte wählen Sie eine gültige Bilddatei aus (JPG, PNG, GIF).');
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
            
            // Store the file reference
            this.selectedFile = file;
            
            if (fromDrop) {
                this.setFileToInput(file);
            }
            
           
            this.showPreview(file);
        },

        setFileToInput(file) {
            // Create a new FileList with the dropped file
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            
            if (this.$refs.fileInput) {
                this.$refs.fileInput.files = dataTransfer.files;
                
               
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

// Listen for Livewire events to reset components
document.addEventListener('livewire:init', () => {
    Livewire.on('teaserCreated', () => {
        // Find all image upload components and reset them
        const uploadComponents = document.querySelectorAll('[x-data*="imageUpload"]');
        uploadComponents.forEach(component => {
            if (component._x_dataStack && component._x_dataStack[0]) {
                const data = component._x_dataStack[0];
                if (typeof data.resetState === 'function') {
                    data.resetState();
                }
            }
        });
    });
});
</script>