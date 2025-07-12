<div id="<?php echo $map->name; ?>" class='<?php echo $map->part('layout-class');?>' style='<?php echo $map->part('layout-style');?>' >
	<?php echo $map->part('header'); ?>
	<div class='mapp-wrapper' style='<?php echo $map->part('wrapper-style');?>' >
		<div class='mapp-main'>
			<?php echo $map->part('list-left'); ?>
			<div class="mapp-canvas"></div>
			<div class="mapp-dialog"><span class="mapp-spinner"></span><?php echo __('Loading', 'mappress-google-maps-for-wordpress'); ?></div>
			<?php echo $map->part('filters'); ?>
			<?php echo $map->part('controls'); ?>
		</div>
	</div>
	<?php echo $map->part('directions'); ?>
	<?php echo $map->part('list-inline'); ?>
</div>
