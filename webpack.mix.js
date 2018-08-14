let mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        loaders: [
            {
                test: /jquery-mousewheel/, loader: "imports?define=>false&this=>window",
                include: [/node_modules\/jquery-mousewheel/]
            },
            {
                test: /malihu-custom-scrollbar-plugin/, loader: "imports?define=>false&this=>window",
                include: [/node_modules\/malihu-custom-scrollbar-plugin/]
            }
        ]
    }

})

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
    .options({
        processCssUrls: false
    })
    .version()
    .sourceMaps();
