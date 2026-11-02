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
            colors: {
                brand: {
                    DEFAULT: '#0F5C5C',
                    hover: '#0B4747',
                    active: '#083838',
                    light: '#E8F2F2',
                    50: '#F2F7F7',
                    100: '#E1EEEE',
                    600: '#0F5C5C',
                    700: '#0B4747',
                    800: '#083838',
                },
                accent: {
                    DEFAULT: '#C9822B',
                    hover: '#AB6D22',
                    light: '#FDF6ED',
                    50: '#FCF9F3',
                    100: '#F7EDDC',
                },
                paper: '#F6F5F1',
                ink: {
                    DEFAULT: '#1F2933',
                    muted: '#5F6B76',
                    subtle: '#8C97A1',
                },
                line: {
                    DEFAULT: '#E4E2DA',
                    dark: '#D0CEC4',
                },
                status: {
                    success: '#2F7D4F',
                    'success-light': '#EBF5F0',
                    danger: '#B3392F',
                    'danger-light': '#FBF0EF',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"Source Serif 4"', ...defaultTheme.fontFamily.serif],
            },
            borderRadius: {
                sm: '4px',
                DEFAULT: '6px',
                md: '6px',
                card: '10px',
                lg: '10px',
                xl: '12px',
            },
            boxShadow: {
                card: '0 1px 3px rgba(31, 41, 51, 0.04)',
                modal: '0 10px 30px rgba(15, 92, 92, 0.12)',
                toast: '0 4px 12px rgba(31, 41, 51, 0.08)',
            },
        },
    },

    plugins: [forms],
};
