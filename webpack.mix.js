const mix = require('laravel-mix');
const tailwindcss = require("tailwindcss");
const glob = require("glob-all");
const PurgecssPlugin = require("purgecss-webpack-plugin");

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

mix.js('resources/js/app.js', 'public/js').scripts([
    'public/js/app.js',
    'resources/js/sortable.js',
    'public/js/drag.js'
], 'public/js/all.js');

mix.postCss('resources/sass/app.css', 'public/css', [tailwindcss("./tailwind.config.js")]);

if (mix.inProduction()) {
  mix.version();
}
