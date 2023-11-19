/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#ffffff',
        secondary: '#333333',
        lightgrey: '#474747'
      },
    },
  },
  plugins: [],
}

