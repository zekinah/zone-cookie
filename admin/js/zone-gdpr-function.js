    $ = jQuery.noConflict();
    
    var p,p2;

    /** Generate Popup */
    function generatePopup(obj_Pop) {
        $('.cc-window').remove();
        console.table(obj_Pop);
        console.log('onPopupOpen() called');
        if (obj_Pop.zn_position == 'default' || obj_Pop.zn_theme == 'default') {
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": obj_Pop.zn_color_banner,
                        "text": obj_Pop.zn_color_banner_text
                    },
                    "button": {
                        "background": zn_color_button,
                        "text": obj_Pop.zn_color_button_text
                    }
                },
                "type": obj_Pop.zn_compliance,
                "content": {
                    "message": obj_Pop.zn_description,
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
                        "text": obj_Pop.zn_color_button_text
                    }
                },
                "position": obj_Pop.zn_position,
                "theme": obj_Pop.zn_theme,
                "type": obj_Pop.zn_compliance,
                "content": {
                    "message": obj_Pop.zn_description,
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
        zn_description = 'This website uses cookies to ensure you get the best experience on our website.';
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
        zn_position = $("input[name='zn_position']:checked").val();
        zn_theme = $("input[name='zn_layout']:checked").val();
        zn_color_banner = $("input[name='zn_color_banner']").val();
        zn_color_banner_text = $("input[name='zn_color_banner_text']").val();
        zn_color_button = $("input[name='zn_color_button']").val();
        zn_color_button_text = $("input[name='zn_color_button_text']").val();
        zn_compliance = $("input[name='zn_compliance']:checked").val();
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
            'zn_description' : zn_description,
            'zn_allow_cookies' : zn_allow_cookies,
            'zn_refuse_cookies' : zn_refuse_cookies
        };
        generatePopup(obj_Pop);
    });

    /** Trigger Popup by color */
    $( "input[type='color']").change(function() {
        zn_position = $("input[name='zn_position']:checked").val();
        zn_theme = $("input[name='zn_layout']:checked").val();
        zn_color_banner = $("input[name='zn_color_banner']").val();
        zn_color_banner_text = $("input[name='zn_color_banner_text']").val();
        zn_color_button = $("input[name='zn_color_button']").val();
        zn_color_button_text = $("input[name='zn_color_button_text']").val();
        zn_compliance = $("input[name='zn_compliance']").val();
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
            'zn_description' : zn_description,
            'zn_allow_cookies' : zn_allow_cookies,
            'zn_refuse_cookies' : zn_refuse_cookies
        };
        generatePopup(obj_Pop);
    });

    $('#reset_palette').click(function(){
        zn_position = $("input[name='zn_position']:checked").val();
        zn_theme = $("input[name='zn_layout']:checked").val();
        zn_color_banner = $("input[name='zn_color_banner']").val();
        zn_color_banner_text = $("input[name='zn_color_banner_text']").val();
        zn_color_button = $("input[name='zn_color_button']").val();
        zn_color_button_text = $("input[name='zn_color_button_text']").val();
        zn_compliance = $("input[name='zn_compliance']").val();
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
            'zn_description' : zn_description,
            'zn_allow_cookies' : zn_allow_cookies,
            'zn_refuse_cookies' : zn_refuse_cookies
        };
        //console.table(obj_Pop);
        generatePopup(obj_Pop);
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