/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#1e40af",
        secondary: "#64748b",
      },
    },
  },
  plugins: [],
}
