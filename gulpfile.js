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
    // Copy third-party styles
    mix.copy('node_modules/adminbsb-materialdesign/plugins/animate-css/animate.css', 'public/css/animate.css');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/material-design-preloader/md-preloader.css', 'public/css/preloader.css');
    mix.copy('node_modules/adminbsb-materialdesign/css/materialize.css', 'public/css/materialize.css');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css', 'public/css/datetimepicker.css');
    mix.copy('node_modules/adminbsb-materialdesign/css/style.css', 'public/css/admin.css');
    mix.copy('node_modules/adminbsb-materialdesign/css/themes/theme-orange.css', 'public/css/admin-theme.css');

    // Compile CSS
    mix.sass('main.scss');
    mix.sass('kiosk.scss');
    mix.sass('home.scss');

    // Copy third-party JS
    mix.copy('node_modules/adminbsb-materialdesign/js/admin.js', 'public/js/admin.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-steps/jquery.steps.js', 'public/js/jquery-steps.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js', 'public/js/jquery-validate.js');
    mix.copy('node_modules/cropit/dist/jquery.cropit.js', 'public/js/jquery-cropit.js');

    // Compile JS
    mix.webpack('main.js');
});