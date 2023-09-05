const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./app/Enums/**/*.php",
    ],
    safelist: [
        "sm:max-w-sm",
        "sm:max-w-md",
        "md:max-w-lg",
        "md:max-w-xl",
        "lg:max-w-2xl",
        "lg:max-w-3xl",
        "xl:max-w-4xl",
        "xl:max-w-5xl",
        "2xl:max-w-6xl",
        "2xl:max-w-7xl",
    ],
    theme: {
        extend: {
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xxs': ['0.5rem', '0.7rem'],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
