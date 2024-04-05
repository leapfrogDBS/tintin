const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    
    theme: {
       
        fontFamily: {
            'sans': ['Figtree', ...defaultTheme.fontFamily.sans],
            'tintin': ['tintin', ...defaultTheme.fontFamily.sans],
            'quote': ['quote', ...defaultTheme.fontFamily.sans],
        },

       
        container: {
            padding: {
                DEFAULT: '40px',
                lg: '80px',   
            },
            center: true,
            
        },
        extend: {
            colors: {
              'shop-front-blue': '#133C94',
              'covers-white' : '#FCFCF9',
              'covers-orange' : '#FC8517',
              'covers-turquoise' : '#2EB098',
              'covers-yellow' : '#F9D931',
              'covers-blue' : '#3AB6E9',
            },
            screens: {
                'xs': '480px',
              },
            boxShadow: {
                custom: '0px 4px 4px 0px rgba(0, 0, 0, 0.25)',
                announcement: '0px 2px 4px 0px rgba(0, 0, 0, 0.20)',
            },
            spacing: {
                'dynamic-top': 'var(--dynamic-top-offset)',
              },
            
        },
       
      },

}