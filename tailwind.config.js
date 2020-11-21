const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
    purge: {
        content: [
            './resources/views/**/*.blade.php',
            './resources/js/**/*.vue'
        ],
        options: {
            safelist: [
                'tooltip',
                'em',
                'pagination',
                'page-item',
                'page-link',
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
            ]
        }
    },
    theme: {
        extend: {
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
    variants: {
        cursor: ['responsive', 'hover', 'focus']
    },
    plugins: [
        require('tailwindcss-plugins/pagination'),
        require('@tailwindcss/ui')
    ]
}