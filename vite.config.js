import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
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
                manualChunks: (id) => {
                    // Vendor chunks - separate by library
                    if (id.includes("node_modules")) {
                        // TinyMCE - Large editor (1.2MB)
                        if (id.includes("tinymce")) {
                            return "vendor-tinymce";
                        }
                        // jQuery - Legacy support
                        if (id.includes("jquery")) {
                            return "vendor-jquery";
                        }
                        // Swiper - Slider library
                        if (id.includes("swiper")) {
                            return "vendor-swiper";
                        }
                        // All other vendor packages
                        return "vendor";
                    }

                    // Separate admin modules
                    if (id.includes("resources/js/admin")) {
                        return "admin";
                    }

                    // Separate front modules
                    if (id.includes("resources/js/front")) {
                        return "front";
                    }
                },

                // Better file naming for cache busting
                chunkFileNames: "assets/[name]-[hash].js",
                entryFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash].[ext]",
            },
        },

        chunkSizeWarningLimit: 1000,

        // Minification with Terser for better compression
        minify: "terser",
        terserOptions: {
            compress: {
                drop_console: process.env.NODE_ENV === "production", // Remove console.log in production
                drop_debugger: true,
                pure_funcs: ["console.log", "console.info"], // Remove specific console methods
            },
        },

        // Enable CSS code splitting
        cssCodeSplit: true,

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
