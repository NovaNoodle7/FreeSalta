<div class='mapp-list'>
	<div class='mapp-items'>
	<?php foreach($map->pois as $i => $poi) : ?>
		<?php if ($poi->type == 'kml') continue; ?>
		<div class='mapp-item' data-mapp-action='open' data-mapp-poi='<?php echo $i;?>'>
			<div class="mapp-icon"><?php echo $poi->part('icon');?></div>
			<div class='mapp-title'><?php echo $poi->part('title');?></div>
		</div>
	<?php endforeach; ?>
	</div>
</div>