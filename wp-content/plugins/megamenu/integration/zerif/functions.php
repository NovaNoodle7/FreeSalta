<?php

/**
 * Zerif binds smoothscroll events to the top level menu items. Stop MMM from unbinding these events.
 */
if ( ! function_exists('megamenu_dont_unbind_menu_events') ) {
    function megamenu_dont_unbind_menu_events($attributes, $menu_id, $menu_settings, $settings, $current_theme_location) {

        $attributes['data-unbind'] = "false";

        return $attributes;
    }
}
add_filter("megamenu_wrap_attributes", "megamenu_dont_unbind_menu_events", 11, 5);