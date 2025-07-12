<?php
class storeone_nav_walker extends Walker_Nav_Menu {

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';

		$classes   = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		if ($args->has_children && $depth > 0) {
			$classes[] = 'dropdown dropdown-submenu';
		} else if ($args->has_children && $depth === 0) {
			$classes[] = 'dropdown';
		}
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= ($args->has_children) ? '<div class="mobi-clk"><i class="caret"></i></div></a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

		if (!$element) {
			return;
		}

		$id_field = $this->db_fields['id'];

		//display this element
		if (is_array($args[0])) {
			$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
		} else if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}

		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {

			foreach ($children_elements[$id] as $child) {

				if (!isset($newlevel)) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
			}
			unset($children_elements[$id]);
		}

		if (isset($newlevel) && $newlevel) {
			//end the child delimiter
			$cb_args = array_merge(array(&$output, $depth), $args);
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}
	
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			extract( $args );
			$fb_output = null;
			if ( $container ) {
				$fb_output = '<' . $container;
				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';
				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';
			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';
			$fb_output .= '>';
			$fb_output .= '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'storeone' ) . '</a></li>';
			$fb_output .= '</ul>';
			if ( $container )
				$fb_output .= '</' . $container . '>';
			echo $fb_output;
		}
	}

}

function storeone_nav_menu_css_class($classes) {
	if (in_array('current-menu-item', $classes) OR in_array('current-menu-ancestor', $classes) OR in_array('menu-item-language-current', $classes)) {
		$classes[] = 'active';
	}

	return $classes;
}
add_filter('nav_menu_css_class', 'storeone_nav_menu_css_class');

function storeone_fallback_page_menu($args = array()) {

	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'nav navbar-nav navbar-right', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args     = wp_parse_args($args, $defaults);
	$args     = apply_filters('wp_page_menu_args', $args);

	$menu = '';

	$list_args = $args;

	// Show Home in the menu
	if (!empty($args['show_home'])) {
		if (true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home']) {
			$text = __('Home', 'storeone');
		} else {
			$text = $args['show_home'];
		}

		$class = '';
		if (is_front_page() && !is_paged()) {
			$class = 'class="current-menu-item active"';
		}

		$menu .= '<li ' . $class . '><a href="' . esc_url(home_url('/')) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if (!empty($list_args['exclude'])) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}

	$list_args['echo']     = false;
	$list_args['title_li'] = '';
	$list_args['walker']   = new storeone_walker_page_menu;
	$menu .= str_replace(array("\r", "\n", "\t"), '', wp_list_pages($list_args));

	if ($menu) {
		$menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';
	}

	$menu = '<div id="' . esc_attr($args['container_id']) . '" class="' . esc_attr($args['container_class']) . '">' . $menu . "</div>\n";
	$menu = apply_filters('wp_page_menu', $menu, $args);
	if ($args['echo']) {
		echo $menu;
	} else {
		return $menu;
	}

}

function storeone_page_menu_args($args) {
	if (!isset($args['show_home'])) {
		$args['show_home'] = true;
	}

	return $args;
}
add_filter('wp_page_menu_args', 'storeone_page_menu_args');

class storeone_walker_page_menu extends Walker_Page {
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='dropdown-menu'>\n";
	}
	function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {
		if ($depth) {
			$indent = str_repeat("\t", $depth);
		} else {
			$indent = '';
		}

		extract($args, EXTR_SKIP);
		$css_class = array('menu-item', 'menu-item-' . $page->ID);
		$caret ='';
		if ($args['has_children'] && $depth > 0) {
			$css_class[] = 'dropdown dropdown-submenu';
			$caret = '<div class="mobi-clk"><i class="caret"></i></div>';
		} else if ($args['has_children'] && $depth === 0) {
			$css_class[] = 'dropdown';
			$caret = '<div class="mobi-clk"><i class="caret"></i></div>';
		}
		if (!empty($current_page)) {
			$_current_page = get_post($current_page);
			if (in_array($page->ID, $_current_page->ancestors)) {
				$css_class[] = 'current-menu-ancestor';
			}

			if ($page->ID == $current_page) {
				$css_class[] = 'current-menu-item active';
			} elseif ($_current_page && $page->ID == $_current_page->post_parent) {
				$css_class[] = 'current-menu-parent';
			}

		} elseif ($page->ID == get_option('page_for_posts')) {
			$css_class[] = 'current-menu-parent';
		}

		$css_class = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

		$output .= $indent . '<li id=" ' . esc_attr('menu-item-' . $page->ID) . ' " class="' . esc_attr($css_class) . '"><a href="' . esc_url(get_permalink($page->ID)) . '">' . $link_before . apply_filters('the_title', $page->post_title, $page->ID) . $caret. $link_after . '</a>';

		if (!empty($show_date)) {
			if ('modified' == $show_date) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$output .= " " . mysql2date($date_format, $time);
		}
	}
}
