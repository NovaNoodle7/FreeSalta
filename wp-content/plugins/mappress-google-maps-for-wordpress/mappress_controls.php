<?php
/**
* Generic HTML controls
*/
class Mappress_Controls {

	static function parse_atts($name, $args = '') {
		$args = empty($args) ? array() : $args;

		// Include name if set
		$atts = (empty($name)) ? '' : "name='" . esc_attr($name) . "'";

		foreach($args as $key => $value) {
			// Attributes with value
			if (isset($value) && in_array($key, array('class', 'id', 'maxlength', 'multiple', 'onclick', 'rows', 'size', 'style', 'title', 'type')))
				$atts .= " $key='" . esc_attr($value) . "' ";

			// Boolean attributes
			if (in_array($key, array('checked', 'disabled', 'multiple', 'readonly', 'selected')) && $value)
				if (!empty($value))
					$atts .= " $key ";

			// Data (not escaped)
			if (substr($key, 0, 4) == 'data')
				$atts .= " $key='$value' ";
		}

		return $atts;
	}

	static function button($name, $label, $args = '') {
		$args = (object) wp_parse_args($args, array('class' => '', 'type' => 'button'));
		$args->class = 'button ' . $args->class;
		$atts = self::parse_atts($name, $args);;
		$label = esc_attr($label);
		$html = "<input value='$label' $atts />";
		return $html;
	}

	// Boolean checkbox
	static function checkmark($name, $value, $label = '', $args = '') {
		$atts = self::parse_atts($name, $args);
		return "<input type='hidden' name='$name' value='false' /><label><input type='checkbox' value='true' " . checked($value, true, false) . " $atts />$label</label> ";
	}

	// Checkbox
	static function checkbox($name, $value, $checked, $label = '', $args = '') {
		$args = (object) wp_parse_args($args, array('checked' => ''));
		$args->checked = (is_array($checked)) ? in_array($value, $checked) : $value == $checked;
		$atts = self::parse_atts($name, $args);
		return "<label><input type='checkbox' value='" . esc_attr($value) . "' $atts />$label</label> ";
	}

	// Checkbox list
	static function checkboxes($name, $labels, $selected = null, $args = '') {
		$selected = ($selected) ? $selected : array();
		$name .= '[]';

		$html = "";
		foreach ($labels as $value => $label)
			$html .= self::checkbox($name, $value, in_array($value, $selected), $label, $args);
		return $html;
	}

