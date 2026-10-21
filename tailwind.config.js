/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./app/views/**/*.php', './app/Data/**/*.php', './public/assets/js/**/*.js'],
  theme: {
    extend: {
      colors: {
        navy: { 700: '#16294A', 800: '#0F1F3A', 900: '#0B192C' },
        brand: {
          blue: '#1F5FA8',
          'blue-dark': '#174A85',
          'blue-light': '#E8F0FA',
          orange: '#F58220',
          'orange-dark': '#D96D10',
        },
      },
      fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
    },
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
