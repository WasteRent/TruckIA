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
          screens: {
            'tablet': '1200px',
          },
          colors: {
            'green-web': '#00B74F',
            'primary': {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
              950: '#082f49'
            },
            'accent': {
              50: '#fef3f2',
              100: '#fee5e2',
              200: '#fecfca',
              300: '#fdb0a6',
              400: '#fb8373',
              500: '#f35e47',
              600: '#e0412e',
              700: '#bc3320',
              800: '#9c2f1e',
              900: '#812d20',
              950: '#46140c'
            },
            'success': {
              50: '#f0fdf4',
              100: '#dcfce7',
              200: '#bbf7d0',
              300: '#86efac',
              400: '#4ade80',
              500: '#22c55e',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
              950: '#052e16'
            },
            'dark': {
              50: '#f8fafc',
              100: '#f1f5f9',
              200: '#e2e8f0',
              300: '#cbd5e1',
              400: '#94a3b8',
              500: '#64748b',
              600: '#475569',
              700: '#334155',
              800: '#1e293b',
              900: '#0f172a',
              950: '#020617'
            }
          },
          gridTemplateColumns: {
            '24': 'repeat(24, minmax(0, 1fr))',
          },
          backgroundImage: {
            'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
            'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
          },
          animation: {
            'fade-in': 'fadeIn 0.5s ease-in-out',
            'slide-up': 'slideUp 0.5s ease-out',
            'slide-down': 'slideDown 0.5s ease-out',
            'scale-in': 'scaleIn 0.3s ease-out',
            'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideUp: {
              '0%': { transform: 'translateY(20px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            slideDown: {
              '0%': { transform: 'translateY(-20px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            scaleIn: {
              '0%': { transform: 'scale(0.9)', opacity: '0' },
              '100%': { transform: 'scale(1)', opacity: '1' },
            },
          },
          boxShadow: {
            'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
            'soft-xl': '0 10px 40px -10px rgba(0, 0, 0, 0.1)',
            'inner-soft': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
            'glow': '0 0 20px rgba(14, 165, 233, 0.3)',
            'glow-lg': '0 0 30px rgba(14, 165, 233, 0.4)',
          },
          backdropBlur: {
            xs: '2px',
          },
        }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio')
  ],
}   