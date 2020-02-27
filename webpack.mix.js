const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/libs/css/bootstrap.min.css',
    'resources/assets/libs/css/dataTables.bootstrap4.min.css',
    'resources/assets/libs/css/jquery.dataTables.min.css',
],'public/css/libs.css');
mix.scripts([
    'resources/assets/libs/js/jquery.js',
    'resources/assets/libs/js/jquery.validate.js',
    'resources/assets/libs/js/jquery.dataTables.min.js',
    'resources/assets/libs/js/bootstrap.min.js',
    'resources/assets/libs/js/dataTables.bootstrap4.min.js',
],'public/js/libs.js');