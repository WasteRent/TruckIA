module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue"
  ],
  safelist: [
      'tooltip',
      'em',
      'bg-yellow-100',
      'text-yellow-800',
      'border-yellow-200',
      'bg-green-100',
      'text-green-800',
      'border-green-200',
      'bg-blue-100',
      'text-blue-800',
      'border-blue-200',
      'bg-gray-100',
      'text-gray-800',
      'border-gray-200',
      'bg-red-100',
      'text-red-800',
      'border-red-200'
  ],
  theme: {
    extend: {
          colors: {
            'green-web': '#00B74F'
          },
          gridTemplateColumns: {
            '24': 'repeat(24, minmax(0, 1fr))',
          }
        }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio')
  ],
}   