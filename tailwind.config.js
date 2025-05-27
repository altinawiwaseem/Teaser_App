import lineClamp from "tailwindcss/line-clamp";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/Http/Livewire/**/*.php", // For Livewire components
    ],

    theme: {
        extend: {
            padding: {
                "9/16": "56.25%", // 16:9 Aspect Ratio
            },
        },
    },

    plugins: [forms, lineClamp],
};
