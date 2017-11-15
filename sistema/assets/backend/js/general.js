/*
 * 	Additional function for this template
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Amanda Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */

jQuery.noConflict();

jQuery(document).ready(function () {
	
	/*
	* Mascaras gerais
	*/
	jQuery("input[name^='valor']").setMask("decimal","reverse");
        jQuery("input[id='valor']").setMask("decimal","reverse");
        jQuery("input[name^='fone']").setMask("phone-br");
        jQuery("input[name^='cep']").setMask("cep");
        jQuery("input[id*='data_']").setMask("99/99/9999");
        jQuery("input[id*='cpfcnpj']").setMask("99999999999999");
    /*
     * Transform inputs
     */
    jQuery('input:checkbox, input:radio, select, input:file').not('.clean').uniform();

    /*
     * show/hide userdata when userinfo is clicked
     */
    jQuery('.userinfo').click(function () {
        if (!jQuery(this).hasClass('active')) {
            jQuery('.userinfodrop').show();
            jQuery(this).addClass('active');
        } else {
            jQuery('.userinfodrop').hide();
            jQuery(this).removeClass('active');
        }
        //remove notification box if visible
        jQuery('.notification').removeClass('active');
        jQuery('.noticontent').remove();

        return false;
    });

    /*
     * show/hide notification (not used now)
     */
    jQuery('.notification a').click(function () {
        var t = jQuery(this);
        var url = t.attr('href');
        if (!jQuery('.noticontent').is(':visible')) {
            jQuery.post(url, function (data) {
                t.parent().append('<div class="noticontent">' + data + '</div>');
            });
            //this will hide user info drop down when visible
            jQuery('.userinfo').removeClass('active');
            jQuery('.userinfodrop').hide();
        } else {
            t.parent().removeClass('active');
            jQuery('.noticontent').hide();
        }
        return false;
    });

    /*
     * show/hide notification and userinfo when clicked outside of this elemet
     */
    jQuery(document).click(function (event) {
        var ud = jQuery('.userinfodrop');
        var nb = jQuery('.noticontent');

        //hide user drop menu when clicked outside of this element
        if (!jQuery(event.target).is('.userinfodrop')
                && !jQuery(event.target).is('.userdata')
                && ud.is(':visible')) {
            ud.hide();
            jQuery('.userinfo').removeClass('active');
        }

        //hide notification box when clicked outside of this element
        if (!jQuery(event.target).is('.noticontent') && nb.is(':visible')) {
            nb.remove();
            jQuery('.notification').removeClass('active');
        }
    });

    /*
     * notification content (not used now)
     */
    jQuery('.notitab a').live('click', function () {
        var id = jQuery(this).attr('href');
        jQuery('.notitab li').removeClass('current'); //reset current 
        jQuery(this).parent().addClass('current');
        if (id == '#messages')
            jQuery('#activities').hide();
        else
            jQuery('#messages').hide();

        jQuery(id).show();
        return false;
    });

    /*
     * show/hide vertifcal submenu
     */
    jQuery('.vernav > ul li a, .vernav2 > ul li a').each(function () {
        var url = jQuery(this).attr('href');
        jQuery(this).click(function () {
            if (jQuery(url).length > 0) {
                if (jQuery(url).is(':visible')) {
                    if (!jQuery(this).parents('div').hasClass('menucoll') &&
                            !jQuery(this).parents('div').hasClass('menucoll2'))
                        jQuery(url).slideUp();
                } else {
                    jQuery('.vernav ul ul, .vernav2 ul ul').each(function () {
                        jQuery(this).slideUp();
                    });
                    if (!jQuery(this).parents('div').hasClass('menucoll') &&
                            !jQuery(this).parents('div').hasClass('menucoll2'))
                        jQuery(url).slideDown();
                }
                return false;
            }
        });
    });

    /* 
     * show/hide submenu when menu collapsed
     */
    jQuery('.menucoll > ul > li, .menucoll2 > ul > li').live('mouseenter mouseleave', function (e) {
        if (e.type == 'mouseenter') {
            jQuery(this).addClass('hover');
            jQuery(this).find('ul').show();
        } else {
            jQuery(this).removeClass('hover').find('ul').hide();
        }
    });


    /*
     * Navigation on tab bar
     */
    jQuery('.hornav a').click(function () {
        if (jQuery(this).attr('href').indexOf('#') >= 0) {
            //this is only applicable when window size below 450px
            if (jQuery(this).parents('.more').length == 0)
                jQuery('.hornav li.more ul').hide();

            //remove current menu
            jQuery('.hornav li').each(function () {
                jQuery(this).removeClass('current');
            });

            jQuery(this).parent().addClass('current');	// set as current menu

            var url = jQuery(this).attr('href');
            if (jQuery(url).length > 0) {
                jQuery('.contentwrapper .subcontent').hide();
                jQuery(url).show();
            } else {
                jQuery.post(url, function (data) {
                    jQuery('#contentwrapper').html(data);
                    jQuery('.stdtable input:checkbox').uniform();	//restyling checkbox
                });
            }
            return false;
        }
    });

    /*
     * search box with autocomplete (not used now)
     */
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    jQuery('#keyword').autocomplete({
        source: availableTags
    });

    /*
     * search box on focus (not used now)
     */
    jQuery('#keyword').bind('focusin focusout', function (e) {
        var t = jQuery(this);
        if (e.type == 'focusin' && t.val() == 'Enter keyword(s)') {
            t.val('');
        } else if (e.type == 'focusout' && t.val() == '') {
            t.val('Enter keyword(s)');
        }
    });


    /*
     * notification close button
     */
    jQuery('.notibar .close').click(function () {
        jQuery(this).parent().fadeOut(function () {
            jQuery(this).remove();
        });
    });

    /*
     * collapsed/expand left menu
     */
    jQuery('.togglemenu').click(function () {
        if (!jQuery(this).hasClass('togglemenu_collapsed')) {

            //if(jQuery('.iconmenu').hasClass('vernav')) {
            if (jQuery('.vernav').length > 0) {
                if (jQuery('.vernav').hasClass('iconmenu')) {
                    jQuery('body').addClass('withmenucoll');
                    jQuery('.iconmenu').addClass('menucoll');
                } else {
                    jQuery('body').addClass('withmenucoll');
                    jQuery('.vernav').addClass('menucoll').find('ul').hide();
                }
            } else if (jQuery('.vernav2').length > 0) {
                //} else {
                jQuery('body').addClass('withmenucoll2');
                jQuery('.iconmenu').addClass('menucoll2');
            }

            jQuery(this).addClass('togglemenu_collapsed');

            jQuery('.iconmenu > ul > li > a').each(function () {
                var label = jQuery(this).text();
                jQuery('<li><span>' + label + '</span></li>')
                        .insertBefore(jQuery(this).parent().find('ul li:first-child'));
            });
        } else {

            //if(jQuery('.iconmenu').hasClass('vernav')) {
            if (jQuery('.vernav').length > 0) {
                if (jQuery('.vernav').hasClass('iconmenu')) {
                    jQuery('body').removeClass('withmenucoll');
                    jQuery('.iconmenu').removeClass('menucoll');
                } else {
                    jQuery('body').removeClass('withmenucoll');
                    jQuery('.vernav').removeClass('menucoll').find('ul').show();
                }
            } else if (jQuery('.vernav2').length > 0) {
                //} else {
                jQuery('body').removeClass('withmenucoll2');
                jQuery('.iconmenu').removeClass('menucoll2');
            }
            jQuery(this).removeClass('togglemenu_collapsed');

            jQuery('.iconmenu ul ul li:first-child').remove();
        }
    });

    /*
     * responsive elements
     */
    if (jQuery(document).width() < 640) {
        jQuery('.togglemenu').addClass('togglemenu_collapsed');
        if (jQuery('.vernav').length > 0) {

            jQuery('.iconmenu').addClass('menucoll');
            jQuery('body').addClass('withmenucoll');
            jQuery('.centercontent').css({marginLeft: '56px'});
            if (jQuery('.iconmenu').length == 0) {
                jQuery('.togglemenu').removeClass('togglemenu_collapsed');
            } else {
                jQuery('.iconmenu > ul > li > a').each(function () {
                    var label = jQuery(this).text();
                    jQuery('<li><span>' + label + '</span></li>')
                            .insertBefore(jQuery(this).parent().find('ul li:first-child'));
                });
            }

        } else {

            jQuery('.iconmenu').addClass('menucoll2');
            jQuery('body').addClass('withmenucoll2');
            jQuery('.centercontent').css({marginLeft: '36px'});

            jQuery('.iconmenu > ul > li > a').each(function () {
                var label = jQuery(this).text();
                jQuery('<li><span>' + label + '</span></li>')
                        .insertBefore(jQuery(this).parent().find('ul li:first-child'));
            });
        }
    }

    jQuery('.searchicon').live('click', function () {
        jQuery('.searchinner').show();
    });

    jQuery('.searchcancel').live('click', function () {
        jQuery('.searchinner').hide();
    });



    /*
     * on load window
     */
    function reposSearch() {
        if (jQuery(window).width() < 520) {
            if (jQuery('.searchinner').length == 0) {
                jQuery('.search').wrapInner('<div class="searchinner"></div>');
                jQuery('<a class="searchicon"></a>').insertBefore(jQuery('.searchinner'));
                jQuery('<a class="searchcancel"></a>').insertAfter(jQuery('.searchinner button'));
            }
        } else {
            if (jQuery('.searchinner').length > 0) {
                jQuery('.search form').unwrap();
                jQuery('.searchicon, .searchcancel').remove();
            }
        }
    }
    reposSearch();

    /*
     * on rezise window
     */
    jQuery(window).resize(function () {
        if (jQuery(window).width() > 640)
            jQuery('.centercontent').removeAttr('style');
        reposSearch();
    });

    /*
     * change theme
     */
    jQuery('.changetheme a').click(function () {
        var c = jQuery(this).attr('class');
        if (jQuery('#addonstyle').length == 0) {
            if (c != 'default') {
                jQuery('head').append('<link id="addonstyle" rel="stylesheet" href="assets/backend/css/style.' + c + '.css" type="text/css" />');
                jQuery.cookie("addonstyle", c, {path: '/'});
            }
        } else {
            if (c != 'default') {
                jQuery('#addonstyle').attr('href', 'assets/backend/css/style.' + c + '.css');
                jQuery.cookie("addonstyle", c, {path: '/'});
            } else {
                jQuery('#addonstyle').remove();
                jQuery.cookie("addonstyle", "", {path: '/'});
            }
        }
    });

    /*
     * load addon style when it's already set
     */
    if (jQuery.cookie('addonstyle') != '') {
        var c = jQuery.cookie('addonstyle');
        if (c != '') {
            jQuery('head').append('<link id="addonstyle" rel="stylesheet" href="assets/backend/css/style.' + c + '.css" type="text/css" />');
            jQuery.cookie("addonstyle", c, {path: '/'});
        }
    }

    function loader(t) {
        if (t == 'ON') {
            jQuery("#loader").show();
        } else {
            jQuery("#loader").hide();
        }
    }

    /*
     * button to submit
     */
    jQuery('form button').click(function () {
        var form = jQuery(this).closest('form');
        var form_name = jQuery(form).attr('name');
        if(form_name === 'loaderpgcc'){
            loader('ON');
        }else{
            loader('OFF');
        }
        jQuery(this).parent('form').submit();
    });
});