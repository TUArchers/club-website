/**
 * First we will load all of this project's JavaScript dependencies
 */
require('./bootstrap');

// Get data from forms using jQuery
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// Handle element animations
$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});

// Set template delimiters for LoDash
_.templateSettings.interpolate = /{{([\s\S]+?)}}/g;

// Show notifications on-screen
window.showNotification = function(title, message, colour, placementFrom, placementAlign, animateEnter, animateExit){

    // Apply defaults
    title          = title || '';
    message        = message || '';
    colour         = 'bg-' + colour || 'green';
    placementFrom  = placementFrom || 'bottom';
    placementAlign = placementAlign || 'center';
    animateEnter   = animateEnter || 'animated fadeInDown';
    animateExit    = animateExit || 'animated fadeOutUp';

    // Show notification
    $.notify({
            title: title,
            message: message
        },
        {
            type: colour,
            allow_dismiss: true,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: document.getElementById('notification').innerHTML
        });
};