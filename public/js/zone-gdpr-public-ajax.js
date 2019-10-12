(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $( window ).load(function() {
        $('#zn-request-form input[type="text"]').blur(function () {
            if (!$(this).val()) {
                $(this).addClass("form-required");
            } else {
                $(this).removeClass("form-required");
            }
        });

        $('#zn-request-form #gdpr-request').change(function () {
            if ($(this).val() === "") {
                $(this).addClass("form-required");
            } else {
                $(this).removeClass("form-required");
            }
        });

        $('#zn-request-form textarea').blur(function () {
            if (!$(this).val()) {
                $(this).addClass("form-required");
            } else {
                $(this).removeClass("form-required");
            }
        });

        $("#btn-submit-request").on("click", function (event) {
            if (checkForms()) {
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
                        $('#zn-request-form').fadeOut('slow', function () {
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
            }
        });
    });

    function checkForms() {
        var stat = 0;
        if ($('#zn-request-form input').val().length == 0) {
            $('#zn-request-form input').addClass("form-required");
            stat = 0;
        } else {
            $('#zn-request-form input').removeClass("form-required");
            stat = 1;
        }
        if (!$('#zn-request-form #gdpr-request').val()) {
            $('#zn-request-form #gdpr-request').addClass("form-required");
            stat = 0;
        } else {
            $('#zn-request-form #gdpr-request').removeClass("form-required");
            stat = 1;
        }
        if (!$.trim($("#zn-request-form textarea").val())) {
            $('#zn-request-form textarea').addClass("form-required");
            stat = 0;
        } else {
            $('#zn-request-form textarea').removeClass("form-required");
            stat = 1;
        }
        return stat;
    }

})(jQuery);
