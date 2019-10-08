(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).load(function () {
        /** Update GDPR Content Page */
        $("#btn-save-content").on("click", function (event) {
            var zn_page_content = $('#zn_page_content').val();
            $.ajax({
                url: gdprsettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_page_content',
                    'zn_page_content': zn_page_content
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The page content is successfully updated');
                    } else {
                        errorNotif('There is an Error occured while saving the data')
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        /** Restore GDPR Content Page */
        $("#btn-restore-content").on("click", function (event) {
            if (confirm('Are you sure that you want to restore the GDPR Page Content?')) {
                $.ajax({
                    url: gdprsettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'restore_page_content',
                        'zn_nonce': $(this).data('zn_nonce')
                    },
                    success: function (data) {
                         if (data == 1) {
                             successNotif('You successfully Restored the GDPR Page Content');
                         } else {
                             errorNotif('There is an Error occured while saving the data')
                         }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });

        $("#btn-gdpr-content").on("click", function (event) {
            $.ajax({
                url: gdprsettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_gdpr_content',
                    'zn_privacy_policy': $("input[name='zn_privacy_policy']").val(),
                    'zn_cookie_policy': $("input[name='zn_cookie_policy']").val(),
                    'zn_terms_conditions': $("input[name='zn_terms_conditions']").val(),
                    'zn_description': $("input[name='zn_description']").val(),
                    'zn_allow_cookies': $("input[name='zn_allow_cookies']").val(),
                    'zn_refuse_cookies': $("input[name='zn_refuse_cookies']").val(),
                    'zn_nonce': $(this).data('zn_nonce')
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The GDPR content is successfully updated');
                    } else {
                        errorNotif('There is an Error occured while saving the data');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
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
