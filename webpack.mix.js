const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/admin.js', 'public/js/admin.js').vue();
mix.js('resources/js/front.js', 'public/js/front.js').vue();

mix.js('resources/admin/js/pages/*', 'public/admin/scripts/pages')
    .js('resources/admin/js/*.js', 'public/admin/scripts');

mix.sass('resources/admin/css/admin.scss', 'public/css')
    .options({
        processCssUrls: false
    });

mix.css("node_modules/lightgallery/dist/css/lightgallery.css", 'public/front/css/gallery.css');
mix.js("node_modules/lightgallery/dist/js/lightgallery-all.js", 'public/front/js/gallery.js');

