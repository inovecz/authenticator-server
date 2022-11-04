/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
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
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
