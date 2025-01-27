import defaultTheme from "tailwindcss/defaultTheme";
const textStroke = require("tailwindcss-text-stroke");
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                poppins: ["Poppins"],
            },
            colors: {
                primary: {
                    DEFAULT: "#3477F6",
                    100: "#C0D5FC",
                    200: "#A2C0FB",
                    300: "#7DA8F9",
                    400: "#5D92F8",
                    800: "#1D4187",
                    900: "#163267",
                },
                secondary: {
                    DEFAULT: "#FFCB55",
                    400: "#FFD577",
                    600: "#E8B94D",
                },
                gray: {
                    1: "#333333",
                    2: "#4F4F4F",
                    3: "#828282",
                },
            },
            gradientColorStops: {
                linearCardStart: "rgba(52, 119, 246, 0.1)",
                linearCardMid: "rgba(22, 50, 103, 0)",
                linearCardEnd: "rgba(22, 50, 103, 0.6)",
                radialCardStart: "rgba(255, 255, 255, 0.8) 0%",
                radialCardMid: "rgba(167, 163, 221, 0.5) 50%",
                radialCardEnd: "rgba(80, 72, 188, 1) 100%",
            },
            backgroundImage: {
                "gradient-custom":
                    "linear-gradient(to bottom, rgba(0, 0, 0, 0) 45%, rgba(52, 119, 246, 1) 100%)",
            },
            backgroundColor: { "button-custom1": "rgba(52, 119, 246, 0.13)" },
        },
    },
    plugins: [textStroke],
};
