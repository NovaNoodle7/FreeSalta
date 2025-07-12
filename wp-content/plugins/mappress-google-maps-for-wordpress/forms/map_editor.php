<div class='mapp-edit'>
	<div class='mapp-table mapp-searchbox'>
		<div>
			<div class='mapp-max'>
				<input style='width:100%' type='text' id='mapp_e_saddr' placeholder='<?php _e('Add POI', 'mappress-google-maps-for-wordpress'); ?>'/>
			</div>
			<div>
				<button id='mapp_e_search' class='button button-primary mapp-search-button'></button>
			</div>
			<?php if (Mappress::ssl()) : ?>
			<div>
				<button id='mapp_e_myloc' class='button mapp-geolocate-button' title='<?php _e('My location', 'mappress-google-maps-for-wordpress');?>'></button>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div id='mapp_e_saddr_err' style='display:none'></div>

	<?php echo $map->display(); ?>
</div>


<script type='text/template' id='mapp-tmpl-poi-edit'>
<div class='mapp-poi-edit'>
	<div class='mapp-table'>
		<div>
			<div><input class='mapp-poi-title' type='text' value='{{poi.title}}'></div>
			<# if (!poi.type) { #>
				<div><img data-mapp-iconpicker data-mapp-iconid='{{{poi.iconid}}}' class='mapp-icon'></div>
			<# } else if (poi.isPoly()) { #>
				<div><span data-mapp-colorpicker class='mapp-colorpicker-toggle' data-mapp-color='{{{colors.color}}}' data-mapp-opacity='{{{colors.opacity}}}' data-mapp-weight='{{{colors.weight}}}' tabindex='0'></span></div>
			<# } #>
		</div>
	</div>

	<# if (poi.type == 'kml') { #>
		<div class='mapp-poi-kml'>
			<input class='mapp-poi-url' type='text' readonly='readonly' value='<# print( (poi.kml) ? poi.kml.url : '' );#>'/>
		</div>
	<# } #>

	<div>
		<a data-mapp-action='poi-visual'><?php _e('Visual', 'mappress-google-maps-for-wordpress'); ?></a> | <a data-mapp-action='poi-html'><?php _e('HTML', 'mappress-google-maps-for-wordpress');?></a>
	</div>

	<textarea id='mapp-poi-body' class='mapp-poi-body' rows='10'>{{ poi.body }}</textarea>

	<div class='mapp-poi-toolbar'>
		<button data-mapp-action='poi-save' class='button button-primary'><?php _e('Save', 'mappress-google-maps-for-wordpress'); ?></button>
		<button data-mapp-action='poi-cancel' class='button'><?php _e('Cancel', 'mappress-google-maps-for-wordpress'); ?></button>
		<a href='#' data-mapp-action='poi-remove'><?php _e('Delete', 'mappress-google-maps-for-wordpress');?></a>
	</div>
</div>
</script>

<script type='text/template' id='mapp-tmpl-poi-list'>
	<div class='mapp-items'>
	<# _.forEach(pois, function(poi, i) { #>
		<div class='mapp-item' data-mapp-action='open' data-mapp-poi='{{{i}}}'>
			<img class='mapp-icon' src='<# print(mapp.Icons.getUrl(poi.iconid)); #>'>
			<div class='mapp-title'>{{poi.title}}</div>
		</div>
	<# }); #>
</script>