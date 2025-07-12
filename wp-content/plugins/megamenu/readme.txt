=== Max Mega Menu ===
Contributors: megamenu
Tags: menu, megamenu, mega menu, navigation, widget, dropdown menu, drag and drop, mobile, responsive, retina, theme editor, widget, shortcode, sidebar, icons, dashicons
Requires at least: 3.8
Tested up to: 4.8
Stable tag: 2.3.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An easy to use mega menu plugin. Written the WordPress way.

== Description ==

Max Mega Menu will automatically convert your existing menu or menus into a mega menu. You can then add any WordPress widget to your menu, restyle your menu using the theme editor and change the menu behaviour using the built in settings. Max Mega Menu is a complete menu management plugin, perfect for taking control of your existing menu and turning it into a user-friendly, accessible and touch ready menu with just a few clicks.

https://www.youtube.com/watch?v=44dJwP1AXT8

Documentation & Demo: [https://www.megamenu.com](https://www.megamenu.com)

###Features:

* Builds upon the standard WordPress menus system
* Supports multiple menu locations each with their own configuration
* Drag and Drop Mega Menu builder
* Display WordPress Widgets in your menu
* Customise the styling of your menus using a built in theme editor
* Supports Flyout (traditional) or Mega Menu sub menu styles
* Hover, Hover Intent or Click event to open sub menus
* Fade, Fade Up, Slide Up or Slide sub menu transitions
* Add icons to menu items
* Menu item options including Hide Text, Disable Link, Hide on Mobile etc
* Align menu items to the left or right of the menu bar
* Align sub menus to left or right of parent menu item

Max Mega Menu is developed with a focus on code quality, performance and usability.

* The only mega menu plugin with zero "!important", block or inline CSS styles
* Menus are styled using a single, static CSS file
* Less than 2kb JavaScript (when gzipped)
* Responsive, Touch & Retina Ready
* Built with accessibity in mind - keyboard navigation supported
* Extensively tested in all modern desktop and mobile browsers
* Clean code with a low memory footprint
* Filters and actions where you need them
* In depth documentation
* Basic Support

####Pro Features:

> * Sticky Menu
> * Vertical & Accordion Menus
> * FontAwesome, Genericon & Custom Icons
> * Custom Item Styling
> * Menu Logo
> * Search box
> * WooCommerce & EDD support
> * Google Fonts
> * Roles & Restrictions
> * Search, icon, HTML and logo mobile toggle blocks
> * Automatic updates
> * Priority Support
>
> Find out more: [https://www.megamenu.com/upgrade/](https://www.megamenu.com/upgrade/)

== Frequently Asked Questions ==

= Where do I start? =
[https://www.megamenu.com/documentation/installation/](https://www.megamenu.com/documentation/installation/)

= It’s not working at all =
[https://www.megamenu.com/documentation/not-working-at-all/](https://www.megamenu.com/documentation/not-working-at-all/)

= It works but somethings not right =
[https://www.megamenu.com/documentation/it-works-but-somethings-not-right/](https://www.megamenu.com/documentation/it-works-but-somethings-not-right/)

= The mobile menu is visible but nothing happens when I click it =
[https://www.megamenu.com/documentation/the-mobile-menu-is-visible-but-nothing-happens-when-i-click-it/](https://www.megamenu.com/documentation/the-mobile-menu-is-visible-but-nothing-happens-when-i-click-it/)

= The mobile menu is completely hidden =
[https://www.megamenu.com/documentation/the-mobile-menu-is-completely-hidden/](https://www.megamenu.com/documentation/the-mobile-menu-is-completely-hidden/)

= I see two mobile toggle buttons =
[https://www.megamenu.com/documentation/i-see-two-mobile-toggle-buttons/](https://www.megamenu.com/documentation/i-see-two-mobile-toggle-buttons/)

= A blank screen appears when I click the blue ‘Mega Menu’ button =
[https://www.megamenu.com/documentation/blank-screen-when-clicking-blue-mega-menu/](https://www.megamenu.com/documentation/blank-screen-when-clicking-blue-mega-menu/)

= Changes I make in the Theme Editor aren’t being applied to the menu =
[https://www.megamenu.com/documentation/theme-editor-not-working/](https://www.megamenu.com/documentation/theme-editor-not-working/)

== Installation ==

1. Go to the Plugins Menu in WordPress
1. Search for "Max Mega Menu"
1. Click "Install"

https://www.megamenu.com/documentation/installation/

== Screenshots ==

See https://www.megamenu.com for more screenshots

1. New menu changes
2. Drag and Drop widget editor for each menu item
3. Front end: Mega Menu
4. Front end: Flyout Menu
5. Back end: Use the theme editor to change the appearance of your menus

== Changelog ==

= 2.4 [17/10/17] =

* New (BETA): Grid Layout Option for Mega Menus
* Fix: Keyboard navigation for mobile menu
* Improvement: Grey out mobile toggle options when "Disable mobile toggle" is checked
* Improvement: Grey out all mobile options when "Responsive Breakpoint" is set to 0px
* Improvement: Warn users that menu theme edits may not show up when caching, CDN or minification plugins are installed
* Improvement: Better warning/error messages when theme changes fail to save
* Refactor: CSS and general behind the scenes improvements
* Fix: jQuery Migrate notices (admin)
* Fix: Authenticated XSS issue. Thanks to detectify.com for discovering it and pluginvulnerabilities.com for reporting it!

= 2.3.8 [25/08/17] =

* Fix: Compatibility fix for Reamaze plugin
* Fix: Respect the 'Unbind JavaScript Events' setting on mobile menus
* Improvement: Add support for vh/vw units in theme editor
* Change: Don't close open sub menus when mobile toggle is clicked

= 2.3.7.1 [06/07/17] =

* Fix: Conflict with Site Origin Page Builder

= 2.3.7 [06/07/17] =

* Compatibility with WordPress 4.8 Text and Media Widgets
* Fix: Compatiblity with SiteOrigin Page Builder Layout builder
* Improvement: Add support for MEGAMENU_SHARE_THEMES_MULTISITE constant
* Improvement: Process shortcodes in mobile toggle block open and closed text

= 2.3.6 [09/05/17] =

* Fix: Mobile breakpoint detection
* Fix: Increase wp_nav_menu_args priority to fix conflict with Thim-Core (Eduma theme)
* Fix: Add tabindex to items where the link has been disabled
* Fix: Deleting newly added mobile toggle blocks
* Improvement: Add mega menu button to unsaved menu items
* Improvement: Enable descriptions and disable css prefix of menu item classes by default (for new users only)
* Improvement: Add mobile font color to theme options
* Improvement: Improve error shown when failing to save theme
* Improvement: Improve message shown when menu is not tagged to a location
* Improvement: Attempt to raise memory limit when generating CSS
* Improvement: Enable highlight current item by default
* Improvement: Show warnings when CSS output is set to disabled
* Improvement: Add image widget option to available widgets, even if not installed
* Improvement: Update translations
* Improvement: Add megamenu_submitted_settings_meta filter

= 2.3.5 [19/02/17] =

* Fix: Image Widget Deluxe extra options not displaying
* Fix: Don't reverse the order or right aligned items in the mobile menu for RTL languages
* Fix: Keyboard navigation

= 2.3.4 [15/01/16] =

* New: Automatic integration for GeneratePress and Twenty Twelve (hide duplicate mobile button)
* New: "Icon Position" option added in the menu item settings (left, top, right) (requires clearing the Mega Menu CSS under Mega Menu > Tools)
* Fix: JavaScript fix for tabbed mobile menus

= 2.3.3 [29/12/16] =

* Fix: Compatibility with WPML Language switcher
* Fix: Remove max height from CSS Editor

= 2.3.2 [23/12/16] =

* Fix: Theme changes not being applied when PolyLang used in conjunction with the "Output in <head>" option
* Fix: JavaScript error when a dynamic width has been used for the sub menu, but the matching element does not exist on the page

= 2.3.1 [21/12/16] =

* Improvement: Theme Editor switched to tabbed interface
* Improvement: Theme Editor now uses AJAX save so you don't lose your place in the theme editor
* Improvement: Allow Custom CSS editor to increase in size
* Improvement: Test theme CSS compilation before saving
* Improvement: Add support for 9 columns
* New: Option to stop MMM from unbinding JavaScript events from the menu
* New: Option to stop MMM from prefixing custom CSS classes with 'mega-'
* New: Add automatic integration for Twenty Seventeen
* New: Add automatic integration for Zerif and Zerif Pro
* New: Add force left menu item alignment option
* New: Add support for "no-headers" custom CSS class
* Fix: Mobile sub menu width when resizing screen and using Dynamic sub menu widths
* Fix: Issue where click events are unbound from all menus on page
* Fix: "Disable link" styling when link is within a mega menu
* Fix: Stop sub menus reappearing on hover
* Fix: Account for scrollbars when determining sub menu width
* Fix: Conflict with Maps Builder plugin

= 2.3 [11/10/16] =

* New Feature: "Hover" event added (options are now Hover Intent, Hover or Click)
* New Feature: Menu Item Description support added
* New Feature: Add "Active Menu Instance" setting to allow mega menu to only be applied to an individual instance of a wp_nav_menu call (rather than all of them)
* Fix: Hover not working on some devices with touch screens. This has been tested for Hover, Hover Intent and Click on:
Mac FireFox/Safari/Chrome, Windows Edge/IE9/IE10/IE11/FireFox/Chrome, iPhone, iPad Chrome/Safari, Andoid Default/Chrome. If you have problems with touch or hover, please post in the support forums detailing exactly which Operating System, Browser and Event you are using so that I can reproduce the issue here.
* Fix: Mobile menu now always switches to click, even on desktops
* Fix: Responsive Breakpoint validation
* Fix: Swiping background on touch devices hides sub menus
* Fix: Remove margin from right aligned menu items on mobile
* Fix: Apply hover styling to current-page-ancestor
* Fix: Fix WPML cache clearing when CSS Output is set to Output in head
* Fix: Allow single quotes in theme editor custom CSS
* Fix: Allow single quotes in Menu Toggle toggle block text
* Fix: Improve theme editor settings validation
* Change: Remove permanent 'Go Pro' nag from Plugins page.
* Change: Add "mega-menu-location" body class when MMM is enabled for a location to pave the way for automatic theme integration
* Improvement: Add ".mega-multi-line" CSS to aid display of menu items with br tags in title

= 2.2.3.1 [23/08/2016] =

* Fix: JavaScript fix for themes/plugins that force WordPress to load outdated versions of jQuery (CherryFramework)

= 2.2.3 [15/08/2016] =

* Fix: Mega sub menus not correctly closed on mobile when effect is set to Fade
* Fix: Cursor styling for disabled links
* Fix: Apply animation to closing sub menus
* Fix: Bring megamenu button forward on nav-menus page
* Fix: Replace deprecated jQuery 'addSelf' with 'andBack'
* Improvement: Theme Editor usability. Add color pallete to color picker. Add Copy Color option
* Improvement: Only prompt for SCSS compilation when current CSS is outdated
* Change: Indicate whether style.css file was generated from core or custom version of megamenu.scss

= 2.2.2 [21/07/2016] =

* Fix: Save button missing from menu locations
* Fix: Compatibility with 'Profit Builder' plugin
* Fix: Remove outline from mobile toggle
* Fix: Make mobile toggle blocks editable as soon as they're added to the toggle block designer
* Change: Refactor detection of mega menu type submenus

= 2.2.1 =

* Fix: Self closing div tag in toggle blocks
* Fix: Mobile Menu Background / Conflict with MaxButtons

= 2.2 =

* New feature: CSS3 dropdown animations
* New feature: Animation speed setting
* New Feature: Accessibility (allow tab navigation of menus)
* Improvement: Load widgets.php scripts on nav-menus.php page to improve widget compatibility
* Improvement: Remove upgrade nags from icons tab
* Improvement: Add search to icons
* Improvement: Preselect last edited theme in theme editor
* Improvement: Only allow widget titles to be dragged in menu builder
* Improvement: Add 'Mobile menu background' and 'Disable mobile toggle' settings to theme editor
* Fix: Move toggle block IDs to classes to avoid validation errors
* Fix: Replace deprecated jQuery 'live' function calls with 'on'
* Fix: select2.png 404 in admin
* Fix: Reinstate icon margin on sub menu items when parent item has 'Hide text' enabled
* Fix: Active menu item border color
* Fix: Third level menu item visibility when JS is disabled
* Fix: Compatibility with Conditional Menus
* Fix: Compatibility with WordFence
* Fix: Compatibility with Image Widget Deluxe
* Fix: Widget titles wrapping onto two lines in mega menu builder
* Fix: Admin elements disappearing randomly in webkit browsers
* Change: Reset Widget Styling theme option - default changed from 'On' to 'Off'

= 2.1.5 [13/04/2016] =

* Change: Allow "Hide Text" option to be used on second level menu items

= 2.1.4 [11/04/2016] =

* Fix for WordPress v4.5: Unable to save mega menu settings on Appearance > Menus page
(Works around this change to core: https://core.trac.wordpress.org/changeset/36426)
* Change: Allow textarea fields in toggle blocks
* Change: Remove margin from Spacer toggle blocks

= 2.1.3 [21/03/2016] =

* Fix: JSON Theme Export
* Fix: "Output in <head>" CSS option edgecase (not working when the static CSS file exists but is not writable)
* Change: Don't apply Menu Padding theme setting to mobile menu (revisited - using a different method used to allow desktop padding to still be overridden in Custom Styling area)

= 2.1.2 [15/03/2016] =

* New feature: Mobile Toggle bar height setting added
* Fix: CSS "Don't output CSS" setting
* Change: Don't apply Menu Padding theme setting to mobile menu

= 2.1.1 [14/03/2016] =

* Fix: PHP Warnings
* Fix: SCSS variable doesn't exist warning
* Change: Reverse right aligned menu items in the mobile menu on window resize instead of reload
* Change: Some updates to the mobile toggle designer to ease extending the functionality with filters

= 2.1 [14/03/2016] =

* New Feature: Drag and drop designer for the mobile toggle bar
* Fix: WPML Language switcher flags
* New Feature: Export menu theme in PHP format (for inclusion in a functions.php file)
* Change: Remove CSS Enqueue via admin-ajax.php option due to slow performance

= 2.0.1 [07/01/2016] =

* Fix: Typos in the Theme Editor
* Fix: CSS Compilation Failed error for Helping Hands (and possibly other themes)
* Fix: Regenerate CSS after clearing cache to fix a conflict with caching plugins - ensure style.css always exists
* Fix: Enqueue menu CSS before the theme CSS, as it was pre 2.0
* Change: Theme Editor accordion open by default (to avoid JS conflicts which make it impossible to open the closed panels)
* Change: Admin Styling toned down
* Change: Hide mobile sub menu option moved to "Sub Menu Options" section
* New Feature: Sub Menu Inner Width setting added
* Improvement: Update Dashicons

= 2.0 [28/12/2015] =

* New feature: Allow second level menu items and widgets to be placed on the same row/mixed together within mega menus
* New feature: Mobile Styling options added to theme editor
* Improvement: Styling updated throughout
* Improvement: Theme Editor accordionised
* Improvement: Move JS to footer, unbind previously binded events from menu (for improved theme compatibility)
* Improvement: Basic validation added to Theme Editor
* New feature: Hide on mobile, Hide on desktop and Hide submenu on mobile options added
* Improvement: Display column count on widgets within the mega menu builder
* Fix: Getting started message displayed every time plugin is deactivated/activated
* Improvement: Clear cache nag now clears the cache instead of taking user to the Tools page
* Fix: Polylang fixes
* Improvement: Getting started link takes user to menus page and highlights mega menu options
* Improvement: Dropdown theme selector now displays which menu locations the theme is applied to

= 1.9.1 [20/10/2015] =

* New feature: Reverse the order of right aligned menu items on mobiles (so they appear in the same order as they do in the desktop menu)
* Fix: Remove Modernizr support - causing conflicts with some themes
* Fix: Collapsing of open flyout menus
* Fix: Active link styling not being applied to top level menu items when sub menus are open
* Fix: Polylang language switcher added to menu each time the Mega Menu settings are saved
* Fix: Polylang fixes

= 1.9 [14/09/2015] =

* New feature: WPML Support
* New feature: Polylang Support
* New feature: Added 'Reset Widget Styling' option to theme editor
* New feature: Page Builder by Site Origin support (Layout Builder widget now works within Mega Menus)
* Change: Remove Appearance > Max Mega Menu redirect
* Change: Update touch detection method. Use Modernizr if available.
* Change: Make hoverintent interval filterable
* Change: Refactor JS
* Change: Allow animation speeds to be changed using filters
* Fix: Unable to uncheck checkboxes in menu themes
* Fix: Compatibility with Pinboard Theme (dequeue colorbox)
* Fix: Mobile Second Click option reverts to default
* Fix: Fix initial fade in animation
* Fix: Sub menus within megamenus collapsing when Effect is set to 'Slide'

= 1.8.3.2 [30/07/2015] =

* Fix: Conflict with Add Descendents as Sub Menu Items plugin, where items are added resulting in an unordered list of menu items

= 1.8.3.1 [30/07/2015] =

* Fix: Conflict with Add Descendents as Sub Menu Items plugin, where items are added to the menu and given a menu_item_parent ID of an item that doesn't exist in the menu

= 1.8.3 [28/07/2015] =

* New feature: Add accordion style mobile menu option
* New feature: French Language pack added (thanks to Pierre_02!)
* Change: Check MMM is enabled for the menu before enabling the Mega Menu button on each menu item
* Change: Add '300' and 'inherit' options to font weight, add 'megamenu_font_weights' filter
* Change: Move mega menu settings page from under Appearance to it's own Top Level menu item (since the plugin options are no longer purely appearance related)
* Fix: Second row menu items not correctly being forced onto a new line
* Fix: PHP warning when widget cannot be found (due to being uninstalled)
* Fix: Remove borders and excess padding from mobile menu (regardless of theme settings)
* Fix: Inability to undisable links on second level menu items
* Fix: Fix theme export/import when custom CSS contains double quotes
* Fix: Compatibility fix for SlideDeck Pro
* Fix: Compatibility fix for TemplatesNext Toolkit
* Fix: Widget title widths in mega menu editor
* Fix: IE9 blue background when semi transparent colors are selected in the theme editor

= 1.8.2 =

* Fix: PHP Warning preventing mega menu settings from loading

= 1.8.1 =

* Change: Add filters for before_title, after_title, before_widget, after_widget
* Change: Add widget classes to menu list items
* Fix: Detect protocol when enqueueing CSS file from FS
* Fix: Compatibility with WP Widget Cache
* Change: Convert 'enable mega menu' checkbox into a select for clarity

= 1.8 =

* New Feature: Menu Theme Import/Export
* New Feature: Create extra menu locations for use in shortcodes & the MMM widget
* Fix: Compatibility with Black Studio TinyMCE widget
* Fix: Save spinners not appearing in WordPress 4.2
* Fix: Empty mega menu settings lightbox (caused by conflicting plugins outputting PHP warnings)
* Fix: Incompatibility with Ultimate Member
* Fix: Icon colours in Advada Theme
* Change: Default CSS Output set to Filesystem
* Add max_mega_menu_is_enabled function for easier theme integration

= 1.7.4 =

* New Feature: Max Mega Menu widget to display a menu location within a sidebar
* Fix: Another Suffusion theme conflict (nested UL menus set to visibility: hidden)
* Improvement: Add :focus states

= 1.7.3.1 =

* Fix: A CSS conflict with Suffusion theme (and possibly others) which was uncovered in v1.7.3

= 1.7.3 =

* Theme Editor enhancements: Add hover transition option, second and third level menu item styling, top level menu item border, flyout menu item divider, widget title border & margin settings
* Fix: Apply hover styling to menu items when the link is hovered over (not the list item containing the link)
* Change: Use visibility:hidden instead of display:none to hide sub menus (for compatibility with Google Map widgets)
* Change: Disable automatic regeneration of CSS after update and install, prompt user to manually regenerate CSS instead

= 1.7.2 =

* Fix: Fire open and close_panel events after the panel has opened or closed
* Refactor: Build list of SCSS vars using an array
* Refactor: Use wp_send_json instead of wp_die to return json
* Refactor: Build URLs using add_query_var (WordPress Coding Standards)
* New feature: Add dropdown shadow option to theme editor

= 1.7.1 =

* Fix: Regenerate CSS on upgrade
* Fix: Mobile toggle on Android 2.3
* Fix: Error when switching themes (when CSS output is set to "save to filesystem")

= 1.7 =

* Fix: Apply sensible defaults to responsive menu styling regardless of menu theme settings
* Fix: Allow underscores and spaces in theme locations without breaking CSS
* Fix: Reset widget selector after selecting a widget
* Change: CSS3 checkbox based responsive menu toggle replaced with jQuery version (for increased compatibility with themes)
* Change: Front end JavaScript refactored
* Change: Leave existing sub menus open when opening a new sub menu on mobiles
* New feature: New option added for CSS Output: Output/save CSS to uploads folder
* New feature: Add text decoration option to fonts in theme editor
* New feature: Allow jQuery selector to be used as the basis of the mega menu width
* New feature: Add menu items align option to theme editor
* New feature: Add hightlight selected menu item option to theme editor
* New feature: Add flyout border radius option to theme editor
* New feature: Add menu item divider option to theme editor
* New feature: Add second click behaviour option to general settings

= 1.6 =

* Fix: responsive collapse menu
* Fix: checkbox appearing on Enfold theme

= 1.6-beta =

* Change: Menu ID removed from menu class and ID attributes on menu wrappers. E.g. "#mega-menu-wrap-primary-2" will now be "#mega-menu-wrap-primary", "#mega-menu-primary-2" will now be "#mega-menu-primary".
* Fix: Polylang & WPML compatibility (fixed due to the above)
* Fix: Multi Site support (mega menu settings will need to be reapplied in some cases for multi site installs)
* Fix: Remove jQuery 1.8 dependency
* Change: Theme editor slightly revised

= 1.5.3 =

* Fix: Widget ordering bug when mega menu contains sub menu items (reported by & thanks to: milenasmart)
* Misc: Add megamenu_save_menu_item_settings action

= 1.5.2 =

* Feature: Responsive menu text option in theme editor
* Fix: Bug causing menu item to lose checkbox settings when saving mega menu state
* Fix: Mobile menu items disappearing
* Change: Refactor public js
* Change: jQuery actions fired on panel open/close
* Change: Tabify icon options
* Change: Show 'up' icon when mobile sub menu is open
* Change: Make animations filterable
* Change: Add filter for SCSS and SCSS vars
* Change: Add filter for menu item tabs
* Update: Update german language files (thanks to dirk@d10n)

= 1.5.1 =

* Fix: Bug causing menu item to lose checkbox settings when saving icon

= 1.5 =

* New feature: Change number of columns to use in Mega Menus (per menu item)
* New feature: Define how many columns each second level menu items should take up
* New feature: Hide menu item text
* New feature: Hide menu item arrow indicator
* New feature: Disable menu item link
* New feature: Align menu item
* Fix: Allow css to be cached when menu is not found
* Fix: Apply inline-block styling to second level menu items displayed in Mega Menu
* Fix: AJAX Error when widgets lack description (reported by and thanks to: novlenova)
* Improvement: Refactor extraction and setting of menu item settings

= 1.4 =

* Update: Admin interface improvements
* New feature: CSS Output options

= 1.3.3 =

* Fix: theme warnings (thanks to armandsdz!)
* Update: compatibile version number updated to 4.1

= 1.3.2 =

* Theme Editor restyled
* Fix: Flyout menu item height when item wraps onto 2 lines
* Fix: Add indentation to third level items in mega panel

= 1.3.1 =

* Fix secondary menu bug
* Add option to print CSS to <head> instead of enqueuing as external file

= 1.3 =

* maxmenu shortcode added. Example: [maxmenu location=primary]
* 'megamenu_after_install' and 'megamenu_after_upgrade' hooks added
* 'megamenu_scss' hook added
* Fix: CSS automatically regenerated after upgrade
* Fix: Don't override the echo argument for wp_nav_menu
* Fix: Theme duplication when default theme has been edited
* Change: CSS cache set to never expire
* Added import SCSS import paths
* German Translations added (thanks to Thomas Meyer)

= 1.2.2 =

* Add support for "click-click-go" menu item class to follow a link on second click
* Remove widget overflow

= 1.2.1 =

* Fix IE11 gradients
* Fix hover bug introducted in 1.2

= 1.2 =

* Less agressive cache clearing
* Compatible with Nav Menu Roles
* UX improvements for the panel editor
* Hover effect on single items fixed
* JS cleaned up

= 1.1 =

* Added Fade and SlideDown transitions for panels
* Added panel border, flyout border & panel border radius settings
* JavaScript tidied up
* Ensure hoverIntent is enqueued before Mega Menu

= 1.0.4 =

* Italian translation added. Thanks to aeco!

= 1.0.3 =

* Add Panel Header Font Weight theme setting
* Allow semi transparent colors to be picked

= 1.0.2 =

* Update minimum required WP version from 3.9 to 3.8.

= 1.0.1 =

* Fix PHP Short Tag (thanks for the report by polderme)

= 1.0 =

* Initial version

== Upgrade Notice ==
