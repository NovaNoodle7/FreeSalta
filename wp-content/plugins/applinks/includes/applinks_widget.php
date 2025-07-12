<?php
 
class applinks_widget extends WP_Widget {
 
 	private $include_path = '';

    function applinks_widget(){
        // Constructor del Widget.
         $widget_ops = array('classname' => 'applinks_widget', 'description' => "Widget para agregar inks para descargar App" );
         //$this->include_path = untrailingslashit( plugin_dir_path( WC_PLUGIN_FILE ) ) . '/includes/';
        $this->WP_Widget('applinks_widget', "App Links Widget", $widget_ops);
    }
 
    function widget($args,$instance){
        // Contenido del Widget que se mostrará en la Sidebar
        echo $before_widget;    
        
        echo '<style>
        .applink_widget .column-links .icon-link.google-play{
    			background-image: url("../images/google_play.png");
        }
    	</style>';
    	?>
        <aside id='mpw_widget' class='widget applink_widget'>
            <h3 class="column-title">Descargate la app GRATIS</h3>
	        <ul class="column-links">
	           <!-- <li class="column-item"><a class="icon-link app-store es" target="_blank" href="https://176344.measurementapi.com/serve?action=click&amp;publisher_id=176344&amp;site_id=108054&amp;my_campaign=Footer-Web&amp;my_site=iOS" title="Descargar OLX para IOS" rel="nofollow">Descargar FreeSalta para IOS</a></li>-->
	            <li class="column-item"><a class="icon-link google-play es" target="_blank" href="https://176344.measurementapi.com/serve?action=click&amp;publisher_id=176344&amp;site_id=108058&amp;my_campaign=Footer-Web&amp;my_site=Android" title="Descargar OLX para Android" rel="nofollow">Descargar FreeSalta para Android</a></li>
	        </ul>
        </aside>
        <?php
        echo $after_widget;
    }
 
    function update($new_instance, $old_instance){
        // Función de guardado de opciones   
    }
 
    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
    }    
} 
 
?>