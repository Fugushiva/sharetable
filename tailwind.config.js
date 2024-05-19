import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import {buttons} from './resources/js/tailwindcss/buttons.js'


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './src/**/*.{html,js,jsx,ts,tsx}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        function({addComponents}){
            addComponents(buttons);
        },
    ],
};
