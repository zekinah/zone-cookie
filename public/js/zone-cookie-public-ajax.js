(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).on('load', function () {
        $('#zn-request-form input[type="text"]').blur(function () {
            if (!$(this).val()) {
                $(this).addClass("form-required");
            } else {
                $(this).removeClass("form-required");
            }
        });

        $('#zn-request-form input[type="email"]').blur(function () {
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

        $('#btn-submit-request').on('click', function (event) {
            if (checkForms() == 4) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'zoneGdprRequest',
                        'req_fname': $('input[name=req_fname]').val(),
                        'req_lname': $('input[name=req_lname]').val(),
                        'req_phone': $('input[name=req_phone]').val(),
                        'req_email': $('input[name=req_email]').val(),
                        'req_type': $('#gdpr-request').val(),
                        'req_message': $('#req_message').val(),
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        emptyFields();
                        setTimeout(function () {
                            $('#zn-request-form').fadeIn().append('<div class="message-success"><strong><p>Your Request is successfully submmited. We will respond a message to you soon.</p><p>Thank you!</p></strong></div>');
                        }, 1000);
                        setTimeout(function () {
                            $('.message-success').fadeOut();
                        }, 10000);
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                        setTimeout(function () {
                            $('#zn-request-form').fadeIn().append('<div class="message-error"><strong><p>Oh no!, Something went wrong.</p><p>Please contact the administrator. Thank you!</p></strong></div>');
                        }, 1000);
                        setTimeout(function () {
                            $('.message-success').fadeOut();
                        }, 10000);
                    }
                });
            }
        });
    });

    function checkForms() {
        var stat = 0;
        var input_text = $('#zn-request-form input[type=text]').val();
        var input_email = $('#zn-request-form input[type=email]').val();
        var select = $('#zn-request-form #gdpr-request').val();
        var textarea = $("#zn-request-form textarea").val();

        if (input_text.length == 0) {
            $('#zn-request-form input[type=text]').addClass("form-required");
            stat = 0;
        } else {
            $('#zn-request-form input[type=text]').removeClass("form-required");
            stat = stat + 1;
        }

        if (input_email.length < 1) {
            $('#zn-request-form input[type=email]').addClass("form-required");
            stat = 0;
        } else {
            var regEx = /^([^\000]{1,63})(@)([^\000]*?)\.([^\000]{1,63}$)/;
            var validEmail = regEx.test(input_email);
            if (!validEmail) {
                $('#zn-request-form input[type=email]').addClass("form-required");
                stat = 0;
            } else {
                $('#zn-request-form input[type=email]').removeClass("form-required");
                stat = stat + 1;
            }
        }

        if (!select) {
            $('#zn-request-form #gdpr-request').addClass("form-required");
            stat = 0;
        } else {
            $('#zn-request-form #gdpr-request').removeClass("form-required");
            stat = stat + 1;
        }

        if (!$.trim(textarea)) {
            $("#zn-request-form textarea").addClass("form-required");
            stat = 0;
        } else {
            $("#zn-request-form textarea").removeClass("form-required");
            stat = stat + 1;
        }
        
        return stat;
    }

    function emptyFields() {
        $('input[name=req_fname]').val('');
        $('input[name=req_lname]').val('');
        $('input[name=req_phone]').val('');
        $('input[name=req_email]').val('');
        $("#zn-request-form textarea").val('');
    }

})(jQuery);