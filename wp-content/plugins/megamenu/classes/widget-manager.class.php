<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Widget_Manager') ) :

/**
 * Processes AJAX requests from the Mega Menu panel editor.
 * Also registers our widget sidebar.
 *
 * There is very little in WordPress core to help with listing, editing, saving,
 * deleting widgets etc so this class implements that functionality.
 */
class Mega_Menu_Widget_Manager {

    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct() {

        add_action( 'init', array( $this, 'register_sidebar' ) );

        add_action( 'wp_ajax_mm_edit_widget', array( $this, 'ajax_show_widget_form' ) );
        add_action( 'wp_ajax_mm_save_widget', array( $this, 'ajax_save_widget' ) );
        add_action( 'wp_ajax_mm_update_widget_columns', array( $this, 'ajax_update_widget_columns' ) );
        add_action( 'wp_ajax_mm_update_menu_item_columns', array( $this, 'ajax_update_menu_item_columns' ) );
        add_action( 'wp_ajax_mm_delete_widget', array( $this, 'ajax_delete_widget' ) );
        add_action( 'wp_ajax_mm_add_widget', array( $this, 'ajax_add_widget' ) );
        add_action( 'wp_ajax_mm_reorder_items', array( $this, 'ajax_reorder_items' ) );
        add_action( 'wp_ajax_mm_save_grid_data', array( $this, 'ajax_save_grid_data' ) );

        add_filter( 'widget_update_callback', array( $this, 'persist_mega_menu_widget_settings'), 10, 4 );

        add_action( 'megamenu_after_widget_add', array( $this, 'clear_caches' ) );
        add_action( 'megamenu_after_widget_save', array( $this, 'clear_caches' ) );
        add_action( 'megamenu_after_widget_delete', array( $this, 'clear_caches' ) );

    }


    /**
     * Depending on how a widget has been written, it may not necessarily base the new widget settings on
     * a copy the old settings. If this is the case, the mega menu data will be lost. This function
     * checks to make sure widgets persist the mega menu data when they're saved.
     *
     * @since 1.0
     */
    public function persist_mega_menu_widget_settings( $instance, $new_instance, $old_instance, $that ) {

        if ( isset( $old_instance["mega_menu_columns"] ) && ! isset( $new_instance["mega_menu_columns"] ) ) {
            $instance["mega_menu_columns"] = $old_instance["mega_menu_columns"];
        }

        if ( isset( $old_instance["mega_menu_order"] ) && ! isset( $new_instance["mega_menu_order"] ) ) {
            $instance["mega_menu_order"] = $old_instance["mega_menu_order"];
        }

        if ( isset( $old_instance["mega_menu_parent_menu_id"] ) && ! isset( $new_instance["mega_menu_parent_menu_id"] ) ) {
            $instance["mega_menu_parent_menu_id"] = $old_instance["mega_menu_parent_menu_id"];
        }

        return $instance;
    }


    /**
     * Create our own widget area to store all mega menu widgets.
     * All widgets from all menus are stored here, they are filtered later
     * to ensure the correct widgets show under the correct menu item.
     *
     * @since 1.0
     */
    public function register_sidebar() {

        register_sidebar(
            array(
                'id' => 'mega-menu',
                'name' => __("Max Mega Menu Widgets", "megamenu"),
                'description'   => __("This is where Max Mega Menu stores widgets that you have added to sub menus using the mega menu builder. You can edit existing widgets here, but new widgets must be added through the Mega Menu interface (under Appearance > Menus).", "megamenu")
            )
        );
    }


    /**
     * Display a widget settings form
     *
     * @since 1.0
     */
    public function ajax_show_widget_form() {

        check_ajax_referer( 'megamenu_edit' );

        $widget_id = sanitize_text_field( $_POST['widget_id'] );

        if ( ob_get_contents() ) ob_clean(); // remove any warnings or output from other plugins which may corrupt the response

        wp_die( trim( $this->show_widget_form( $widget_id ) ) );

    }


    /**
     * Save a widget
     *
     * @since 1.0
     */
    public function ajax_save_widget() {

        $widget_id = sanitize_text_field( $_POST['widget_id'] );
        $id_base = sanitize_text_field( $_POST['id_base'] );

        check_ajax_referer( 'megamenu_save_widget_' . $widget_id );

        $saved = $this->save_widget( $id_base );

        if ( $saved ) {
            $this->send_json_success( sprintf( __("Saved %s", "megamenu"), $id_base ) );
        } else {
            $this->send_json_error( sprintf( __("Failed to save %s", "megamenu"), $id_base ) );
        }

    }


