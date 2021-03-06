let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/statics/admin/js')

mix.copy('node_modules/element-ui/lib/theme-chalk/index.css', 'public/statics/admin/css/app.css')
mix.copyDirectory('node_modules/element-ui/lib/theme-chalk/fonts', 'public/statics/admin/css/fonts')

mix.extract(['babel-polyfill', 'vue', 'vue-router', 'element-ui', 'axios'])

mix.version()
