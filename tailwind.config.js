import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable class-based dark mode
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './config/theme.php', // Critical for unified variables
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: 'hsl(var(--color-primary) / <alpha-value>)',
                    sat: 'hsl(var(--color-primary-sat) / <alpha-value>)',
                    desat: 'hsl(var(--color-primary-desat) / <alpha-value>)',
                },
                secondary: {
                    DEFAULT: 'hsl(var(--color-secondary) / <alpha-value>)',
                    sat: 'hsl(var(--color-secondary-sat) / <alpha-value>)',
                    desat: 'hsl(var(--color-secondary-desat) / <alpha-value>)',
                },
                tertiary: {
                    DEFAULT: 'hsl(var(--color-tertiary) / <alpha-value>)',
                    sat: 'hsl(var(--color-tertiary-sat) / <alpha-value>)',
                    desat: 'hsl(var(--color-tertiary-desat) / <alpha-value>)',
                },
                accent: {
                    DEFAULT: 'hsl(var(--color-accent) / <alpha-value>)',
                    sat: 'hsl(var(--color-accent-sat) / <alpha-value>)',
                    desat: 'hsl(var(--color-accent-desat) / <alpha-value>)',
                },
            },
            backgroundImage: {
                'linear-1': 'var(--bg-linear-1)',
                'linear-2': 'var(--bg-linear-2)',
                'radial-1': 'var(--bg-radial-1)',
                'radial-2': 'var(--bg-radial-2)',
            }
        },
    },

    plugins: [forms],
};