    /**
     * Update the number of mega columns for a widget
     *
     * @since 1.0
     */
    public function ajax_update_widget_columns() {

        check_ajax_referer( 'megamenu_edit' );

        $widget_id = sanitize_text_field( $_POST['id'] );
        $columns = absint( $_POST['columns'] );

        $updated = $this->update_widget_columns( $widget_id, $columns );

        if ( $updated ) {
            $this->send_json_success( sprintf( __( "Updated %s (new columns: %d)", "megamenu"), $widget_id, $columns ) );
        } else {
            $this->send_json_error( sprintf( __( "Failed to update %s", "megamenu"), $widget_id ) );
        }

    }


    /**
     * Update the number of mega columns for a widget
     *
     * @since 1.0
     */
    public function ajax_update_menu_item_columns() {

        check_ajax_referer( 'megamenu_edit' );

        $id = absint( $_POST['id'] );
        $columns = absint( $_POST['columns'] );

        $updated = $this->update_menu_item_columns( $id, $columns );

        if ( $updated ) {
            $this->send_json_success( sprintf( __( "Updated %s (new columns: %d)", "megamenu"), $id, $columns ) );
        } else {
            $this->send_json_error( sprintf( __( "Failed to update %s", "megamenu"), $id ) );
        }

    }


    /**
     * Add a widget to the panel
     *
     * @since 1.0
     */
    public function ajax_add_widget() {

        check_ajax_referer( 'megamenu_edit' );

        $id_base = sanitize_text_field( $_POST['id_base'] );
        $menu_item_id = absint( $_POST['menu_item_id'] );
        $title = sanitize_text_field( $_POST['title'] );
        $is_grid_widget = isset( $_POST['is_grid_widget'] ) && $_POST['is_grid_widget'] == 'true';

        $added = $this->add_widget( $id_base, $menu_item_id, $title, $is_grid_widget );

        if ( $added ) {
            $this->send_json_success( $added );
        } else {
            $this->send_json_error( sprintf( __("Failed to add %s to %d", "megamenu"), $id_base, $menu_item_id ) );
        }

    }


    /**
     * Deletes a widget
     *
     * @since 1.0
     */
    public function ajax_delete_widget() {

        check_ajax_referer( 'megamenu_edit' );

        $widget_id = sanitize_text_field( $_POST['widget_id'] );

        $deleted = $this->delete_widget( $widget_id );

        if ( $deleted ) {
            $this->send_json_success( sprintf( __( "Deleted %s", "megamenu"), $widget_id ) );
        } else {
            $this->send_json_error( sprintf( __( "Failed to delete %s", "megamenu"), $widget_id ) );
        }

    }


    /**
     * Moves a widget to a new position
     *
     * @since 1.0
     */
    public function ajax_reorder_items() {

        check_ajax_referer( 'megamenu_edit' );

        $items = isset( $_POST['items'] ) ? $_POST['items'] : false;

        $saved = false;

        if ( $items ) {
            $moved = $this->reorder_items( $items );
        }

        if ( $moved ) {
            $this->send_json_success( sprintf( __( "Moved (%s)", "megamenu"), json_encode( $items ) ) );
        } else {
            $this->send_json_error( sprintf( __( "Didn't move items", "megamenu"), json_encode( $items ) ) );
        }

    }

    /**
     * Moves a widget to a new position
     *
     * @since 2.4
     */
    public function ajax_save_grid_data() {

        check_ajax_referer( 'megamenu_edit' );

        $grid = isset( $_POST['grid'] ) ? $_POST['grid'] : false;
        $parent_menu_item_id = absint( $_POST['parent_menu_item'] );

        $saved = true;

        $existing_settings = get_post_meta( $parent_menu_item_id, '_megamenu', true);

        if ( is_array( $grid ) ) {

            $submitted_settings = array_merge( $existing_settings, array('grid' => $grid ) );

        }

        update_post_meta( $parent_menu_item_id, '_megamenu', $submitted_settings );


        if ( $saved ) {
            $this->send_json_success( sprintf( __( "Saved (%s)", "megamenu"), json_encode( $grid ) ) );
        } else {
            $this->send_json_error( sprintf( __( "Didn't save", "megamenu"), json_encode( $grid ) ) );
        }

    }


