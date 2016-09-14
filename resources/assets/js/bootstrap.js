/**
 * jQuery and Bootstrap JS are loaded using a CDN. If not,
 * uncomment the lines below to include them.
 */
//window.$ = window.jQuery = require('jquery');
//require('bootstrap-sass');

/**
 * Register jQuery plugins
 */
require('jquery-slimscroll');
require('jquery-countto');

/**
 * Register Bootstrap plugins
 */
require('../../../node_modules/bootstrap-select/js/bootstrap-select'); // The distribution doesn't play nice with WebPack

/**
 * Register other plugins
 */
window.Waves = require('node-waves');
require('sweetalert');
