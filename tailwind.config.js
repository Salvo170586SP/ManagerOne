/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/wireui/wireui/resources/**/*.blade.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/View/**/*.php'
  ],
  theme: {
    extend: {
      height: {
        'screen-navbar': 'calc(100vh - 8rem)',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