    /**
     * Returns an object representing all widgets registered in WordPress
     *
     * @since 1.0
     */
    public function get_available_widgets() {
        global $wp_widget_factory;

        $widgets = array();

        foreach( $wp_widget_factory->widgets as $widget ) {

            $disabled_widgets = array('maxmegamenu');

            $disabled_widgets = apply_filters( "megamenu_incompatible_widgets", $disabled_widgets );

            if ( ! in_array( $widget->id_base, $disabled_widgets ) ) {

                $widgets[] = array(
                    'text' => $widget->name,
                    'value' => $widget->id_base
                );

            }

        }

        uasort( $widgets, array( $this, 'sort_by_text' ) );

        return $widgets;

    }


    /**
     * Sorts a 2d array by the 'text' key
     *
     * @since 1.2
     * @param array $a
     * @param array $b
     */
    function sort_by_text( $a, $b ) {
        return strcmp( $a['text'], $b['text'] );
    }


    /**
     * Sorts a 2d array by the 'order' key
     *
     * @since 2.0
     * @param array $a
     * @param array $b
     */
    function sort_by_order( $a, $b ) {

        if ($a['order'] == $b['order']) {
            return 1;
        }
        return ($a['order'] < $b['order']) ? -1 : 1;

    }


    /**
     * Returns an array of immediate child menu items for the current item
     *
     * @since 1.5
     * @return array
     */
    private function get_second_level_menu_items( $parent_menu_item_id, $menu_id ) {

        $items = array();

        // check we're using a valid menu ID
        if ( ! is_nav_menu( $menu_id ) ) {
            return $items;
        }

        $menu = wp_get_nav_menu_items( $menu_id );

        if ( count( $menu ) ) {

            foreach ( $menu as $item ) {

                // find the child menu items
                if ( $item->menu_item_parent == $parent_menu_item_id ) {

                    $saved_settings = array_filter( (array) get_post_meta( $item->ID, '_megamenu', true ) );

                    $settings = array_merge( Mega_Menu_Nav_Menus::get_menu_item_defaults(), $saved_settings );

                    $items[ $item->ID ] = array(
                        'id' => $item->ID,
                        'type' => 'menu_item',
                        'title' => $item->title,
                        'columns' => $settings['mega_menu_columns'],
                        'order' => isset( $settings['mega_menu_order'][ $parent_menu_item_id ] ) ? $settings['mega_menu_order'][ $parent_menu_item_id ] : 0
                    );

                }

            }

        }

        return $items;
    }

    /**
     * Returns an array of all widgets belonging to a specified menu item ID.
     *
     * @since 1.0
     * @param int $menu_item_id
     */
    public function get_widgets_for_menu_id( $parent_menu_item_id, $menu_id ) {

        $widgets = array();

        if ( $mega_menu_widgets = $this->get_mega_menu_sidebar_widgets() ) {

            foreach ( $mega_menu_widgets as $widget_id ) {

                $settings = $this->get_settings_for_widget_id( $widget_id );

                if ( ! isset( $settings['mega_menu_is_grid_widget'] ) && isset( $settings['mega_menu_parent_menu_id'] ) && $settings['mega_menu_parent_menu_id'] == $parent_menu_item_id ) {

                    $name = $this->get_name_for_widget_id( $widget_id );

                    $widgets[ $widget_id ] = array(
                        'id' => $widget_id,
                        'type' => 'widget',
                        'title' => $name,
                        'columns' => $settings['mega_menu_columns'],
                        'order' => isset( $settings['mega_menu_order'][ $parent_menu_item_id ] ) ? $settings['mega_menu_order'][ $parent_menu_item_id ] : 0
                    );

                }

            }

        }

        return $widgets;

    }


    /**
     * Returns an array of widgets and second level menu items for a specified parent menu item.
     * Used to display the widgets/menu items in the mega menu builder.
     *
     * @since 2.0
     * @param int $parent_menu_item_id
     * @param int $menu_id
     * @return array
     */
    public function get_widgets_and_menu_items_for_menu_id( $parent_menu_item_id, $menu_id ) {

        $menu_items = $this->get_second_level_menu_items( $parent_menu_item_id, $menu_id );

        $widgets = $this->get_widgets_for_menu_id( $parent_menu_item_id, $menu_id );

        $items = array_merge( $menu_items, $widgets );

        $parent_settings = get_post_meta( $parent_menu_item_id, '_megamenu', true );

        $ordering = isset( $parent_settings['submenu_ordering'] ) ? $parent_settings['submenu_ordering'] : 'natural';

        if ( $ordering == 'forced' ) {

            uasort( $items, array( $this, 'sort_by_order' ) );

            $new_items = $items;
            $end_items = array();

            foreach ( $items as $key => $value ) {
                if ( $value['order'] == 0 ) {
                    unset( $new_items[$key] );
                    $end_items[] = $value;
                }
            }

            $items = array_merge( $new_items, $end_items );

        }

        return $items;
    }

