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
    // Compile CSS
    mix.sass('error.scss');

    // Copy required plugin files
    mix.copy('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.min.css', 'public/css/waves.min.css')
        .copy('node_modules/adminbsb-materialdesign/plugins/node-waves/waves.min.js', 'public/js/waves.min.js')
});