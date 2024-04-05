const theme = require('./tailwind.theme.js');

module.exports = {
  mode: 'jit',
  content: [
    './develop/**/*.{php,svg}',
    './develop/js/**/*.js'
  ],
  theme: theme.theme
  
}