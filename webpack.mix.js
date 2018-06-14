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

mix.js('resources/assets/js/app.js', 'public/js');
//.sass('resources/assets/sass/bundle.scss', 'public/css');
//.sass('resources/assets/plugins/**/plugin.scss', 'public/css');

mix.styles(
    ['node_modules/phonon/dist/css/phonon.css'], 'public/css/pda.css'
);
mix.styles(
    ['resources/assets/plugins/bootstrap-datepicker3.css','resources/assets/plugins/fontawesome-all.min.css'], 'public/css/picker.css'
);
mix.scripts([
    'resources/assets/vendors/jquery-3.2.1.min.js',
    'resources/assets/vendors/selectize.min.js',
    'resources/assets/plugins/bootstrap-datepicker.js'
], 'public/js/plugins.js');



