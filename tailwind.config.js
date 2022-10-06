/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./smarty/templates/**/*.tpl",
        "./smarty/templates/*.tpl",
        "./_public/installer.php",
        "./_public/content/js/*.js",
        "./_public/content/js/**/*.js"
    ],
    theme: {
        fontFamily: {
            'sans': ['Open Sans', 'sans-serif']
        },
        extend: {
            colors: {
                green: {
                    'DEFAULT': "#31921f",
                    50: "#59ba47",
                    100: "#4fb03d",
                    200: "#45a633",
                    300: "#3b9c29",
                    400: "#31921f",
                    500: "#278815",
                    600: "#1d7e0b",
                    700: "#137401",
                    800: "#096a00",
                    900: "#006000"
                },
                'default': {
                    DEFAULT: '#2E3041',
                    '50': '#8185A6',
                    '100': '#75799D',
                    '200': '#616589',
                    '300': '#505371',
                    '400': '#3F4259',
                    '500': '#2E3041',
                    '600': '#171820',
                    '700': '#000000',
                    '800': '#000000',
                    '900': '#000000'
                },
            }
        },
    },
    plugins: [],
}
