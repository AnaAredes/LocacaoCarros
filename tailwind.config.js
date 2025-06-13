import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                montserrat: ['Montserrat', 'sans-serif'],
                raleway: ['Raleway', 'sans-serif'],
              'open-sans': ['Open Sans', 'sans-serif'],
      },
      colors: {
        'primary-blue': '#0A558C', // Azul mais escuro
        'accent-orange': '#FF8C00', // Laranja vibrante
        'dark-gray': '#333333',
        'light-gray': '#F5F5F5',
        'text-dark': '#222222',
        'text-light': '#FFFFFF',
        beige: {
          light: '#F5F5DC',
          dark: '#D4C9A4',
        },
        purple: {
          light: '#9B4D96', 
          dark: '#6B1E8C',
        },
        orange: {
          light: '#FF7F32',
          dark: '#F97316',
        },
      },
    },
  },

    plugins: [forms],
};