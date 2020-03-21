const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            colors: {
                'semi-55': 'rgba(0, 0, 0, 0.55)',
                green: {
                    ...colors.green,
                    'truckts': '#00AC55',
                    'trucktslighter': '#00bf5f'
                },

            }
        },
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