let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    }).sourceMaps()
}
/*
.js('resources/assets/js/app.js', 'public/js/main.bundle.js')
    .js('resources/assets/js/login.js', 'public/js/login.bundle.js')
 */
mix.disableNotifications();
mix
    .sass('resources/assets/sass/app.scss', 'public/css/main.bundle.css')
    .options({
        processCssUrls: false
    })
    .version()
    .sourceMaps();
