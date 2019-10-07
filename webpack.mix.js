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

mix.scripts(['resources/js/uppy.js', 'resources/js/croppie.js'], 'public/js/vendor.js');

mix.scripts(['resources/js/l-crop_image.js', 'resources/js/l-multiple_files.js', 'resources/js/l-common_form.js'], 'public/js/l-module.js');

mix.styles(['resources/sass/uppy.css', 'resources/sass/croppie.css'], 'public/css/vendor.css');

mix.sass('resources/sass/l-module.scss', 'public/css');

mix.scripts([
    'resources/js/topic/datatable.js',
    'resources/js/topic/form.js'
], 'public/js/topic.js');

mix.scripts([
    'resources/js/user/datatable.js',
    'resources/js/user/form.js'
], 'public/js/user.js');

mix.scripts([
    'resources/js/role/datatable.js',
    'resources/js/role/form.js'
], 'public/js/role.js');

mix.scripts([
    'resources/js/topic_category/datatable.js'
], 'public/js/topic_category.js');

if (mix.inProduction()) {
    mix.sourceMaps().version();
}
