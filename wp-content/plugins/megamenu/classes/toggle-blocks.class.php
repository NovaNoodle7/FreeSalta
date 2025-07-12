<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Toggle_Blocks') ) :

/**
 * Mobile Toggle Blocks
 */
class Mega_Menu_Toggle_Blocks {

    /**
     * Constructor
     *
     * @since 2.1
     */
    public function __construct() {

        add_filter( 'megamenu_scss_variables', array( $this, 'add_menu_toggle_block_vars_to_scss'), 10, 5 );
        add_filter( 'megamenu_scss_variables', array( $this, 'add_spacer_block_vars_to_scss'), 10, 5 );
        add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_scss'), 10 );
        add_filter( 'megamenu_toggle_bar_content', array( $this, 'output_public_toggle_blocks' ), 10, 4 );

        add_action( 'wp_ajax_mm_get_toggle_block_menu_toggle', array( $this, 'output_menu_toggle_block_html' ) );
        add_action( 'megamenu_output_admin_toggle_block_menu_toggle', array( $this, 'output_menu_toggle_block_html'), 10, 2 );
        add_action( 'wp_ajax_mm_get_toggle_block_spacer', array( $this, 'output_spacer_block_html' ) );
        add_action( 'megamenu_output_admin_toggle_block_spacer', array( $this, 'output_spacer_block_html'), 10, 2 );

        add_action( 'megamenu_after_theme_revert', array($this, 'revert_toggle_blocks') );
        add_action( 'megamenu_after_theme_save', array( $this, 'save_toggle_blocks' ) );

        add_action( 'megamenu_admin_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'megamenu_print_theme_option_toggle_blocks', array( $this, 'print_theme_toggle_bar_designer_option'), 10, 2);

        add_filter( 'megamenu_theme_editor_settings', array( $this, 'add_toggle_designer_to_theme_editor'), 10 );

    }


    /**
     * Return the saved toggle blocks for a specified theme
     *
     * @param string $theme_id
     * @since 2.1
     * @return array
     */
    private function get_toggle_blocks_for_theme( $theme_id ) {

        $blocks = max_mega_menu_get_toggle_blocks();

        if ( isset( $blocks[ $theme_id ] ) ) {
            return $blocks[ $theme_id ];
        }

        // backwards compatibility
        // default to right aligned menu toggle using existing theme settings
        $default_blocks = array(
            1 => $this->get_default_menu_toggle_block( $theme_id )
        );

        return $default_blocks;

    }


    /**
     * Return default menu toggle block settings
     *
     * @since 2.1
     * @return array
     */
    private function get_default_menu_toggle_block( $theme_id = 'default' ) {

        $style_manager = new Mega_Menu_Style_Manager();

        $themes = $style_manager->get_themes();

        $menu_theme = isset( $themes[ $theme_id ] ) ? $themes[ $theme_id ] : $themes['default'];

        $defaults = array(
            'type' => 'menu_toggle',
            'align' => 'right',
            'closed_text' => isset($menu_theme['responsive_text']) ? $menu_theme['responsive_text'] : "MENU",
            'open_text' => isset($menu_theme['responsive_text']) ? $menu_theme['responsive_text'] : "MENU",
            'closed_icon' => 'dash-f333',
            'open_icon' => 'dash-f153',
            'icon_position' => 'after',
            'text_color' => isset($menu_theme['toggle_font_color']) ? $menu_theme['toggle_font_color'] : '#fff',
            'icon_color' => isset($menu_theme['toggle_font_color']) ? $menu_theme['toggle_font_color'] : '#fff'
        );

        return $defaults;
    }


    /**
     * Get the HTML output for the toggle blocks
     *
     * @since 2.1
     * @param string $content
     * @param string $nav_menu
     * @param array $args
     * @param string $theme_id
     * @return string
     */
    public function output_public_toggle_blocks( $content, $nav_menu, $args, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $blocks_html = "";

        if ( is_array( $toggle_blocks ) ) {
            foreach ( $toggle_blocks as $block_id => $block ) {

                if ( isset( $block['type'] ) ) {
                    $class = "mega-" . str_replace("_", "-", $block['type']) . "-block";
                } else {
                    $class = "";
                }

                if ( isset( $block['align'] ) ) {
                    $align = "mega-toggle-block-" . $block['align'];
                } else {
                    $align = "mega-toggle-block-left";
                }

                // @todo remove ID once MMM Pro has been updated to use classes
                $id = apply_filters('megamenu_toggle_block_id', 'mega-toggle-block-' . $block_id);

                $attributes = apply_filters('megamenu_toggle_block_attributes', array(
                    "class" => "mega-toggle-block {$class} {$align} mega-toggle-block-{$block_id}",
                    "id" => "mega-toggle-block-{$block_id}"
                ), $block, $content, $nav_menu, $args, $theme_id);

                /**
                 *
                 * function remove_ids_from_toggle_blocks($attributes, $block, $content, $nav_menu, $args, $theme_id) {
                 *    if (isset($attributes['id'])) {
                 *        unset($attributes['id']);
                 *    }
                 *    return $attributes;
                 * }
                 * add_filter('megamenu_toggle_block_attributes', 'remove_ids_from_toggle_blocks');
                 *
                 */

                $blocks_html .= "<div";

                foreach ( $attributes as $attribute => $val ) {
                    $blocks_html .= " " . $attribute . "='" . esc_attr( $val ) . "'";
                }

                $blocks_html .= ">";
                $blocks_html .= apply_filters("megamenu_output_public_toggle_block_{$block['type']}", "", $block);
                $blocks_html .= "</div>";
            }
        }

        $content .= $blocks_html;

        return $content;

    }


    /**
     * Save the toggle blocks when the theme is saved
     *
     * @since 2.1
     */
    public function save_toggle_blocks() {

        $theme = esc_attr( $_POST['theme_id'] );

        $saved_blocks = max_mega_menu_get_toggle_blocks();

        if ( isset( $saved_blocks[ $theme ] ) ) {
            unset( $saved_blocks[ $theme ] );
        }

        $submitted_settings = $_POST['toggle_blocks'];

        $saved_blocks[ $theme ] = $submitted_settings;

        max_mega_menu_save_toggle_blocks( $saved_blocks );

    }


    /**
     * Revert the toggle blocks when a theme is reverted
     *
     * @since 2.1
     */
    public function revert_toggle_blocks() {

        $theme = esc_attr( $_GET['theme_id'] );

        $saved_toggle_blocks = max_mega_menu_get_toggle_blocks();

        if ( isset( $saved_toggle_blocks[$theme] ) ) {
            unset( $saved_toggle_blocks[$theme] );
        }

        max_mega_menu_save_toggle_blocks( $saved_toggle_blocks );
    }


    /**
     * Add the toggle bar designer to the theme editor
     *
     * @since 2.1
     * @return array
     */
    public function add_toggle_designer_to_theme_editor( $settings ) {

        $settings['mobile_menu']['settings']['toggle_blocks'] = array(
            'priority' => 5,
            'title' => __( "Toggle Bar Designer", "megamenu" ),
            'description' => __( "Configure the contents of the mobile toggle bar", "megamenu" ),
            'settings' => array(
                array(
                    'title' => "",
                    'type' => 'toggle_blocks',
                    'key' => 'toggle_blocks'
                )
            ),
        );

        return $settings;
    }


    /**
     * Enqueue nav-menus.php scripts
     *
     * @since 2.1
     */
    public function enqueue_scripts() {

        wp_enqueue_script( 'mega-menu-toggle-bar-designer', MEGAMENU_BASE_URL . 'js/toggledesigner.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), MEGAMENU_VERSION );

        wp_localize_script( 'mega-menu-toggle-bar-designer', 'megamenu',
            array(
                'nonce' => wp_create_nonce('megamenu_edit')
            )
        );

    }


    /**
     * Append the logo SCSS to the main SCSS file
     *
     * @since 2.1
     * @param string $scss
     * @param string
     */
    public function append_scss( $scss ) {

        $path = MEGAMENU_PATH . 'css/toggle-blocks.scss';

        $contents = file_get_contents( $path );

        return $scss . $contents;

    }


    /**
     * Create a new variable containing the toggle blocks to be used by the SCSS file
     *
     * @param array $vars
     * @param string $location
     * @param string $theme
     * @param int $menu_id
     * @param string $theme_id
     * @return array - all custom SCSS vars
     * @since 2.1
     */
    public function add_menu_toggle_block_vars_to_scss( $vars, $location, $theme, $menu_id, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $menu_toggle_blocks = array();

        if ( is_array( $toggle_blocks ) ) {

            foreach( $toggle_blocks as $index => $settings ) {

                if ( isset( $settings['type'] ) && $settings['type'] == 'menu_toggle' ) {

                    if ( isset( $settings['closed_icon'] ) ) {
                        $closed_icon_parts = explode( '-', $settings['closed_icon'] );
                        $closed_icon = end( $closed_icon_parts );
                    } else {
                        $closed_icon = 'disabled';
                    }

                    if ( isset( $settings['open_icon'] ) ) {
                        $open_icon_parts = explode( '-', $settings['open_icon'] );
                        $open_icon = end( $open_icon_parts );
                    } else {
                        $open_icon = 'disabled';
                    }
                    
                    if ( isset( $settings['closed_text'] ) ) {
                        $closed_text = "'" . do_shortcode( stripslashes( html_entity_decode( $settings['closed_text'], ENT_QUOTES ) ) ) . "'";
                    } else {
                        $closed_text = "'MENU'";
                    }

                    if ( isset( $settings['open_text'] ) ) {
                        $open_text = "'" . do_shortcode( stripslashes( html_entity_decode( $settings['open_text'], ENT_QUOTES ) ) ) . "'";
                    } else {
                        $open_text = "''";
                    }
                    
                    $styles = array(
                        'id' => $index,
                        'align' => isset($settings['align']) ? "'" . $settings['align'] . "'" : "'right'",
                        'closed_text' => $closed_text,
                        'open_text' => $open_text,
                        'closed_icon' => $closed_icon != 'disabled' ? "'\\" . $closed_icon  . "'" : "''",
                        'open_icon' => $open_icon != 'disabled' ? "'\\" . $open_icon . "'" : "''",
                        'text_color' => isset($settings['text_color']) ? $settings['text_color'] : '#fff',
                        'icon_color' => isset($settings['icon_color']) ? $settings['icon_color'] : '#fff',
                        'icon_position' => isset($settings['icon_position']) ? "'" . $settings['icon_position'] . "'" : 'after'
                    );

                    $menu_toggle_blocks[ $index ] = $styles;
                }

            }
        }

        //$menu_toggle_blocks(
        // (123, red, 150px),
        // (456, green, null),
        // (789, blue, 90%),());
        if ( count( $menu_toggle_blocks ) ) {

            $list = "(";

            foreach ( $menu_toggle_blocks as $id => $vals ) {
                $list .= "(" . implode( ",", $vals ) . "),";
            }

            // Always add an empty list item to meke sure there are always at least 2 items in the list
            // Lists with a single item are not treated the same way by SASS
            $list .= "());";

            $vars['menu_toggle_blocks'] = $list;

        } else {

            $vars['menu_toggle_blocks'] = "()";

        }

        return $vars;
    }

    /**
     * Create a new variable containing the spacer blocks to be used by the SCSS file
     *
     * @param array $vars
     * @param string $location
     * @param string $theme
     * @param int $menu_id
     * @param string $theme_id
     * @return array - all custom SCSS vars
     * @since 2.1
     */
    public function add_spacer_block_vars_to_scss( $vars, $location, $theme, $menu_id, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $spacer_blocks = array();

        if ( is_array( $toggle_blocks ) ) {

            foreach( $toggle_blocks as $index => $settings ) {

                if ( isset( $settings['type'] ) && $settings['type'] == 'spacer' ) {

                    $styles = array(
                        'id' => $index,
                        'align' => isset($settings['align']) ? "'" . $settings['align'] . "'" : "'right'",
                        'width' => isset($settings['width']) ? $settings['width'] : '0px',
                    );

                    $spacer_blocks[ $index ] = $styles;
                }

            }
        }

        //$menu_toggle_blocks(
        // (123, red, 150px),
        // (456, green, null),
        // (789, blue, 90%),());
        if ( count( $spacer_blocks ) ) {

            $list = "(";

            foreach ( $spacer_blocks as $id => $vals ) {
                $list .= "(" . implode( ",", $vals ) . "),";
            }

            // Always add an empty list item to meke sure there are always at least 2 items in the list
            // Lists with a single item are not treated the same way by SASS
            $list .= "());";

            $vars['spacer_toggle_blocks'] = $list;

        } else {

            $vars['spacer_toggle_blocks'] = "()";

        }

        return $vars;

    }


    /**
     * Print the toggle bar designer option
     *
     * @since 2.1
     * @param string $key
     * @param string $theme_id
     */
    public function print_theme_toggle_bar_designer_option( $key, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $block_types = apply_filters("megamenu_registered_toggle_blocks", array(
            'title' => __("Add block to toggle bar", "megamenu"),
            'menu_toggle' => __("Menu Toggle", "megamenu"),
            'spacer' => __("Spacer", "megamenu")
        ));

        ?>

        <select id='toggle-block-selector'>
            <?php foreach( $block_types as $block_id => $block_name ) : ?>
                <option value='<?php echo $block_id; ?>'><?php echo $block_name ?></option>
            <?php endforeach; ?>

            <?php if ( ! is_plugin_active('megamenu-pro/megamenu-pro.php') ): ?>
                <option disabled="disabled">Search (Pro)</option>
                <option disabled="disabled">Logo (Pro)</option>
                <option disabled="disabled">Icon (Pro)</option>
                <option disabled="disabled">HTML (Pro)</option>
            <?php endif; ?>
        </select>

        <div class='toggle-bar-designer'>
            <div class='mega-blocks'>
                <div class='mega-left'>
                    <?php

                    if ( is_array( $toggle_blocks ) ) {
                        foreach( $toggle_blocks as $block_id => $settings ) {
                            if ( is_int( $block_id ) && is_array( $settings ) && isset( $settings['align'] ) && $settings['align'] == 'left' || ! isset( $settings['align'] ) ) {
                                if ( isset( $settings['type'] ) ) {
                                    do_action( "megamenu_output_admin_toggle_block_{$settings['type']}", $block_id, $settings );
                                }
                            }
                        }
                    }

                    ?>
                </div>
                <div class='mega-center'>
                    <?php

                    if ( is_array( $toggle_blocks ) ) {
                        foreach( $toggle_blocks as $block_id => $settings ) {
                            if ( is_int( $block_id ) && is_array( $settings ) && isset( $settings['align'] ) && $settings['align'] == 'center' ) {
                                if ( isset( $settings['type'] ) ) {
                                    do_action( "megamenu_output_admin_toggle_block_{$settings['type']}", $block_id, $settings );
                                }
                            }
                        }
                    }

                    ?>
                </div>
                <div class='mega-right'>
                    <?php

                    if ( is_array( $toggle_blocks ) ) {
                        foreach( $toggle_blocks as $block_id => $settings ) {
                            if ( is_int( $block_id ) && is_array( $settings ) && isset( $settings['align'] ) && $settings['align'] == 'right' ) {
                                if ( isset( $settings['type'] ) ) {
                                    do_action( "megamenu_output_admin_toggle_block_{$settings['type']}", $block_id, $settings );
                                }
                            }
                        }
                    }

                    ?>
                </div>

            </div>


        </div>

        <p class='mega-info'><?php _e("Click on a block to edit it, or drag and drop it to resposition the block within the toggle bar", "megamenu"); ?></p>


        <?php
    }


    /**
     * Output the HTML for the "Spacer" toggle block settings
     *
     * @since 2.1
     * @param int $block_id
     * @param array $settings
     */
    public function output_spacer_block_html( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $defaults = array(
            'align' => 'right',
            'width' => '0px'
        );

        $settings = array_merge( $defaults, $settings );

        ?>

        <div class='block'>
            <div class='block-title'><span title='<?php _e("Spacer", "megamenu"); ?>' class="dashicons dashicons-leftright"></span></div>
            <div class='block-settings'>
                <h3><?php _e("Spacer Settings", "megamenu") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='spacer' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>
                <label>
                    <?php _e("Width", "megamenu") ?><input type='text' class='closed_text' name='toggle_blocks[<?php echo $block_id; ?>][width]' value='<?php echo $settings['width'] ?>' />
                </label>
                <a class='mega-delete'><?php _e("Delete", "megamenu"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Output the HTML for the "Menu Toggle" block settings
     *
     * @since 2.1
     * @param int $block_id
     * @param array $settings
     */
    public function output_menu_toggle_block_html( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $theme_id = 'default';

        if ( isset( $_GET['theme'] ) ) {
            $theme_id = esc_attr( $_GET['theme'] );

        }

        $defaults = $this->get_default_menu_toggle_block( $theme_id );

        $settings = array_merge( $defaults, $settings );

        ?>

        <div class='block'>
            <div class='block-title'><?php _e("MENU", "megamenu"); ?> <span title='<?php _e("Menu Toggle", "megamenu"); ?>' class="dashicons dashicons-menu"></span></div>
            <div class='block-settings'>
                <h3><?php _e("Menu Toggle Settings", "megamenu") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='menu_toggle' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>
                <label>
                    <?php _e("Closed Text", "megamenu") ?><input type='text' class='closed_text' name='toggle_blocks[<?php echo $block_id; ?>][closed_text]' value='<?php echo stripslashes( esc_attr( $settings['closed_text'] ) ) ?>' />
                </label>
                <label>
                    <?php _e("Open Text", "megamenu") ?><input type='text' class='open_text' name='toggle_blocks[<?php echo $block_id; ?>][open_text]' value='<?php echo stripslashes( esc_attr( $settings['open_text']  ) ) ?>' />
                </label>
                <label>
                    <?php _e("Closed Icon", "megamenu") ?>
                    <?php $this->print_icon_option( 'closed_icon', $block_id, $settings['closed_icon'], $this->toggle_icons() ); ?>
                </label>
                <label>
                    <?php _e("Open Icon", "megamenu") ?>
                    <?php $this->print_icon_option( 'open_icon', $block_id, $settings['open_icon'], $this->toggle_icons() ); ?>
                </label>
                <label>
                    <?php _e("Text Color", "megamenu") ?>
                    <?php $this->print_toggle_color_option( 'text_color', $block_id, $settings['text_color'] ); ?>
                </label>
                <label>
                    <?php _e("Icon Color", "megamenu") ?>
                    <?php $this->print_toggle_color_option( 'icon_color', $block_id, $settings['icon_color'] ); ?>
                </label>
                <label>
                    <?php _e("Icon Position", "megamenu") ?><select name='toggle_blocks[<?php echo $block_id; ?>][icon_position]'>
                        <option value='before' <?php selected( $settings['icon_position'], "before" ) ?> ><?php _e("Before", "megamenu") ?></option>
                        <option value='after' <?php selected( $settings['icon_position'], "after" ) ?> ><?php _e("After", "megamenu") ?></option>
                    </select>
                </label>
                <a class='mega-delete'><?php _e("Delete", "megamenu"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Print an icon selection box
     *
     * @since 2.1
     * @param string $key
     * @param int $block_id
     * @param string $value
     */
    public function print_icon_option( $key, $block_id, $value, $icons ) {

        ?>
            <select class='icon_dropdown' name='toggle_blocks[<?php echo $block_id ?>][<?php echo $key ?>]'>
                <?php

                    echo "<option value='disabled'>" . __("Disabled", "megamenu") . "</option>";

                    foreach ($icons as $code => $class) {
                        $name = str_replace('dashicons-', '', $class);
                        $name = ucwords(str_replace(array('-','arrow'), ' ', $name));
                        echo "<option data-class='{$class}' value='{$code}'" . selected( $value, $code, false ) . ">" . $name . "</option>";
                    }

                ?>
            </select>

        <?php
    }


    /**
     * Print a color picker
     *
     * @since 2.1
     * @param string $key
     * @param int $block_id
     * @param string $value
     */
    public function print_toggle_color_option( $key, $block_id, $value ) {

        if ( $value == 'transparent' ) {
            $value = 'rgba(0,0,0,0)';
        }

        if ( $value == 'rgba(0,0,0,0)' ) {
            $value_text = 'transparent';
        } else {
            $value_text = $value;
        }

        echo "<div class='mm-picker-container'>";
        echo "    <input type='text' class='mm_colorpicker' name='toggle_blocks[{$block_id}][{$key}]' value='{$value}' />";
        echo "    <div class='chosen-color'>{$value_text}</div>";
        echo "</div>";

    }


    /**
     * List of all available toggle DashIcon classes.
     *
     * @since 2.1
     * @return array - Sorted list of toggle classes
     */
    public function toggle_icons() {

        $icons = array(
            'dash-f333' => 'dashicons-menu',
            'dash-f214' => 'dashicons-editor-justify',
            'dash-f158' => 'dashicons-no',
            'dash-f335' => 'dashicons-no-alt',
            'dash-f132' => 'dashicons-plus',
            'dash-f502' => 'dashicons-plus-alt',
            'dash-f460' => 'dashicons-minus',
            'dash-f153' => 'dashicons-dismiss',
            'dash-f142' => 'dashicons-arrow-up',
            'dash-f140' => 'dashicons-arrow-down',
            'dash-f342' => 'dashicons-arrow-up-alt',
            'dash-f346' => 'dashicons-arrow-down-alt',
            'dash-f343' => 'dashicons-arrow-up-alt2',
            'dash-f347' => 'dashicons-arrow-down-alt2',
        );

        $icons = apply_filters( "megamenu_toggle_icons", $icons );

        return $icons;

    }

}

endif;