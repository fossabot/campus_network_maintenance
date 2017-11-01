let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/admin/js')

mix.copy('node_modules/element-ui/lib/theme-chalk/index.css', 'public/admin/css/app.css')
mix.copyDirectory('node_modules/element-ui/lib/theme-chalk/fonts', 'public/admin/css/fonts')

mix.extract(['vue', 'element-ui'])

mix.version()
