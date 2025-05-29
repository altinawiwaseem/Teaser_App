import "./bootstrap";
import Alpine from "alpinejs";

// Initialize Alpine only once
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}