    /**
     * Return a sorted array of grid data representing rows, columns and items within each column.
     *
     * @param int $parent_menu_item_id
     * @param int $menu_id
     * @since 2.4
     * @return array
     */
    public function get_grid_widgets_and_menu_items_for_menu_id( $parent_menu_item_id, $menu_id ) {

        $meta = get_post_meta($parent_menu_item_id, '_megamenu', true);

        $saved_grid = array();
        
        if ( isset( $meta['grid'] ) ) {
            $saved_grid = $this->populate_saved_grid_data( $parent_menu_item_id, $menu_id, $meta['grid'] );
        } else {
            // return empty row
            $saved_grid[0]['columns'][0]['meta']['span'] = 3;
            $saved_grid = $this->populate_saved_grid_data( $parent_menu_item_id, $menu_id, $saved_grid );

        }

        return $saved_grid;
    }


    /**
     * Ensure the widgets that are within the grid data still exist and have not been deleted (through the Widgets screen)
     * Ensure second level menu items saved within the grid data are still actually second level menu itms within the menu structure
     *
     * @param $saved_grid - array representing rows, columns and widgets/menu items within each column
     * @param $second_level_menu_items - array of second level menu items beneath the current menu item
     * @since 2.4
     * @return array
     */
    public function populate_saved_grid_data( $parent_menu_item_id, $menu_id, $saved_grid ) {

        $second_level_menu_items = $this->get_second_level_menu_items( $parent_menu_item_id, $menu_id );

        $menu_items_included = array();

        foreach ($saved_grid as $row => $row_data ) {
            if ( isset( $row_data['columns'] ) ) {
                foreach ( $row_data['columns'] as $col => $col_data ) {
                    if ( isset ( $col_data['items'] ) ) {
                        foreach ( $col_data['items'] as $key => $item ) {
                            if ( $item['type'] == 'item' ) {
                                $menu_items_included[] = $item['id'];
                                $is_child_of_parent = false;

                                foreach ( $second_level_menu_items as $menu_item ) {
                                    if ( $menu_item['id'] == $item['id'] ) {
                                        $is_child_of_parent = true;
                                    }
                                }

                                if ( ! $is_child_of_parent ) {
                                    unset( $saved_grid[$row]['columns'][$col]['items'][$key] ); // menu item has been deleted or moved
                                }
                            } else {
                                if ( ! $this->get_name_for_widget_id( $item['id'] ) ) {
                                    unset( $saved_grid[$row]['columns'][$col]['items'][$key] ); // widget no longer exists
                                }
                            }
                        }
                    }
                }
            }
        }

        // Find any second level menu items that have been added to the menu but are not yet within the grid data
        $orphaned_items = array();

        foreach ( $second_level_menu_items as $menu_item ) {
            if ( ! in_array($menu_item['id'], $menu_items_included ) ) {
                $orphaned_items[] = $menu_item;
            }
        }

        if ( ! isset( $saved_grid[0]['columns'][0]['items'][0])) {
            $index = 0; // grid is empty
        } else {
            $index = 999; // create new row
        }

        foreach ($orphaned_items as $key => $menu_item) {
            $saved_grid[$index]['columns'][0]['meta']['span'] = 3;
            $saved_grid[$index]['columns'][0]['items'][$key] = array(
                'id' => $menu_item['id'], 
                'type'=> 'item', 
                'title' => $menu_item['title'],
                'description' => __("Menu Item", "megamenu")
            );
        }

        if ( is_admin() ) {
            $saved_grid = $this->populate_grid_menu_item_titles( $saved_grid, $menu_id );
        }

        return $saved_grid;
    }


