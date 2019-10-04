(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).load(function () {
        
    });

    function successNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'success',
            styling: 'bootstrap3'
        });
    }

    function warningrNotif() {
        new PNotify({
            title: 'Something Error Occured',
            type: 'warning',
            styling: 'bootstrap3'
        });
    }

    function errorNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'error',
            styling: 'bootstrap3'
        });
    }

})(jQuery);
