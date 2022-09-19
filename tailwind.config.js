/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./smarty/templates/**/*.tpl", "./smarty/templates/*.tpl"],
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
                }
            }
        },
    },
    plugins: [],
}
