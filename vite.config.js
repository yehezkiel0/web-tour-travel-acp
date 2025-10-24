import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            external: [],
            output: {
                manualChunks: (id) => {
                    // Split TinyMCE into separate chunk
                    if (id.includes("node_modules/tinymce")) {
                        return "tinymce";
                    }
                    // Split jQuery and other large libraries
                    if (id.includes("node_modules/jquery")) {
                        return "jquery";
                    }
                    // Split Swiper into separate chunk
                    if (id.includes("node_modules/swiper")) {
                        return "swiper";
                    }
                },
            },
        },
        chunkSizeWarningLimit: 1000,
    },
});
