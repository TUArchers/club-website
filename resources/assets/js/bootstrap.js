/**
 * jQuery and Bootstrap JS are loaded using a CDN. If not,
 * uncomment the lines below to include them.
 */
//window.$ = window.jQuery = require('jquery');
//require('bootstrap-sass');

/**
 * Register plugins
 */
window.Waves  = require('node-waves');
window.moment = require('moment');
window.Chart  = require('chart.js');
require('sweetalert');

/**
 * Register jQuery plugins
 */
require('jquery-slimscroll');
require('jquery-countto');
//require('cropit');
//require('jquery-validation');

/**
 * Register Bootstrap plugins
 */
require('../../../node_modules/bootstrap-select/js/bootstrap-select'); // The distribution doesn't play nice with WebPack
require('../../../node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker');
