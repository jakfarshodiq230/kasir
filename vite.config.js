import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "public/build/css/login.css",
                "public/images/mata.png",
            ],
            refresh: true,
        }),
    ],
});