    /**
     * Loop through the grid data and apply titles and labels to each menu item and widget.
     *
     * @param array $saved_grid
     * @param int $menu_id
     * @since 2.4
     * @return array
     */
    public function populate_grid_menu_item_titles( $saved_grid, $menu_id ) {

        $menu_items = wp_get_nav_menu_items( $menu_id );

        $menu_item_title_map = array();

        foreach ( $menu_items as $item ) {
            $menu_item_title_map[ $item->ID ] = $item->title;
        }

        foreach ($saved_grid as $row => $row_data ) {
            if ( isset( $row_data['columns'] ) ) {
                foreach ( $row_data['columns'] as $col => $col_data ) {
                    if ( isset ( $col_data['items'] ) ) {
                        foreach ( $col_data['items'] as $key => $item ) {
                            if ( $item['type'] == 'item' ) {
                                
                                if ( isset( $menu_item_title_map[$item['id']] ) ) {
                                    $title = $menu_item_title_map[$item['id']];
                                } else {
                                    $title = __("(no label)");
                                }
                                
                                $saved_grid[$row]['columns'][$col]['items'][$key]['title'] = $title;
                                $saved_grid[$row]['columns'][$col]['items'][$key]['description'] = __("Menu Item", "megamenu");
                            } else {
                                $saved_grid[$row]['columns'][$col]['items'][$key]['title'] = $this->get_title_for_widget_id($item['id']);
                                $saved_grid[$row]['columns'][$col]['items'][$key]['description'] = $this->get_name_for_widget_id($item['id']);
                            }
                        }
                    }
                }
            }
        }

        return $saved_grid;
    }


    /**
     * Returns the widget data as stored in the options table
     *
     * @since 1.8.1
     * @param string $widget_id
     */
    public function get_settings_for_widget_id( $widget_id ) {

        $id_base = $this->get_id_base_for_widget_id( $widget_id );

        if ( ! $id_base ) {
            return false;
        }

        $widget_number = $this->get_widget_number_for_widget_id( $widget_id );

        $current_widgets = get_option( 'widget_' . $id_base );

        return $current_widgets[ $widget_number ];

    }

    /**
     * Returns the widget ID (number)
     *
     * @since 1.0
     * @param string $widget_id - id_base-ID (eg meta-3)
     * @return int
     */
    public function get_widget_number_for_widget_id( $widget_id ) {

        $parts = explode( "-", $widget_id );

        return absint( end( $parts ) );

    }

    /**
     * Returns the name/title of a Widget
     *
     * @since 1.0
     * @param $widget_id - id_base-ID (eg meta-3)
     * @return string e.g. "Custom HTML" or "Text"
     */
    public function get_name_for_widget_id( $widget_id ) {
        global $wp_registered_widgets;

        if ( ! isset( $wp_registered_widgets[$widget_id] ) ) {
            return false;
        }

        $registered_widget = $wp_registered_widgets[$widget_id];

        return $registered_widget['name'];

    }


    /**
     * Returns the title of a Widget
     *
     * @since 2.4
     * @param $widget_id - id_base-ID (eg meta-3)
     */
    public function get_title_for_widget_id( $widget_id ) {
        $instance = $this->get_settings_for_widget_id( $widget_id );

        if ( isset( $instance['title'] ) && strlen( $instance['title'] ) ) {
            return $instance['title'];
        }

        return $this->get_name_for_widget_id( $widget_id );

    }

    /**
     * Returns the id_base value for a Widget ID
     *
     * @since 1.0
     */
    public function get_id_base_for_widget_id( $widget_id ) {
        global $wp_registered_widget_controls;

        if ( ! isset( $wp_registered_widget_controls[ $widget_id ] ) ) {
            return false;
        }

        $control = $wp_registered_widget_controls[ $widget_id ];

        $id_base = isset( $control['id_base'] ) ? $control['id_base'] : $control['id'];

        return $id_base;

    }

    /**
     * Returns the HTML for a single widget instance.
     *
     * @since 1.0
     * @param string widget_id Something like meta-3
     */
    public function show_widget( $id ) {
        global $wp_registered_widgets;

        $params = array_merge(
            array( array_merge( array( 'widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name'] ) ) ),
            (array) $wp_registered_widgets[$id]['params']
        );

        $params[0]['before_title'] = apply_filters( "megamenu_before_widget_title", '<h4 class="mega-block-title">', $wp_registered_widgets[$id] );
        $params[0]['after_title'] = apply_filters( "megamenu_after_widget_title", '</h4>', $wp_registered_widgets[$id] );
        $params[0]['before_widget'] = apply_filters( "megamenu_before_widget", "", $wp_registered_widgets[$id] );
        $params[0]['after_widget'] = apply_filters( "megamenu_after_widget", "", $wp_registered_widgets[$id] );

