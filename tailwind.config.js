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
                // 🎨 Warna dari config sebelumnya
                'primary-purple': '#8C52FF',
                'light-purple': '#EEDCFF',
                'pastel-blue': '#FFFFFF',
                'dark-gray': '#212121',
                'custom-green': '#00C853',
                'custom-yellow': '#FFCA28',
                'custom-red': '#E53935',
                'custom-orange': '#FFB74D',
                'sidebar-active': '#8C52FF',
                'text-primary': '#333333',
                'text-secondary': '#666666',
                'text-gray': '#777777',
                'border-light': '#F2F2F2',

                // 🟣 Palet tambahan dari kode pertama
                purple: {
                    50: '#faf5ff',
                    100: '#f3e8ff',
                    500: '#8b5cf6',
                    600: '#6E00FF',
                    700: '#5A00D1',
                },
                green: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    500: '#1CD062',
                    600: '#16a34a',
                },
            },

            // 🧩 Font Family (gabungan Inter + Poppins)
            fontFamily: {
                'poppins': ['Poppins', 'sans-serif'],
                'inter': ['Inter', 'sans-serif'],
            },

            // 🌫️ Shadow gabungan (semua varian)
            boxShadow: {
                'soft': '0px 4px 16px rgba(0, 0, 0, 0.08)', // dari config pertama
                'purple-glow': '0px 3px 6px rgba(110, 0, 255, 0.25)', // dari config pertama
                'medium': '0 3px 8px rgba(0, 0, 0, 0.05)',
                'card': '0 4px 10px rgba(0, 0, 0, 0.05)',
            },

            // 🔢 Tambahan spacing
            spacing: {
                '18': '4.5rem',
            },
        },
    },
    plugins: [],
}
