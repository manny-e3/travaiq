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
            primary: {
                light: '#9575cd', // Lighter purple
                DEFAULT: '#673AB7', // Deep Royal Purple
                dark: '#5e35b1', // Darker purple
            },
            accent: {
                light: '#FFECB3', // Lighter Amber
                DEFAULT: '#FFC107', // Golden Amber
                dark: '#FFA000', // Darker Amber
            }
        },
        fontFamily: {
            sans: ['Outfit', 'sans-serif'],
        },
        animation: {
            'float': 'float 6s ease-in-out infinite',
            'float-slow': 'float 8s ease-in-out infinite',
            'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            'spin-slow': 'spin 8s linear infinite',
        },
        keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-10px)' },
            }
        }
      },
    },
    plugins: [],
  }
