<?php 
	if(is_page()){
		get_template_part('template-parts/content','page');
	}elseif(is_single()){
		get_template_part('template-parts/content','single');
	}else{
		get_template_part( 'template-parts/content', 'index' );
	}
?>
