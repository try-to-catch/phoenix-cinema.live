import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'sans-serif': ['Rubik', 'sans-serif'],
                'serif': ['Roboto Slab', 'serif'],
            },
            colors: {
                'primary': '#1D2024',
                'secondary': '#F37515',
                'tertiary': '#1F2226',
                'neutral': {
                    850: 'rgb(35,35,35)',
                },
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1.25rem',
                },
            },
        },
    },

    plugins: [forms],
};
