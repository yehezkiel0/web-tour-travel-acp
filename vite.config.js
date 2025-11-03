import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js"], // Only JS, CSS will be imported in JS
            refresh: true,
        }),
    ],

    // Path aliases for cleaner imports
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
            "@admin": path.resolve(__dirname, "./resources/js/admin"),
            "@front": path.resolve(__dirname, "./resources/js/front"),
            "@css": path.resolve(__dirname, "./resources/css"),
            "@images": path.resolve(__dirname, "./public/images"),
        },
    },

    // Server configuration for mobile simulator and HMR
    server: {
        host: "0.0.0.0", // Allow external access
        port: 5173,
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true, // Better compatibility
        },
    },

    build: {
        manifest: "manifest.json", // Put manifest in root of build folder, not in .vite subfolder
        outDir: "public/build",

        rollupOptions: {
            output: {
                // No code splitting - bundle everything into single files
                manualChunks: undefined,

                // Simple file naming
                chunkFileNames: "assets/[name]-[hash].js",
                entryFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash].[ext]",
            },
        },

        chunkSizeWarningLimit: 2000, // Increase limit since we're bundling everything

        // Minification with Terser for better compression
        minify: "terser",
        terserOptions: {
            compress: {
                drop_console: process.env.NODE_ENV === "production", // Remove console.log in production
                drop_debugger: true,
                pure_funcs: ["console.log", "console.info"], // Remove specific console methods
            },
        },

        // Disable CSS code splitting - bundle all CSS into one file
        cssCodeSplit: false,

        // Source maps for debugging (only in development)
        sourcemap: process.env.NODE_ENV !== "production",
    },

    // Optimize dependencies
    optimizeDeps: {
        include: ["jquery", "swiper"],
        exclude: ["tinymce"], // TinyMCE loaded separately
    },

    // Define global constants
    define: {
        // Ensure jQuery is available as global
        global: "window",
    },
});
