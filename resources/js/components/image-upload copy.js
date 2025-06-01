// window.imageUpload = function () {
//     return {
//         isDragging: false,
//         dragCounter: 0,
//         imagePreview: null,
//         imageInfo: "",
//         errorMessage: "",
//         selectedFile: null,

//         init() {
//             this.resetState();
//         },

//         handleDragEnter(e) {
//             e.preventDefault();
//             e.stopPropagation();
//             this.dragCounter++;
//             this.isDragging = true;
//             this.clearError();
//         },

//         handleDragOver(e) {
//             e.preventDefault();
//             e.stopPropagation();
//             this.isDragging = true;
//         },

//         handleDragLeave(e) {
//             e.preventDefault();
//             e.stopPropagation();
//             this.dragCounter--;

//             if (this.dragCounter <= 0) {
//                 this.dragCounter = 0;
//                 this.isDragging = false;
//             }
//         },

//         handleDrop(e) {
//             e.preventDefault();
//             e.stopPropagation();

//             this.isDragging = false;
//             this.dragCounter = 0;

//             const files = e.dataTransfer.files;
//             if (files && files.length > 0) {
//                 this.processFile(files[0], true);
//             }
//         },

//         handleFileSelect(e) {
//             e.preventDefault();
//             const file = e.target.files?.[0];
//             if (file) {
//                 this.processFile(file, false);
//             }
//         },

//         processFile(file, fromDrop = false) {
//             this.clearError();

//             // Validate file type
//             if (!file.type.startsWith("image/")) {
//                 this.setError(
//                     "Bitte wählen Sie eine gültige Bilddatei aus (JPG, PNG, GIF)."
//                 );
//                 this.clearFileInput();
//                 return;
//             }

//             // Validate file size (2MB limit)
//             const maxSize = 2 * 1024 * 1024;
//             if (file.size > maxSize) {
//                 const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
//                 this.setError(
//                     `Das Bild ist zu groß (${sizeMB}MB). Die maximale Dateigröße beträgt 2MB.`
//                 );
//                 this.clearFileInput();
//                 return;
//             }

//             // Store the file reference
//             this.selectedFile = file;

//             if (fromDrop) {
//                 this.setFileToInput(file);
//             }

//             this.showPreview(file);
//         },

//         setFileToInput(file) {
//             // Create a new FileList with the dropped file
//             const dataTransfer = new DataTransfer();
//             dataTransfer.items.add(file);

//             if (this.$refs.fileInput) {
//                 this.$refs.fileInput.files = dataTransfer.files;

//                 const changeEvent = new Event("change", { bubbles: true });
//                 this.$refs.fileInput.dispatchEvent(changeEvent);
//             }
//         },

//         showPreview(file) {
//             const reader = new FileReader();
//             reader.onload = (e) => {
//                 this.imagePreview = e.target.result;
//                 const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
//                 this.imageInfo = `${file.name} (${sizeMB}MB)`;
//             };
//             reader.onerror = () => {
//                 this.setError("Fehler beim Laden der Bildvorschau.");
//             };
//             reader.readAsDataURL(file);
//         },

//         removeImage() {
//             this.resetState();
//             this.clearFileInput();
//         },

//         clearFileInput() {
//             if (this.$refs.fileInput) {
//                 this.$refs.fileInput.value = "";
//                 const changeEvent = new Event("change", { bubbles: true });
//                 this.$refs.fileInput.dispatchEvent(changeEvent);
//             }
//         },

//         resetState() {
//             this.isDragging = false;
//             this.dragCounter = 0;
//             this.imagePreview = null;
//             this.imageInfo = "";
//             this.selectedFile = null;
//             this.clearError();
//         },

//         setError(message) {
//             this.errorMessage = message;
//         },

//         clearError() {
//             this.errorMessage = "";
//         },
//     };
// };

// // Listen for Livewire events to reset components
// document.addEventListener("livewire:init", () => {
//     Livewire.on("teaserCreated", () => {
//         // Find all image upload components and reset them
//         const uploadComponents = document.querySelectorAll(
//             '[x-data*="imageUpload"]'
//         );
//         uploadComponents.forEach((component) => {
//             if (component._x_dataStack && component._x_dataStack[0]) {
//                 const data = component._x_dataStack[0];
//                 if (typeof data.resetState === "function") {
//                     data.resetState();
//                 }
//             }
//         });
//     });
// });
