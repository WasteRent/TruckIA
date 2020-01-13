module.exports = {
  theme: {
    extend: {},
    pagination: theme => ({
        link: 'text-lg px-3 py-2 text-gray-600 no-underline',
        linkActive: 'font-bold text-gray-800',
        linkHover: '',
        linkLast: '',
        linkFirst: '',
        linkDisabled: ''
    })
  },
  variants: {},
  plugins: [
  	require('tailwindcss-plugins/pagination')
  ]
}
