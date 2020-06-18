(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).on('load', function () {
        $(".btn-accept-request").on('click', function (event) {
            var $button = $(this);
            if (confirm('Are you sure to accept this request and send notification to the requester?')) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'accept_request',
                        'zn_requester_id': $(this).data('zn_requester_id'),
                        'zn_fname_request': $(this).data('zn_fname_request'),
                        'zn_email_request': $(this).data('zn_email_request'),
                        'zn_request_type': $(this).data('zn_request_type'),
                        'zn_status': 'accept',
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        if (data != 0) {
                            successNotif('You successfully Accepted the Request and Sent notification to the Requester');
                             $button.closest('tr').css('background', 'tomato');
                             $button.closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                            $('#tbl-request tbody').prepend(data);
                        } else {
                            errorNotif('There is an Error occured while accepting the request')
                        }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                warningrNotif('You missed to accept the request.');
            }
        });

        $(".btn-decline-request").on('click', function (event) {
            var $button = $(this);
            if (confirm('Are you sure to decline this request and send notification to the requester?')) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'decline_request',
                        'zn_requester_id': $(this).data('zn_requester_id'),
                        'zn_fname_request': $(this).data('zn_fname_request'),
                        'zn_email_request': $(this).data('zn_email_request'),
                        'zn_request_type': $(this).data('zn_request_type'),
                        'zn_status': 'decline',
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        if (data != 0) {
                            successNotif('You successfully Declined the Request and Sent notification to the Requester');
                            $button.closest('tr').css('background', 'tomato');
                            $button.closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                            $('#tbl-request tbody').prepend(data);
                        } else {
                            errorNotif('There is an Error occured while accepting the request')
                        }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                warningrNotif('You missed to accept the request.');
            }
        });

        /** Update GDPR Content Page */
        $("#btn-save-gdpr-content").on('click', function (event) {
            var zn_gdpr_content = $('#zn_gdpr_content').val();
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_page_gdpr_content',
                    'zn_gdpr_content': zn_gdpr_content,
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The GDPR page content is successfully updated');
                    } else {
                        errorNotif('There is an Error occured while saving the data');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        /** Restore GDPR Content Page */
        $("#btn-restore-gdpr-content").on('click', function (event) {
            if (confirm('Are you sure that you want to restore the GDPR Page Content?')) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'restore_gdpr_page_content',
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                         if (data == 1) {
                             successNotif('You successfully Restored the GDPR Page Content');
                         } else {
                             errorNotif('There is an Error occured while saving the data');
                         }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });

        /** Update CCPA Content Page */
        $("#btn-save-ccpa-content").on('click', function (event) {
            var zn_ccpa_content = $('#zn_ccpa_content').val();
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_page_ccpa_content',
                    'zn_ccpa_content': zn_ccpa_content,
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The CCPA page content is successfully updated');
                    } else {
                        errorNotif('There is an Error occured while saving the data')
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        /** Restore CCPA Content Page */
        $("#btn-restore-ccpa-content").on('click', function (event) {
            if (confirm('Are you sure that you want to restore the CCPA Page Content?')) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'restore_ccpa_page_content',
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                         if (data == 1) {
                             successNotif('You successfully Restored the CCPA Page Content');
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

        /**Save Cookie Content */
        $("#btn-gdpr-content").on('click', function (event) {
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_gdpr_content',
                    'zn_privacy_policy': $("input[name='zn_privacy_policy']").val(),
                    'zn_cookie_policy': $("input[name='zn_cookie_policy']").val(),
                    'zn_terms_conditions': $("input[name='zn_terms_conditions']").val(),
                    'zn_description': $("#zn_description").val(),
                    'zn_allow_cookies': $("input[name='zn_allow_cookies']").val(),
                    'zn_refuse_cookies': $("input[name='zn_refuse_cookies']").val(),
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
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

        /** Save Cookie Layout */
        $("#btn-gdpr-layout").on('click', function (event) {
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'save_gdpr_layout',
                    'zn_position': $("input[name='zn_position']:checked").val(),
                    'zn_layout': $("input[name='zn_layout']:checked").val(),
                    'zn_color_banner': $("input[name='zn_color_banner']").val(),
                    'zn_color_banner_text': $("input[name='zn_color_banner_text']").val(),
                    'zn_color_button': $("input[name='zn_color_button']").val(),
                    'zn_color_button_text': $("input[name='zn_color_button_text']").val(),
                    'zn_compliance': $("input[name='zn_compliance']:checked").val(),
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
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

        /** Request Type VISIBILITY */
        $("#tbl-type-request").on("change", ".zn_on_request" ,function (event) {
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'change_type_request',
                    'zn_reqid_stat': $(this).data('zn_reqid_stat'),
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The Request type is now visible on the site.');
                    } else {
                        successNotif('The Request type is not visible on the site.');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

        /** Email Notication Status */
        $('#zn_gdpr_on_email').on("change", function (event) {
             $.ajax({
                 url: cookiesettingsAjax.ajax_url,
                 type: 'POST',
                 data: {
                     'action': 'email_notification',
                     '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                 },
                 success: function (data) {
                     if (data == 1) {
                         successNotif('The Email Notification is On.');
                     } else {
                         successNotif('The Email Notification is Off.');
                     }
                 },
                 error: function (errorThrown) {
                     console.log(errorThrown);
                 }
             });
        });

        /** Save Email Settings */
        $('#btn-save-email-settings').on('click', function (event) {
            $.ajax({
                url: cookiesettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'update_email_settings',
                    'zn_email_receiver': $("input[name=zn_email_receiver]").val(),
                    'zn_email_approved_template': $("#email_approved_template").val(),
                    'zn_email_disapproved_template': $("#email_disapproved_template").val(),
                    '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The Email settings is Updated');
                    } else {
                        errorNotif('There is an Error occured while saving the data');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });


        /** Restore Email Settings */
        $("#btn-restore-email-settings").on('click', function (event) {
            if (confirm('Are you sure that you want to restore the Email Settings?')) {
                $.ajax({
                    url: cookiesettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'restore_email_settings',
                        '_ajax_nonce': cookiesettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        if (data == 1) {
                            successNotif('You successfully Restored the Email Settings');
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

        // Live Notification in Bubble Popup Sidebar
        setInterval(liveNotificationGDPR, 5000);
   });

   function liveNotificationGDPR() {
       $.ajax({
           url: cookiesettingsAjax.ajax_url,
           type: 'POST',
           data: {
               'action': 'zoneLiveNotifGDPR',
           },
           success: function (data) {
               $('#toplevel_page_zone-cookie span.awaiting-mod').empty();
               $('#toplevel_page_zone-cookie span.awaiting-mod').append(data);
           }
       });
   }

    function successNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'success',
            styling: 'bootstrap3'
        });
    }

    function warningrNotif(label) {
        new PNotify({
            title: '' + label + '',
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
