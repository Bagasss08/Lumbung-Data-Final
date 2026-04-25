import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

import { cloudflare } from "@cloudflare/vite-plugin";

export default defineConfig({
    plugins: [laravel({
        input: ["resources/css/app.css", "resources/js/app.js"],
        refresh: true,
    }), tailwindcss(), cloudflare()],
    server: {
        host: "0.0.0.0",
        port: 5173,
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true, // ← ini fix untuk Windows
            interval: 1000,
            ignored: ["**/storage/framework/views/**"],
        },
    },
});