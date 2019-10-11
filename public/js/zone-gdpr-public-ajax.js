(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $( window ).load(function() {
        $("#btn-submit-request").on("click", function (event) {
            $.ajax({
                url: gdprsettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'zoneGdprRequest',
                    'req_fname': $('input[name=req_fname]').val(),
                    'req_lname': $('input[name=req_lname]').val(),
                    'req_phone': $('input[name=req_phone]').val(),
                    'req_email': $('input[name=req_email]').val(),
                    'req_type': $('#gdpr-request').val(),
                    'req_message': $('#req_message').val(),
                    'req_nonce': $(this).data('zn_nonce'),
                },
                success: function (data) {
                    // console.log(data);
                    $('#zn-request-form').fadeOut('slow',function () {
                        $(this).empty();
                    });
                    setTimeout(function () {
                        $('#zn-request-form').fadeIn().append('<strong><p>Your Request is successfully submmited. We will respond a message to you soon.</p><p>Thank you!</p></strong>');
                    }, 1000);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });

})(jQuery);
