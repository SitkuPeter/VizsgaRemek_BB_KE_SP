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
            // Extend font families
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Merriweather', ...defaultTheme.fontFamily.serif],
                mono: ['Fira Code', ...defaultTheme.fontFamily.mono],
            },

            // Custom colors
            colors: {
                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                },
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
                roulette: {
                    green: '#15803d',
                    red: '#ef4444',
                    black: '#1e293b',
                },
            },

            // Custom spacing (padding, margin, etc.)
            spacing: {
                '128': '32rem',
                '144': '36rem',
                '160': '40rem',
            },

            // Custom animation durations
            animation: {
                'spin-slow': 'spin 5s linear infinite',
                'bounce-slow': 'bounce 3s infinite',
                'fade-in': 'fadeIn 1s ease-in-out',
            },

            // Keyframes for animations
            keyframes: {
                spin: {
                    '0%': { transform: 'rotate(0deg)' },
                    '100%': { transform: 'rotate(360deg)' },
                },
                bounce: {
                    '0%, 100%': { transform: 'translateY(-25%)' },
                    '50%': { transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },

            // Custom screen sizes (responsive breakpoints)
            screens: {
                'xs': '400px',
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
                '3xl': '1920px',
            },
        },
    },
    plugins: [forms],
};