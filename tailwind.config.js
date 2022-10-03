/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors:{
        'extra-dark-blue': '#151f32',
        'dark-blue': '#182d4b',
        'dark-blue-hover' : "#182d4b",
        'light-blue': '#328af1',
        'light-blue-hover': '#2779bd',
        'text-white' : 'hsla(0,0%,100%,.85)',
        'grey' : 'rgb(120 144 156 / 1)',
        'panel-700' : '#182D4B',
        'panel-800' : '#16273F',
        'blue': 'rgb(50 138 241)',

      },
    },
  },
  plugins: [

  ],
}
