const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix){
    /**
     * Copy Waves plugin for import
     *
     * This is due to the fact that Sass won't currently import the contents of CSS files
     */
    mix.copy('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.css', 'resources/assets/sass/vendor/waves.scss')
        .copy('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.js', 'resources/assets/js/vendor/waves.js');

    // Compile CSS
    mix.sass('error.scss')
        .sass('public.scss')
        .sass('admin.scss');

    // Compile JS
    mix.webpack('error.js')
        .webpack('public.js')
        .webpack('admin.js');
});