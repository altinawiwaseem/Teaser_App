window.imageUpload = function (options = {}) {
    return {
        isDragging: false,
        dragCounter: 0,
        imagePreview: null,
        imageInfo: "",
        errorMessage: "",
        selectedFile: null,

        // Configuration options
        tempImageUrl: options.tempImageUrl || null,
        hasExistingImage: options.hasExistingImage || false,
        livewireMethod: options.livewireMethod || null,

        init() {
            this.resetState();

            // Initialize with existing temp image if available
            if (this.tempImageUrl) {
                this.imagePreview = this.tempImageUrl;
                this.imageInfo = this.hasExistingImage
                    ? "Aktuelles Bild"
                    : "Neues Bild ausgewählt";
            }

            // Listen for Livewire events
            if (this.$wire) {
                this.$wire.on("teaserCreated", () => {
                    this.resetState();
                });

                this.$wire.on("teaserUpdated", () => {
                    this.resetState();
                });
            }
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
            const file = e.target.files?.[0];
            if (file) {
                this.processFile(file, false);
            }
        },

        processFile(file, fromDrop = false) {
            this.clearError();

            // Validate file type
            if (!file.type.startsWith("image/")) {
                this.setError(
                    "Bitte wählen Sie eine gültige Bilddatei aus (JPG, PNG, GIF, WEBP)."
                );
                this.clearFileInput();
                return;
            }

            // Validate file size (2MB limit)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                this.setError(
                    `Das Bild ist zu groß (${sizeMB}MB). Die maximale Dateigröße beträgt 2MB.`
                );
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

            if (this.$refs.fileInput) {
                this.$refs.fileInput.files = dataTransfer.files;

                const changeEvent = new Event("change", { bubbles: true });
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
                this.setError("Fehler beim Laden der Bildvorschau.");
            };
            reader.readAsDataURL(file);
        },

        removeImage() {
            this.resetState();
            this.clearFileInput();

            // Call Livewire method if specified
            if (
                this.livewireMethod &&
                this.$wire &&
                typeof this.$wire[this.livewireMethod] === "function"
            ) {
                this.$wire[this.livewireMethod]();
            }
        },

        clearFileInput() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = "";
                const changeEvent = new Event("change", { bubbles: true });
                this.$refs.fileInput.dispatchEvent(changeEvent);
            }
        },

        resetState() {
            this.isDragging = false;
            this.dragCounter = 0;
            this.imagePreview = this.tempImageUrl; // Keep existing image if available
            this.imageInfo =
                this.hasExistingImage && this.tempImageUrl
                    ? "Aktuelles Bild"
                    : "";
            this.selectedFile = null;
            this.clearError();
        },

        setError(message) {
            this.errorMessage = message;
        },

        clearError() {
            this.errorMessage = "";
        },
    };
};