	static function grid($headers, $rows, $args = '') {
		$atts = (object) wp_parse_args($args, array('style' => (count($rows) < 2) ? 'display:none' : null));
		$atts = self::parse_atts(null, $atts);

		// Prefix sortable rows with a drag icon
		$sortable = (isset($args['sortable']) && $args['sortable']);

		// Add a sortable header column
		if ($sortable)
			array_unshift($headers, '');

		// Add an action header column
		$headers[] = '';

		$html = "<div data-mapp-grid class='mapp-grid'>";
		$html .= "<table $atts>";
		$html .= "<thead>" . self::table_row($headers, 'th') . "</thead>";
		$html .= "<tbody>";

		foreach($rows as $i => $row) {
			// Grab the last (presumably blank) row as a template
			if ($i == count($rows) - 1)
				$template = self::grid_row($row, $sortable);
			else
				$html .= self::grid_row($row, $sortable);
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "<button type='button' class='button' data-mapp-action='add'>" . __('Add', 'mappress-google-maps-for-wordpress') . "</button>";
		$html .= Mappress::script_template($template);
		$html .= "</div>";
		return $html;
	}

	static function grid_row($row, $sortable) {
		if ($sortable)
			array_unshift($row, '<span class="mapp-handle dashicons dashicons-menu"></span>');
		$row[] = "<span data-mapp-action='remove' class='mapp-close' title='" . __('Delete', 'mappress-google-maps-for-wordpress') . "'></span>";
		return self::table_row($row);
	}

	static function input($name, $value, $args = '') {
		$args = (object) wp_parse_args($args, array('label' => '', 'type' => 'text'));
		$atts = self::parse_atts($name, $args);
		$value = esc_attr($value);
		return "<label><input $atts value='$value' /> {$args->label}</label>";
	}

	static function radios($name, $data, $selected = null, $args = '') {
		$atts = self::parse_atts($name, $args);
		$html = "";
		foreach ((array)$data as $key => $label) {
			$key = esc_attr($key);
			$html .= "<label><input type='radio' value='$key' " . checked($selected, $key, false) . " $atts />$label</label> ";
		}
		return $html;
	}

	static function select($name, $data, $selected = '', $args = '') {
		$args = (object) wp_parse_args($args, array('none' => false));
		$atts = self::parse_atts($name, $args);

		if (!is_array($data) || empty($data))
			$data = array();

		if ($args->none) {
			$none = ($args->none === true) ? '&nbsp;' : $args->none;
			$data = array('' => $none) + $data;
		}

		$html = "\r\n<select $atts>\r\n";
		foreach ((array)$data as $key => $label) {
			if (substr($key, 0, 8) == 'optgroup') {
				$html .= "<optgroup label='" . esc_attr($label) . "'>";
				continue;
			}
			$select = (is_array($selected)) ? in_array($key, $selected) : $key === $selected;
			$select = ($select) ? 'selected' : '';

			$value = esc_attr($key);
			$label = esc_attr($label);
			$html .= "<option value='$value' title='$label' $select>$label</option>\r\n";
		}
		$html .= "</select>\r\n";
		return $html;
	}

	static function icon_picker($name = '', $value = '', $args = '') {
		$atts = self::parse_atts($name, $args);
		$name = esc_attr($name);
		$iconid = esc_attr($value);
		$icon = Mappress_Icons::get($value);
		$html = "<img class='mapp-icon' data-mapp-iconpicker data-mapp-iconid='$iconid' tabindex='0' src='$icon'><input type='hidden' name='$name' value='$iconid' $atts />";
		return $html;
	}

	static function table($headers, $rows, $args = '') {
		$atts = self::parse_atts(null, $args);

		$html = "<table $atts>";
		$html .= "<thead>" . self::table_row($headers, 'th') . "</thead>";
		$html .= "<tbody>";
		foreach($rows as $row)
			$html .= self::table_row($row);
		$html .= "</tbody>";
		$html .= "</table>";
		return $html;
	}

	static function table_row($row, $tag = 'td') {
		$html = "<tr>";
		foreach($row as $col)
			$html .= "<$tag>$col</$tag>";
		$html .= "</tr>";
		return $html;
	}

	static function get_meta_keys() {
		global $wpdb;
		$keys = $wpdb->get_col( "
			SELECT DISTINCT meta_key
			FROM $wpdb->postmeta
			WHERE meta_key NOT in ('_edit_last', '_edit_lock', '_encloseme', '_pingme', '_thumbnail_id')
			AND meta_key NOT LIKE ('\_wp%')"
		);
		$results = (is_array($keys) && !empty($keys)) ? array_combine($keys, $keys) : array();
		return $results;
	}

	static function get_meta_values($meta_key) {
		global $wpdb;
		$sql = "SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value != '' ORDER BY meta_value";
		$meta_values = $wpdb->get_col($wpdb->prepare($sql, $this->key));
		$results = ($meta_values) ? array_combine($meta_values, $meta_values) : array();
		return $results;
	}

	static function get_post_types() {
		$results = array();
		$post_types = get_post_types(array('show_ui' => true), 'objects');
		unset($post_types['mappress_map'], $post_types['attachment']);
		foreach($post_types as $type => $obj)
			$results[$type] = $obj->label;
		return $results;
	}

	static function get_taxonomies() {
		$results = array();
		$tax_objs = get_taxonomies(array('public' => true), 'objects');
		unset($tax_objs['post_format']);
		foreach($tax_objs as $tax_obj)
			$results[$tax_obj->name] = $tax_obj->label;
		return $results;
	}

	static function get_terms($taxonomy) {
		$results = array();
		$terms = get_terms($taxonomy, array('hide_empty' => false, 'exclude' => 1));
		if (is_array($terms)) {
			$walker = new Mappress_Walker();
			$walk = $walker->walk($terms, 0, array('indent' => true));
			if (is_array($walk))
				$results = $walk;
		}
		return $results;
	}
}

/**
* Walker for taxonomy values.
* Call with array of terms objects: $walker->walk($terms, 0);
* Returns array of (term slug => name)
*/
class Mappress_Walker extends Walker {
	public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
	function start_el( &$output, $term, $depth = 0, $args = array(), $id = 0 ) {
		if (!is_array($output))
			$output = array();

		// If 'indent' set, use spaces (for hierarchical lists like taxonomies)
		$indent = (isset($args['indent']) && $args['indent']) ? str_repeat('&mdash;', $depth) : '';
		$output[$term->slug] = $indent . $term->slug;
	}
}
?>