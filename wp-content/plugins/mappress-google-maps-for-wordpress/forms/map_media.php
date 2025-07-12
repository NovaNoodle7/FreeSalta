<div class='mapp-m-panel'>
	<?php echo Mappress::get_support_links(); ?>
	<div id='mapp_m_list_panel' style='display:none'>
		<b><?php _e('Maps for This Post', 'mappress-google-maps-for-wordpress')?></b>
		<input class='button' type='button' id='mapp_m_add_map' value='<?php esc_attr_e('New Map', 'mappress-google-maps-for-wordpress')?>' />
		<div id='mapp_m_maplist'>
			<?php echo Mappress_Map::get_map_list(); ?>
		</div>
	</div>

	<div id='mapp_m_edit_panel' style='display:none'>
		<table class='mapp-settings'>
			<tr>
				<td><?php _e('Map ID', 'mappress-google-maps-for-wordpress');?>:</td>
				<td><span id='mapp_m_mapid'></span></td>
			</tr>

			<tr>
				<td><?php _e('Map Title', 'mappress-google-maps-for-wordpress');?>:</td>
				<td><input id='mapp_m_title' type='text' size='40' placeholder='<?php _e('Untitled', 'mappress-google-maps-for-wordpress');?>' /></td>
			</tr>

			<tr>
				<td><?php _e('Display Size', 'mappress-google-maps-for-wordpress');?>:</td>
				<td>
					<?php
						$sizes = array();
						foreach(Mappress::$options->sizes as $i => $size)
							$sizes[] = "<a href='#' class='mapp-m-size' data-width='{$size['width']}' data-height='{$size['height']}'>" . $size['width'] . 'x' . $size['height'] . "</a>";
						echo implode(' | ', $sizes);
					?>
					<input type='text' id='mapp_m_width' size='2' value='' /> x <input type='text' id='mapp_m_height' size='2' value='' />
				</td>
			</tr>
		</table>
		<div>
			<input class='button button-primary' type='button' id='mapp_m_save' value='<?php esc_attr_e('Save', 'mappress-google-maps-for-wordpress'); ?>' />
			<input class='button' type='button' id='mapp_m_cancel' value='<?php esc_attr_e('Cancel', 'mappress-google-maps-for-wordpress'); ?>' />
			<input class='button' type='button' id='mapp_m_insert' value='<?php esc_attr_e('Insert into post', 'mappress-google-maps-for-wordpress'); ?>' />
		</div>
		<?php require Mappress::$basedir . "/forms/map_editor.php"; ?>
	</div>
</div>