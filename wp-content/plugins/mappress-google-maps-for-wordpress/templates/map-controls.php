<div class='mapp-controls'>
	<div data-mapp-position="TOP_LEFT" class='gmnoprint mapp-menu-toggle' data-mapp-action='menu-toggle' title='<?php _e('Menu', 'mappress-google-maps-for-wordpress');?>'></div>
	<div data-mapp-position="TOP_LEFT" class='gmnoprint mapp-menu'>
		<?php if ($map->editable) : ?>
			<div class='mapp-menu-item' data-mapp-action='viewport-set'><?php _e('Set center/zoom', 'mappress-google-maps-for-wordpress');?></div>
			<div class='mapp-menu-item mapp-active' data-mapp-action='viewport-reset'><?php _e('Clear center/zoom', 'mappress-google-maps-for-wordpress');?></div>
			<div class='mapp-menu-separator'></div>
		<?php endif; ?>

		<div class='mapp-menu-item' data-mapp-action='center'><?php _e('Center map', 'mappress-google-maps-for-wordpress');?></div>

		<div class='mapp-menu-separator'></div>
		<div class='mapp-menu-item' data-mapp-action='layer' data-mapp-layer='traffic'><?php _e('Traffic', 'mappress-google-maps-for-wordpress');?></div>
		<div class='mapp-menu-item' data-mapp-action='layer' data-mapp-layer='bicycling'><?php _e('Bicycling', 'mappress-google-maps-for-wordpress');?></div>
		<div class='mapp-menu-item' data-mapp-action='layer' data-mapp-layer='transit'><?php _e('Transit', 'mappress-google-maps-for-wordpress');?></div>
	</div>
</div>