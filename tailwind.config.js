const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('./resources/js/tailwindcss/forms.js');
const { buttons } = require('./resources/js/tailwindcss/buttons.js');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './src/**/*.{html,js,jsx,ts,tsx}',
    ],

    theme: {

        extend: {
            fontFamily: {
                sans: ['Roboto', "sans-serif"],
                title: ['Saudagar', "serif"],
            },
            colors: {
                'red-750': '#991A14',
            },
        },
    },

    plugins: [
        function ({ addComponents }) {
            addComponents(buttons);
            addComponents(forms);
        },
    ],
};