        $callback = $wp_registered_widgets[$id]['callback'];

        if ( is_callable( $callback ) ) {
            ob_start();
            call_user_func_array( $callback, $params );
            return ob_get_clean();
        }

    }


    /**
     * Returns the class name for a widget instance.
     *
     * @since 1.8.1
     * @param string widget_id Something like meta-3
     */
    public function get_widget_class( $id ) {
        global $wp_registered_widgets;

        if ( isset ( $wp_registered_widgets[$id]['classname'] ) ) {
            return $wp_registered_widgets[$id]['classname'];
        }

        return "";
    }


    /**
     * Shows the widget edit form for the specified widget.
     *
     * @since 1.0
     * @param $widget_id - id_base-ID (eg meta-3)
     */
    public function show_widget_form( $widget_id ) {
        global $wp_registered_widget_controls;

        $control = $wp_registered_widget_controls[ $widget_id ];

        $id_base = $this->get_id_base_for_widget_id( $widget_id );

        $widget_number = $this->get_widget_number_for_widget_id( $widget_id );

        $nonce = wp_create_nonce('megamenu_save_widget_' . $widget_id);

        ?>

        <form method='post'>
            <input type="hidden" name="widget-id" class="widget-id" value="<?php echo esc_attr( $widget_id ); ?>" />
            <input type='hidden' name='action'    value='mm_save_widget' />
            <input type='hidden' name='id_base'   class="id_base" value='<?php echo esc_attr( $id_base ); ?>' />
            <input type='hidden' name='widget_id' value='<?php echo esc_attr( $widget_id ) ?>' />
            <input type='hidden' name='_wpnonce'  value='<?php echo esc_attr( $nonce ) ?>' />
            <div class='widget-content'>
                <?php
                    if ( is_callable( $control['callback'] ) ) {
                        call_user_func_array( $control['callback'], $control['params'] );
                    }
                ?>

                <div class='widget-controls'>
                    <a class='delete' href='#delete'><?php _e("Delete", "megamenu"); ?></a> |
                    <a class='close' href='#close'><?php _e("Close", "megamenu"); ?></a>
                </div>

                <?php
                    submit_button( __( 'Save' ), 'button-primary alignright', 'savewidget', false );
                ?>
            </div>
        </form>
        

        <?php
    }


    /**
     * Saves a widget. Calls the update callback on the widget.
     * The callback inspects the post values and updates all widget instances which match the base ID.
     *
     * @since 1.0
     * @param string $id_base - e.g. 'meta'
     * @return bool
     */
    public function save_widget( $id_base ) {
        global $wp_registered_widget_updates;

        $control = $wp_registered_widget_updates[$id_base];

        if ( is_callable( $control['callback'] ) ) {

            call_user_func_array( $control['callback'], $control['params'] );

            do_action( "megamenu_after_widget_save" );

            return true;
        }

        return false;

    }


    /**
     * Adds a widget to WordPress. First creates a new widget instance, then
     * adds the widget instance to the mega menu widget sidebar area.
     *
     * @since 1.0
     * @param string $id_base
     * @param int $menu_item_id
     * @param string $title
     */
    public function add_widget( $id_base, $menu_item_id, $title, $is_grid_widget ) {

        require_once( ABSPATH . 'wp-admin/includes/widgets.php' );

        $next_id = next_widget_id_number( $id_base );

        $this->add_widget_instance( $id_base, $next_id, $menu_item_id, $is_grid_widget );

        $widget_id = $this->add_widget_to_sidebar( $id_base, $next_id );

        $return  = '<div class="widget" title="' . esc_attr( $title ) . '" data-columns="2" id="' . $widget_id . '" data-type="widget" data-id="' . $widget_id . '">';
        $return .= '    <div class="widget-top">';
        $return .= '        <div class="widget-title-action">';

        if ( ! $is_grid_widget ) {
            $return .= '            <a class="widget-option widget-contract" title="' . esc_attr( __("Contract", "megamenu") ) . '"></a>';
            $return .= '            <span class="widget-cols"><span class="widget-num-cols">2</span><span class="widget-of">/</span><span class="widget-total-cols">X</span></span>';
            $return .= '            <a class="widget-option widget-expand" title="' . esc_attr( __("Expand", "megamenu") ) . '"></a>';
        }

        $return .= '            <a class="widget-option widget-action" title="' . esc_attr( __("Edit", "megamenu") ) . '"></a>';
        $return .= '        </div>';
        $return .= '        <div class="widget-title">';
        $return .= '            <h4>' . esc_html( $title ) . '</h4>';
        
        if ( $is_grid_widget ) {
            $return .= '            <span class="widget-desc">' .  esc_html( $title ) . '</span>';
        }

        $return .= '        </div>';
        $return .= '    </div>';
        $return .= '    <div class="widget-inner widget-inside"></div>';
        $return .= '</div>';

        return $return;

    }


    /**
     * Adds a new widget instance of the specified base ID to the database.
     *
     * @since 1.0
     * @param string $id_base
     * @param int $next_id
     * @param int $menu_item_id
     */
    private function add_widget_instance( $id_base, $next_id, $menu_item_id, $is_grid_widget ) {

        $current_widgets = get_option( 'widget_' . $id_base );

        $current_widgets[ $next_id ] = array(
            "mega_menu_columns" => 2,
            "mega_menu_parent_menu_id" => $menu_item_id
        );

        if ( $is_grid_widget ) {
            $current_widgets[ $next_id ] = array(
                "mega_menu_is_grid_widget" => 'true'
            );
        }

        update_option( 'widget_' . $id_base, $current_widgets );

    }

    /**
     * Removes a widget instance from the database
     *
     * @since 1.0
     * @param string $widget_id e.g. meta-3
     * @return bool. True if widget has been deleted.
     */
    private function remove_widget_instance( $widget_id ) {

        $id_base = $this->get_id_base_for_widget_id( $widget_id );
        $widget_number = $this->get_widget_number_for_widget_id( $widget_id );

        // add blank widget
        $current_widgets = get_option( 'widget_' . $id_base );

        if ( isset( $current_widgets[ $widget_number ] ) ) {

            unset( $current_widgets[ $widget_number ] );

            update_option( 'widget_' . $id_base, $current_widgets );

            return true;

        }

        return false;

    }


    /**
     * Updates the number of mega columns for a specified widget.
     *
     * @since 1.0
     * @param string $widget_id
     * @param int $columns
     */
    public function update_widget_columns( $widget_id, $columns ) {

        $id_base = $this->get_id_base_for_widget_id( $widget_id );

        $widget_number = $this->get_widget_number_for_widget_id( $widget_id );

        $current_widgets = get_option( 'widget_' . $id_base );

        $current_widgets[ $widget_number ]["mega_menu_columns"] = absint( $columns) ;

        update_option( 'widget_' . $id_base, $current_widgets );

        do_action( "megamenu_after_widget_save" );

        return true;

    }


    /**
     * Updates the number of mega columns for a specified widget.
     *
     * @since 1.10
     * @param string $menu_item_id
     * @param int $columns
     */
    public function update_menu_item_columns( $menu_item_id, $columns ) {

        $settings = get_post_meta( $menu_item_id, '_megamenu', true);

        $settings['mega_menu_columns'] = absint( $columns );

        update_post_meta( $menu_item_id, '_megamenu', $settings );

        return true;

    }


    /**
     * Updates the order of a specified widget.
     *
     * @since 1.10
     * @param string $widget_id
     * @param int $columns
     */
    public function update_widget_order( $widget_id, $order, $parent_menu_item_id ) {

        $id_base = $this->get_id_base_for_widget_id( $widget_id );

        $widget_number = $this->get_widget_number_for_widget_id( $widget_id );

        $current_widgets = get_option( 'widget_' . $id_base );

        $current_widgets[ $widget_number ]["mega_menu_order"] = array( $parent_menu_item_id => absint( $order ) );

        update_option( 'widget_' . $id_base, $current_widgets );

        return true;

    }


    /**
     * Updates the order of a specified menu item.
     *
     * @since 1.10
     * @param string $menu_item_id
     * @param int $order
     */
    public function update_menu_item_order( $menu_item_id, $order, $parent_menu_item_id ) {

        $submitted_settings['mega_menu_order'] = array( $parent_menu_item_id => absint( $order ) );

        $existing_settings = get_post_meta( $menu_item_id, '_megamenu', true);

        if ( is_array( $existing_settings ) ) {

            $submitted_settings = array_merge( $existing_settings, $submitted_settings );

        }

        update_post_meta( $menu_item_id, '_megamenu', $submitted_settings );

        return true;

    }


    /**
     * Deletes a widget from WordPress
     *
     * @since 1.0
     * @param string $widget_id e.g. meta-3
     */
    public function delete_widget( $widget_id ) {

        $this->remove_widget_from_sidebar( $widget_id );
        $this->remove_widget_instance( $widget_id );

        do_action( "megamenu_after_widget_delete" );

        return true;

    }


    /**
     * Moves a widget from one position to another.
     *
     * @since 1.10
     * @param array $items
     * @return string $widget_id. The widget that has been moved.
     */
    public function reorder_items( $items ) {

        foreach ( $items as $item ) {

            if ( $item['parent_menu_item'] ) {

                $submitted_settings = array( 'submenu_ordering' => 'forced' );

                $existing_settings = get_post_meta( $item['parent_menu_item'], '_megamenu', true );

                if ( is_array( $existing_settings ) ) {

                    $submitted_settings = array_merge( $existing_settings, $submitted_settings );

                }

                update_post_meta( $item['parent_menu_item'], '_megamenu', $submitted_settings );
            }

            if ( $item['type'] == 'widget' ) {

                $this->update_widget_order( $item['id'], $item['order'], $item['parent_menu_item'] );

            }

            if ( $item['type'] == 'menu_item' ) {

                $this->update_menu_item_order( $item['id'], $item['order'], $item['parent_menu_item'] );

            }

        }

        return true;

    }


    /**
     * Adds a widget to the Mega Menu widget sidebar
     *
     * @since 1.0
     */
    private function add_widget_to_sidebar( $id_base, $next_id ) {

        $widget_id = $id_base . '-' . $next_id;

        $sidebar_widgets = $this->get_mega_menu_sidebar_widgets();

        $sidebar_widgets[] = $widget_id;

        $this->set_mega_menu_sidebar_widgets($sidebar_widgets);

        do_action( "megamenu_after_widget_add" );

        return $widget_id;

    }


    /**
     * Removes a widget from the Mega Menu widget sidebar
     *
     * @since 1.0
     * @return string The widget that was removed
     */
    private function remove_widget_from_sidebar($widget_id) {

        $widgets = $this->get_mega_menu_sidebar_widgets();

        $new_mega_menu_widgets = array();

        foreach ( $widgets as $widget ) {

            if ( $widget != $widget_id )
                $new_mega_menu_widgets[] = $widget;

        }

        $this->set_mega_menu_sidebar_widgets($new_mega_menu_widgets);

        return $widget_id;

    }


    /**
     * Returns an unfiltered array of all widgets in our sidebar
     *
     * @since 1.0
     * @return array
     */
    public function get_mega_menu_sidebar_widgets() {

        $sidebar_widgets = wp_get_sidebars_widgets();

        if ( ! isset( $sidebar_widgets[ 'mega-menu'] ) ) {
            return false;
        }

        return $sidebar_widgets[ 'mega-menu' ];

    }


    /**
     * Sets the sidebar widgets
     *
     * @since 1.0
     */
    private function set_mega_menu_sidebar_widgets( $widgets ) {

        $sidebar_widgets = wp_get_sidebars_widgets();

        $sidebar_widgets[ 'mega-menu' ] = $widgets;

        wp_set_sidebars_widgets( $sidebar_widgets );

    }


    /**
     * Clear the cache when the Mega Menu is updated.
     *
     * @since 1.0
     */
    public function clear_caches() {

        // https://wordpress.org/plugins/widget-output-cache/
        if ( function_exists( 'menu_output_cache_bump' ) ) {
            menu_output_cache_bump();
        }

        // https://wordpress.org/plugins/widget-output-cache/
        if ( function_exists( 'widget_output_cache_bump' ) ) {
            widget_output_cache_bump();
        }

    }


    /**
     * Send JSON response.
     *
     * Remove any warnings or output from other plugins which may corrupt the response
     *
     * @param string $json
     * @since 1.8
     */
    public function send_json_success( $json ) {
        if ( ob_get_contents() ) ob_clean();

        wp_send_json_success( $json );
    }


    /**
     * Send JSON response.
     *
     * Remove any warnings or output from other plugins which may corrupt the response
     *
     * @param string $json
     * @since 1.8
     */
    public function send_json_error( $json ) {
        if ( ob_get_contents() ) ob_clean();

        wp_send_json_error( $json );
    }

}

endif;