/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php" //tailwind para la paginacion
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

