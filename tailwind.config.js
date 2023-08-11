const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto Slab', ...defaultTheme.fontFamily.serif],
                open_sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#041286'
            },
            maxHeight: {
                '1/4': '25vh',
                '1/2': '50vh',
                '3/4': '75vh',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
