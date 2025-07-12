=== MapPress Easy Google Maps ===
Contributors: chrisvrichardson
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4339298
Tags: google maps,google,map,maps,easy,poi,mapping,mapper,gps,lat,lon,latitude,longitude,geocoder,geocoding,georss,geo rss,geo,v3,marker,mashup,mash,api,v3,buddypress,mashup,geo,wp-geo,geo mashup,simplemap,simple,wpml
Requires at least: 3.5
Tested up to: 4.9
Stable tag: 2.47

MapPress is the most popular and easiest way to create great-looking Google Maps and driving directions in your blog.

== Description ==
MapPress adds an interactive map to the wordpress editing screens.  When editing a post or page just enter any addresses you'd like to map.

The plugin will automatically insert a great-looking interactive map into your blog, with directions and custom map markers.

For even more features, try [MapPress Pro](http://wphostreviews.com/mappress)

[Home Page](http://www.wphostreviews.com/mappress)
[Documentation](http://www.wphostreviews.com/mappress-documentation)
[FAQ](http://www.wphostreviews.com/mappress-faq)
[Support](http://www.wphostreviews.com/mappress-faq)


= Key Features =
* MapPress is based on the latest Google maps API v3
* WordPress MultiSite compatible
* Custom post types are supported
* Easily create maps right in the standard post edit and page edit screens
* Add markers for any address, place or latitude/longitude location, or drag markers where you want them
* Create custom text and HTML for the markers, including photos, links, etc.
* Street view supported
* Readers can get driving, walking and bicycling directions right in your blog.  Directions can be dragged to change waypoints or route
* Multiple maps can be created in a single post or page
* Real-time traffic
* New shortcodes with many parameters: "mapid" (to specify which map to show), "width" "height", "zoom", etc.

= Pro Version Features =
* Get the [MapPress Pro Version](http://wphostreviews.com/mappress) for additional functionality
* Use marker icons in your maps - 100 standard icons included
* Use your own custom icons or download thousands of icons from the web
* Create mashups by taxonomy, tag, category, or post to show multiple locations on a single map
* Map widget to show a map or a mashup

== Screenshots ==
1. Options screen
2. More options
3. Visual map editor in WordPress post editor
4. Mashup shortcode in a post
5. Mashup in your blog
6. Street view of mashup location

= Localization =
Please [Contact me](http://wphostreviews.com/chris-contact) if you'd like to provide a translation or an update.  Special thanks to all the folks who created and udpated translations.

== Installation ==

See full [installation intructions and Documentation](http://www.wphostreviews.com/mappress-documentation)
1. Install and activate the plugin through the 'Plugins' menu in WordPress
1. You should now see a MapPress meta box in in the 'edit posts' screen

[Home Page](http://www.wphostreviews.com/mappress)
[Documentation](http://www.wphostreviews.com/mappress-documentation)
[FAQ](http://www.wphostreviews.com/mappress-faq)
[Support](http://www.wphostreviews.com/forums)

== Frequently Asked Questions ==
Please see the plugin documentation pages:

[Home Page](http://www.wphostreviews.com/mappress)
[Documentation](http://www.wphostreviews.com/mappress-documentation)
[FAQ](http://www.wphostreviews.com/mappress-faq)
[Support](http://www.wphostreviews.com/forums)

== Upgrade ==

1. Deactivate your old MapPress version
1. Delete your old MapPress version (don't worry, the maps are saved in the database)
1. Follow the installation instructions to install the new version

== Screenshots ==

1. Options screen
2. Visual map editor in posts and pages
3. Edit map markers in the post editor
4. Get directions from any map marker

== Changelog ==

= 2.47 =
* Added: filter dropdown now includes icons from the 'automatic icons' setting (for use as a map legend)
* Fixed: editor spawner multiple icon color pickers, so popups were sometimes in the wrong position
* Changed: 'directions' and 'mashupClick' (POI click behavior for mashups) are now global, set them from the settings screen instead of the shortcode
* Changed: templates 'map.php' and 'map-list.php' were updated, please update any custom templates
* Changed: list CSS class 'mapp-pois'/'mapp-poi' were changed to 'mapp-items'/'mapp-item'

= 2.46.10 =
* Changed: pro updater cache name changed to 'mappress_updater_[action]'

= 2.46.9 =
* Fixed: POI editor error if tinyMCE is disabled in user settings

= 2.46.8 =
* Fixed: default style not being applied
* Fixed: infoWindow displaying even when type = 'none'

= 2.46.7 =
* Fixed: maps in Jquery tabs control not automatically resizing

= 2.46.6 =
* Fixed: sorting in editor not working after first re-sort

= 2.46.5 =
* Fixed: javascript error on settings screen
* Fixed: improved check for multiple API keys
* Fixed: custom template not applied for mashup POIs

= 2.46.4 =
* Fixed: mashup poilist not shown if shortcode enabled and global setting disabled
* Fixed: default map style not always applied

= 2.46.3 =
* Fixed: editor not loading properly in 2.46.2
* Fixed: minZoom not working in shortcodes

= 2.46.2 =
* Fixed: Pro version automatic updater communications errors
* Fixed: icon picker was not working on MapPress settings page

= 2.46.1 =
* Added: updated French translation, thank you to Serge
* Fixed: directions were showing 'null' if empty

= 2.46 =
* Added: NEW TEMPLATES - this release includes all new template files - please update any custom templates to match the new versions.
* Added: mashup results can now be filtered by taxonomies, see the MapPress settings screen
* Added: setting 'Automatic updates' allows automatic updates for the Pro version
* Added: new layout with POIs on the left instead of under map, enable with: [mappresss layout="left"]
* Added: check for multiple Google Maps API loads
* Changed: template names now use hyphens instead of underscores and some names have changed: map_layout.php => map.php, map_poi_list.php => map-list.php
* Changed: CSS class names, for example for the POI list class '.mapp-poi-list' is now '.mapp-list'.  Please update any custom CSS.
* Changed: use the 'hamburger' menu in the map editor to set a map's center & zoom (previously a checkbox was shown in the map editor)
* Changed: mashups now ignore any center/zoom settings and automatically center to show all POIs
* Changed: directions now have a Google Maps link.  Transportation modes have been removed
* Changed: 'my location' shown only for SSL or localhost sites (Google has forbidden geolocation on non-secure sites)
* Changed: maps automatically recenter on screen resize (previously this was the 'adaptive' setting)
* Changed: scripts are now loaded in the header if JetPack Infinite Scroll is enabled

= 2.45.4 =
* Fixed: default custom style not applied when displaying map

= 2.45.3 =
* Fixed: bug when saving quotes (such as image tags) in POI body
* Fixed: custom map styles not displayed properly

= 2.45.2 =
* Removed: directions settings 'from' and 'to'
* Removed: 'adaptive' setting

= 2.45.1 =
* Fixed: maps were not saving attributes correctly including title, size and map type
* Fixed: maps with one POI were not setting zoom correctly
* Fixed: setting for default poi zoom was not saving
* Fixed: setting for POI click ('mashupClick') was ignored if used in shortcode
* Changed: directions 'to' is added by default for all POIs
* Removed: setting for no directions (directions="none")
* Removed: POI links ('poiLinks') setting removed

= 2.45 =
* Added: a new checkbox in the map editor allows you to choose whether to save the center and zoom.  If unchecked, the map will auto-center when displayed.
* Added: POI list sorting can now be set via the settings screen, the default is no sort
* Added: POI list can now be clicked anywhere to select a POI (not just the POI title)
* Added: a new 'hamburger' menu on the map provides map functions including centering and the bicycling, traffic, and transit layers
* Added: a new 'layers' shortcode attribute enables bicycling/transit/traffic layers when map is initially displayed, for example [mappress layers="bicycling"]
* Changed: autoicons function simplified: only 1 rule type is allowed, unfortunately you must *re-enter* any existing autoicons settings.
* Changed: mashup settings are now global including infowindow type ('iwtype'), POI body ('mashupBody'), and POI title ('mashupTtitle') - use the settings screen to set them, NOT the shortcode
* Changed: obsolete map control settings have been removed, and settings have been simplified to match Google defaults
* Changed: when centering a map, if the map has a saved center/zoom the viewport will be reset to that center/zoom, otherwise it will autocenter
* Changed: the 'initialopeninfo' shortcode attribute now accepts only true or false, not a POI index
* Changed: POI 'directions' links have been removed from the POI list (but still show in the POIs).  This allows display of more POIs in the list.
* Removed: mashup link ('mashuplink') setting, POI titles now always link to underlying post in mashups
* Removed: settings 'draggable', 'keyboardshortcuts', 'maptypecontrol', 'maptypecontrolstyle', 'maptypeids', 'overviewmapcontrol', 'overviewmapcontrolopened', 'pancontrol', 'rotatecontrol', 'scalecontrol', 'scrollwheel', 'streetviewcontrol', 'tilt','tooltips','zoomcontrol', 'zoomcontrolstyle'
* Removed: settings 'template', 'templatedirections', 'templatepoi', 'templatepoilist'
* Removed: settings 'bicycling', 'traffic', 'transit', 'initialBicycling', 'initialTraffic', 'initialTransit'
* Removed: 'bigger map' and POI 'zoom' functions
* Removed: the 'mapLinks' setting is removed (these functions have been replaced by the new map menu)


= 2.44.5 =
* Changed: improved updater

= 2.44.4 =
* Changed: updates for PHP 7

= 2.44.3 =
* Changed: plugin repository URL updated

= 2.44.2 =
* Changed: geocoding module has been updated
* Changed: the Nominatim geocoder has been removed
* Changed: when geocoding an 'address' field in format 'lat,lng' the field is used verbatim rather than mapped to the nearest street address
* Changed: extract removed from helper functions

= 2.44.1 =
* Changed: added 'footer' option for loading scripts in header/footer (for use in AJAX plugins)
* Changed: added underscore library to loader
* Fixed: default sort applied to mashup with orderby
* Fixed: updated widget to use array field names (since WP 4.4)

= 2.44 =
* Changed: version updated to 2.44

= 2.43.10 =
* Changed: show blank container while loading mashups instead of default map
* Changed: no alerts for admins on missing map container
* Changed: apply wpautop to POIs when they are saved (wpautop inserts html tags to format carriage returns)
* Fixed: bug where mashups were limited to 10 POIs
* Fixed: polygons are allowed again in mashup results
* Fixed: changed Mappress_Updater constructor for PHP 7

= 2.43.9 =
* Added: support for XHTML sites (must be running WP 4.5 or higher)
* Added: server API key for geocoding
* Fixed: debugging functions
* Fixed: removed extra code for api key in geocoder
* Fixed: removed anonymous functions to support hosts still running PHP 5.2

= 2.43.8 =
* Added: API key checks updated to support Google policy change on 6/22/2016
* Added: automatic icons can now be set by post type as well as by taxonomy
* Changed: KML/KMZ overlays and polygons are no longer included in mashup results
* Changed: map can now display in AJAX calls from other plugins (infinite scrollers, etc.)
* Changed: new map loader for compatibility with plugins/themes that cause jQuery .ready errors
* Changed: text domain changed for compatibility with WordPress language packs
* Changed: support for translate.wordpress.org - language (.mo/.po) files renamed with new plugin slug for language packs
* Changed: datatables support has been removed
* Changed: widget now uses WP 4.3 constructor / anonymous function
* Fixed: a Google API change broke 'my location' in directions and map editor

= 2.43.7 =
* Fixed: mashups ignoring mashupTitle="poi" and always showing post title (since 2.43.4)

= 2.43.6 =
* Added: language support for mashup queries
* Fixed: mashups with query="all" or "current" returned no results from 2.43.2
* Fixed: AJAX error when adding autoicons
* Fixed: thumbnail size is output as a style for better infobox sizing

= 2.43.5 =
* Changed: restored 'adaptive' setting

= 2.43.4 =
* Added: check for jQuery version
* Changed: to support new geocoding API: removed 'sensor' parameter from geocoding calls, added api key and switched to https
* Changed: restored filter 'mappress_poi_html'
* Changed: removed filters 'mappress_poi_body', 'mappress_poi_links', and 'mappress_poi_links_html'
* Fixed: workaround for WP bug #33393 (deletes text in POI editor when switching visual/html tab)
* Fixed: workaround for hidden tabs calling wrong method to display map
* Fixed: addresses with foreign characters (like umlaut) were incorrect when geocoding custom fields due to double utf8-encoding
* Fixed: when using WPML, mashups with mashupClick="post" were always redirecting to post in base language

= 2.43.3 =
* Fixed: unable to save POIs in editor
* Fixed: directions not working because Google changed URL structure

= 2.43.2 =
* Fixed: public variables caused query errors with null queries

= 2.43.1 =
* Added: wp_query public variables can be included in queries, for example [mashup query="cat=@cat"] to show posts in the current category
* Fixed: drawing manager not showing up in editor

= 2.43 =
* Added: setting for automatic icons in mashups.  Note: filter 'mappress_poi_iconid' will be deprecated, please use the settings instead.
* Added: setting 'icon scaling'.  Enter dimensions to scale regular icons, or for scaling high-DPI/retina display icons
* Added: setting 'load scripts in footer'.  Uncheck this to show maps in AJAX calls, lightboxes, or infinite scrollers
* Changed: POI z-indexes are now set in reverse order so first POI has top index
* Changed: KML POIs are now suppressed in the poi list by default
* Changed: if initialOpenDirections="true" and no from/to address is provided, the first POI will be used as the "to" address
* Changed: initialOpenInfo="true" is now allowed for the widget
* Changed: new AJAX icon picker
* Changed: new polygon color picker with expanded palette
* Changed: polygon POIs can now be dragged
* Changed: added UTF8 encoding to geocoding requests for special characters
* Fixed: iOS "too many redirects" for directions after Google parameter change
* Fixed: directions 'print' parameters fixed
* Fixed: 'print' button removed on mobile devices where Google does not support print mode
* Fixed: map editor action links not clickable on iPad
* Fixed: don't auto-display maps on password-protected posts
* Fixed: url for Google 'print' directions updated to new value
* Fixed: url incorrect when redirecting to post from POI title
* Fixed: 2015 theme interferes with POI list table layout
* Fixed: incorrect display when editing tables on settings screen
* Removed: icon shadows (shadows are no longer supported by Google)
* Removed: JSON library (all browsers should support it natively)
* Removed: filters: mappress_poi_html, mappress_user_icons
* Removed: iwfix setting  (Google has finally fixed API bug 5713 involving infoWindow scrollbars)
* Removed: 'adaptive' setting
* Removed: 'disableAutoPan' setting
* Removed: border setting (add CSS styles to class 'mapp-layout' instead)
* Removed: CDATA in post content

= 2.42.1 =
* Changed: wider editor infobox for Chrome and WP 3.9
* Fixed: removed warning about border style
* Fixed: removed !important modifier from mapp-iw styles for font weight

= 2.42 =
* Added: compatibiliy for TinyMCE 4.x in WordPress 3.9+
* Changed: geocoding calls from PHP now use http instead of https to prevent curl errors
* Changed: updated Spanish translation, thanks to Agustin
* Fixed: tinyMCE icons in WordPress 3.8+

= 2.41.1 =
* Added: polyline and polygon vertices can now be deleted by right-clicking
* Fixed: Mappress_Map::delete is now declared static to prevent warning messages

= 2.41 =
* Fixed: warning message in save_post action if WordPress is in debug mode and no post ID is provided

= 2.40.9 =
* Changed: infowindow scrollbar fix is updated and can now be turned off in settings
* Changed: removed $poi->get_post() method
* Changed: CSS for infowindow (.mapp-iw)
* Fixed: use default height for mashups with width but no height

= 2.40.8 =
* Added: workaround for Google infoWindow sizing bug
* Added: shortcode parameters 'from' and 'to' can be used to set a default for all directions.  Use a string or POI number, for example [mappress from="2"] or [mappress from="Mountain View, CA"]
* Fixed: layout style was incorrect if map layout had rounded corners; this also prevented show="hidden" from working.
* Fixed: filter 'mappress_poi_iconid' was being called as 'mapress_poi_iconid' (with one 'p' instead of two)
* Fixed: Google CSS made copyright appear vertical in IE in some themes
* Fixed: Google bug with sizing infoWindows
* Changed: updated Italian translation, thanks to Reberto
* Changed: when dragging a marker originally entered by address, it will keep the address for directions instead of showing the lat/lng coordinates.
* Changed: no check for an active post for the mashup shortcode, to allow mashups on search results pages
* Changed: directions now appear -above- the poi list in the standard template 'layout.php'
* Changed: if option mashupClick="post", the plugin redirects using 'siteurl/?p=1234' instead of the permalink (which speeds up queries)
* Changed: initialopendirections is now a boolean: set it to 'true' or 'false'.

= 2.40.7 =
* Fixed: workaround for new output buffering issue in latest NextGen 2.0.11

= 2.40.6 =
* Fixed: warning message on settings screen
* Changed: custom map sizes are now available in all versions of the plugin

= 2.40.5 =
* Fixed: directions not working after Nextgen workaround

= 2.40.4 =
* Added: the POI editor now includes the 'paste' tinyMCE plugin to allow pasting from Microsoft Word
* Changed: if you have set the option to link POIs to posts, featured images will also link to the underlying post
* Changed: map sizes (on the settings screen) can be set to % sizes as well as pixels.  NOTE: existing sizes are reset, so re-enter them on the 'settings' screen if needed.
* Changed: a default size can now be selected and maps without a specific size will default to that size
* Changed: 'language' setting is now set dynamically
* Changed: up to 6 address lines are now supported
* Fixed: workaround for NextGen plugin bug: reverses order of wp_enqueue_script / wp_print_footer scripts.
* Fixed: tabs activation using new jQuery version in WordPress 3.6
* Fixed: workaround for NextGen plugin bug: admin_enqueue_scripts called without a hook name
* Fixed: some mobile devices did not show the map 'close' buttons correctly (mobile browser could not render 'max-width: auto', 'max-width: 99999px' used instead)
* Fixed: shadows were not appearing for custom icons
* Fixed: added missing localization for 'loading' and 'directions from' message strings
* Fixed: notice message for a static function called non-statically
* Fixed: map are now generated from metadata only if the post type is enabled for maps on the settings screen
* Fixed: update of maps from queued metadata was not working when multiple posts were queued at once

= 2.40.3 =
* Fixed: widget CSS settings
* Fixed: added missing blue iim2 shadow icon

= 2.40.2 =
* Fixed: PHP notice in widget
* Fixed: added updated Hungarian translation (thanks to Zsolt A.)

= 2.40.1 =
* Fixed: % width and % height were not working in the editor since 2.40
* Fixed: PHP notice when upgrade available
* Fixed: removed internal errors from language files

= 2.40 =
* Added: an 'insert into post' link is now available in the map list as well as the map editor
* Changed: fields in the map editor have been rearranged for clarity
* Changed: the 'letter' icons have been removed from the icon picker.  If you need to continue using them, contact me for support.
* Fixed: the icon picker now loads much faster as a single image