let mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {
                // Matches all PHP or JSON files in `resources/lang` directory.
                test: /resources[\\\/]lang.+\.(php|json)$/,
                loader: 'laravel-localization-loader',
            }
        ]
    }
});

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
//mix.disableNotifications();
mix.js('resources/assets/js/app.js', 'public/js/main.bundle.js')
    .sass('resources/assets/sass/app.scss', 'public/css/main.bundle.css')
    .sass('resources/assets/sass/print.scss', 'public/css/print.css')
    .options({
        processCssUrls: false
    })
    .version()
    .sourceMaps();
