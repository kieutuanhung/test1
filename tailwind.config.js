import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: {
                    DEFAULT: '#111111',
                    900: '#0a0a0a',
                    800: '#171717',
                    700: '#262626',
                },
                accent: {
                    DEFAULT: '#e0392c',
                    600: '#e0392c',
                    700: '#c22a1f',
                },
            },
            letterSpacing: {
                widest2: '.18em',
            },
        },
    },

    plugins: [forms],
};
