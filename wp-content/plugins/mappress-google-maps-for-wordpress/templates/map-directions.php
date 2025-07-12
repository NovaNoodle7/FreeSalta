<div class='mapp-directions'>
	<span class='mapp-close' data-mapp-action='dir-cancel'></span>
	<?php if (Mappress::ssl()) : ?>
		<a href='#' class='mapp-myloc' data-mapp-action='dir-myloc'><?php _e('My location', 'mappress-google-maps-for-wordpress'); ?></a>
	<?php endif; ?>
	<div>
		<span class='mapp-dir-a'></span>
		<input class='mapp-dir-saddr' tabindex='1'/>
		<span data-mapp-action='dir-swap' class='mapp-dir-arrows'></span>
	</div>

	<div>
		<span class='mapp-dir-b'></span>
		<input class='mapp-dir-daddr' tabindex='2'/>
	</div>

	<div class='mapp-dir-toolbar'>
		<a class='mapp-dir-google' href='#' data-mapp-action='dir-google'><?php esc_html_e('Google Maps', 'mappress-google-maps-for-wordpress'); ?></a>
		<span class='mapp-button-submit' data-mapp-action='dir-get'><?php esc_html_e('Get Directions', 'mappress-google-maps-for-wordpress'); ?></span>
		<span class='mapp-spinner'></span>
	</div>
	<div class='mapp-dir-renderer'></div>
</div>