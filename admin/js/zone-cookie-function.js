    $ = jQuery.noConflict();
    
    var p,p2;

    /** Generate Popup */
    function generatePopup(obj_Pop) {
        $('.cc-window').remove();
        // console.table(obj_Pop);
        console.log('onPopupOpen() called');
        var message = obj_Pop.zn_description;
        temp_privacy = '<a style="color:'+obj_Pop.zn_color_banner_text+'; text-decoration: underline;" href="'+obj_Pop.zn_privacy_policy+'"> Privacy Policy</a>';
        temp_cookie = '<a style="color:'+obj_Pop.zn_color_banner_text+'; text-decoration: underline;" href="'+obj_Pop.zn_cookie_policy+'"> Cookie Policy</a>';
        temp_terms = '<a style="color:'+obj_Pop.zn_color_banner_text+'; text-decoration: underline;" href="'+obj_Pop.zn_terms_conditions+'"> Terms and Condition</a>';
        message = message.replace("{privacy-policy}", temp_privacy);
        message = message.replace("{cookie-policy}", temp_cookie);
        message = message.replace("{terms}", temp_terms);
        // Position Top Staic
        var static;
        if (obj_Pop.zn_position == 'top-static') {
            obj_Pop.zn_position = 'top';
            static = true;
        } else {
            static = false;
        }
        // Layout Wire
        var border = '';
        if (obj_Pop.zn_theme == 'wire') {
            obj_Pop.zn_color_button_text = obj_Pop.zn_color_button;
            border = obj_Pop.zn_color_button;
            obj_Pop.zn_color_button = 'transparent';
        }
        if (obj_Pop.zn_position == 'default') {
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": obj_Pop.zn_color_banner,
                        "text": obj_Pop.zn_color_banner_text
                    },
                    "button": {
                        "background": obj_Pop.zn_color_button,
                        "text": obj_Pop.zn_color_button_text,
                        "border": border,
                    }
                },
                "theme": obj_Pop.zn_theme,
                "type": obj_Pop.zn_compliance,
                "showLink": false,
                "content": {
                    "message": message,
                    "allow": obj_Pop.zn_allow_cookies,
                    "dismiss": obj_Pop.zn_allow_cookies,
                    "deny": obj_Pop.zn_refuse_cookies
                }
            }, function (popup) {
                p2 = popup;
            }, function (err) {
                console.error(err);
            })
        } else {
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": obj_Pop.zn_color_banner,
                        "text": obj_Pop.zn_color_banner_text
                    },
                    "button": {
                        "background": obj_Pop.zn_color_button,
                        "text": obj_Pop.zn_color_button_text,
                        "border": border,
                    }
                },
                "position": obj_Pop.zn_position,
                "static": static,
                "theme": obj_Pop.zn_theme,
                "type": obj_Pop.zn_compliance,
                "showLink": false,
                "content": {
                    "message": message,
                    "allow": obj_Pop.zn_allow_cookies,
                    "dismiss": obj_Pop.zn_allow_cookies,
                    "deny": obj_Pop.zn_refuse_cookies
                }
            }, function (popup) {
                p = popup;
            }, function (err) {
                console.error(err);
            })
        }
    }

    function defaultPopup() {
        zn_position = 'default';
        zn_theme = 'default';
        zn_color_banner = '#0D9D96';
        zn_color_banner_text = '#ffffff';
        zn_color_button = '#ffffff';
        zn_color_button_text = '#0D9D96';
        zn_compliance = 'default';
        zn_description = 'This website uses cookies to ensure you get the best experience on our website. {cookie-policy}';
        zn_allow_cookies = 'Allow cookies';
        zn_refuse_cookies = 'Decline';
        var obj_Pop = {
            'zn_position' : zn_position,
            'zn_theme' : zn_theme,
            'zn_color_banner' : zn_color_banner,
            'zn_color_banner_text' : zn_color_banner_text,
            'zn_color_button' : zn_color_button,
            'zn_color_button_text' : zn_color_button_text,
            'zn_compliance' : zn_compliance,
            'zn_description' : zn_description,
            'zn_allow_cookies' : zn_allow_cookies,
            'zn_refuse_cookies' : zn_refuse_cookies
        };
        return obj_Pop;
    }

    function processData() {
        zn_position = $("input[name='zn_position']:checked").val();
        zn_theme = $("input[name='zn_layout']:checked").val();
        zn_color_banner = $("input[name='zn_color_banner']").val();
        zn_color_banner_text = $("input[name='zn_color_banner_text']").val();
        zn_color_button = $("input[name='zn_color_button']").val();
        zn_color_button_text = $("input[name='zn_color_button_text']").val();
        zn_compliance = $("input[name='zn_compliance']:checked").val();
        zn_privacy_policy = $("input[name='zn_privacy_policy']").val();
        zn_cookie_policy = $("input[name='zn_cookie_policy']").val();
        zn_terms_conditions = $("input[name='zn_terms_conditions']").val();
        zn_description = $("textarea[name='zn_description']").val();
        zn_allow_cookies = $("input[name='zn_allow_cookies']").val();
        zn_refuse_cookies = $("input[name='zn_refuse_cookies']").val();
        var obj_Pop = {
            'zn_position' : zn_position,
            'zn_theme' : zn_theme,
            'zn_color_banner' : zn_color_banner,
            'zn_color_banner_text' : zn_color_banner_text,
            'zn_color_button' : zn_color_button,
            'zn_color_button_text' : zn_color_button_text,
            'zn_compliance' : zn_compliance,
            'zn_privacy_policy' : zn_privacy_policy,
            'zn_cookie_policy' : zn_cookie_policy,
            'zn_terms_conditions' : zn_terms_conditions,
            'zn_description' : zn_description,
            'zn_allow_cookies' : zn_allow_cookies,
            'zn_refuse_cookies' : zn_refuse_cookies
        };
        //console.table(obj_Pop);
        generatePopup(obj_Pop);
    }
    
    function openPopup() {
        if(p.isClose()) {
            p.open();
        } else if (p2.isClose()) {
            p2.open();
        }
    }

    function closePopup() {
        if(p.isOpen()) {
            p.close();
        } else if (p2.isOpen()) {
            p2.close();	
        }
    }

    /** Trigger Popup by Radio */
    $( "input[type='radio']").click(function() {
        processData();
    });

    /** Trigger Popup by color */
    $( "input[type='color']").change(function() {
        processData();
    });

    $('#reset_palette').click(function(){
        processData();
    });

    /* Used Default Palette */
    $('#default_palette').click(function(){
        console.log('defaultPopup() called');
        var var_Pop = defaultPopup();
        generatePopup(var_Pop);
    });

    /* Open Popup */
    $('#openpopup').click(function(){
        console.log('onPopupOpen() called');
        openPopup();
    });

    /* Close Popup */
    $('#closepopup').click(function(){
        console.log('onPopupClose() called');
        closePopup();
    });