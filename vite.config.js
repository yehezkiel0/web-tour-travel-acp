import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/front/modules/hotel-search.js",
                "resources/js/front/modules/hotel-datepicker.js",
            ],
            refresh: true,
        }),
    ],

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
        host: "0.0.0.0",
        port: 5173,
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true,
        },
    },

    build: {
        manifest: "manifest.json",
        outDir: "public/build",

        rollupOptions: {
            output: {
                manualChunks: undefined,

                chunkFileNames: "assets/[name]-[hash].js",
                entryFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash].[ext]",
            },
        },

        chunkSizeWarningLimit: 2000,
        // Minification with Terser for better compression
        minify: "terser",
        terserOptions: {
            compress: {
                drop_console: process.env.NODE_ENV === "production",
                drop_debugger: true,
                pure_funcs: ["console.log", "console.info"],
            },
        },

        sourcemap: process.env.NODE_ENV !== "production",
    },

    // Optimize dependencies
    optimizeDeps: {
        include: ["jquery", "swiper"],
        exclude: ["tinymce"],
    },

    // Define global constants
    define: {
        global: "window",
    },
});
