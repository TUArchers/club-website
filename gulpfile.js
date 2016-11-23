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
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css', 'public/css/data-tables.css');
    mix.copy('node_modules/adminbsb-materialdesign/css/style.css', 'public/css/admin.css');
    mix.copy('node_modules/adminbsb-materialdesign/css/themes/theme-orange.css', 'public/css/admin-theme.css');

    // Compile CSS
    mix.sass('main.scss');
    mix.sass('kiosk.scss');
    mix.sass('home.scss');

    // Copy third-party JS
    mix.copy('node_modules/adminbsb-materialdesign/js/admin.js', 'resources/assets/js/vendor/admin.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-steps/jquery.steps.js', 'resources/assets/js/vendor/jquery-steps.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js', 'resources/assets/js/vendor/jquery-validate.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/jquery.dataTables.js', 'resources/assets/js/vendor/jquery-datatables.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js', 'resources/assets/js/vendor/bootstrap-datatables.js');
    mix.copy('node_modules/adminbsb-materialdesign/plugins/bootstrap-notify/bootstrap-notify.js', 'resources/assets/js/vendor/bootstrap-notify.js');
    mix.copy('node_modules/cropit/dist/jquery.cropit.js', 'resources/assets/js/vendor/jquery-cropit.js');

    // Compile JS
    mix.scripts([
        'lodash.min.js',
        'jquery.min.js',
        'bootstrap.min.js',
        //'jquery-steps.js',
        'jquery-validate.js',
        'jquery-datatables.js',
        'bootstrap-datatables.js',
        'bootstrap-notify.js',
        'jquery-cropit.js',
        'admin.js'
    ], 'public/js/vendor.js', 'resources/assets/js/vendor').webpack('main.js');
});