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
    'resources/js/sortable.js'
], 'public/js/all.js');

mix.postCss('resources/sass/app.css', 'public/css', [tailwindcss("./tailwind.config.js")]);


if (mix.inProduction()) {
  mix.version();
  
  mix.webpackConfig({
    plugins: [
      new PurgecssPlugin({

        // Specify the locations of any files you want to scan for class names.
        paths: glob.sync([
          path.join(__dirname, "resources/views/**/*.blade.php"),
          path.join(__dirname, "resources/js/**/*.vue")
        ]),
        whitelist: [
          'em',
          'pagination',
          'page-item',
          'page-link',
          'bg-yellow-100',
          'text-yellow-800',
          'border-yellow-200',
          'bg-green-100',
          'text-green-800',
          'border-green-200',
          'bg-blue-100',
          'text-blue-800',
          'border-blue-200',
          'bg-gray-100',
          'text-gray-800',
          'border-gray-200',
          'bg-red-100',
          'text-red-800',
          'border-red-200'
        ],
        extractors: [
          {
            extractor: class {
            	static extract(content) {
	        	    return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
	        	}
            },

            // Specify the file extensions to include when scanning for
            // class names.
            extensions: ["html", "js", "php", "vue"]
          }
        ]
      })
    ]
  });
}
