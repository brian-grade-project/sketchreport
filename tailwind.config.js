/** @type {import('tailwindcss').Config} */
import daisyui from "daisyui";
export default {
  content: [
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    daisyui
  ],
}

