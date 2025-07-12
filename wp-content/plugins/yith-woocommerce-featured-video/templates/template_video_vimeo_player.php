<?php
if( !defined( 'ABSPATH' ) )
    exit;
global $post;
$src =  $atts['url'];
$http = is_ssl() ? 'https' : 'http';
list( $video_type, $video_id ) = explode( ':', ywcfav_video_type_by_url( $src ) );


$aspect_ratio = get_option( 'ywcfav_aspectratio' );
$aspect_ratio = explode( '_', $aspect_ratio );
$width_ratio  = $aspect_ratio[0];
$height_ratio = $aspect_ratio[1];
$video_meta_id = "video_".$product_id

?>
<div class="ywcfav_video_content vimeo" data-video_info="<?php echo $video_id.','.$video_type;?>">
    <div class="ywcfav_video_iframe">
        <iframe id="<?php echo $video_meta_id;?>" type="text/html"  src="<?php echo $http;?>://player.vimeo.com/video/<?php echo $video_id;?>?api=1&player_id=<?php echo $video_meta_id;?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen >

        </iframe>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){

    var img_container = $('.product .images'),
        video_iframe  = $('.ywcfav_video_iframe'),
        iframe  =   $('#<?php echo $video_meta_id;?>'),
        width = img_container.width()*1,
        height =  Math.round( ( width/<?php echo $width_ratio;?> )*<?php echo $height_ratio;?> );
        iframe.css({'width':width, 'height':height});

        iframe = iframe[0];
    var player  =   $f(iframe);

        player.addEvent( 'ready',function(){

            video_iframe.show();

        player.addEvent( 'pause', onPlayerPause );
        player.addEvent( 'finish', onPlayerFinish );
        player.addEvent( 'playProgress', onPlayerProgress );
    });

    function onPlayerPause( id ){

        $('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();

    }

    function onPlayerFinish( id ){

        $('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();
    }

    function onPlayerProgress( data, id ){

        $('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').hide();
    }

});
</script>