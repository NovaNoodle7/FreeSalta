jQuery("body.mega-menu-top #mega-menu-top").on("after_mega_menu_init", function() {
    jQuery(this).parent().parent().removeClass("main-navigation");
});