<?php
if( !defined( 'ABSPATH' ) )
    exit;

$src =  $atts['url'];
$http = is_ssl() ? 'https' : 'http';
list( $video_type, $video_id ) = explode( ':', ywcfav_video_type_by_url( $src ) );


$aspect_ratio = get_option( 'ywcfav_aspectratio' );
$aspect_ratio = explode( '_', $aspect_ratio );

$width_ratio  = $aspect_ratio[0];
$height_ratio = $aspect_ratio[1];
?>

<div class="ywcfav_video_content youtube" data-video_info="<?php echo $video_id.','.$video_type;?>" >
    <div class="ywcfav_video_iframe">

        <iframe id="video_<?php echo $product_id;?>" type="text/html" onload="onYouTubeIframeAPIReady()" src="<?php echo $http;?>://www.youtube.com/embed/<?php echo $video_id;?>?enablejsapi=1" frameborder="0"  webkitallowfullscreen mozallowfullscreen allowfullscreen="1">
        </iframe>
    </div>

<script type="text/javascript">
    var player,
           img_container = jQuery('.product .images'),
           frame_width = img_container.width()*1,
           frame_height =  Math.round( ( frame_width/<?php echo $width_ratio;?> )*<?php echo $height_ratio;?> );

    
           function onYouTubeIframeAPIReady() {
                player = new YT.Player('video_<?php echo $product_id;?>',
                        {
                            events: {
                                'onReady': onPlayerReady,
                                'onStateChange' : onPlayerStateChange
                        }
                        });


                player.setSize( frame_width, frame_height );

            }

            function onPlayerReady( event ){

            	jQuery('.ywcfav_video_iframe').show();

            }

            function onPlayerStateChange( event ){

                 if( event.data === YT.PlayerState.PAUSED ){


                     jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();

                 }
                else if( event.data == YT.PlayerState.ENDED ){

                     jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();
                 }
                else if( event.data == YT.PlayerState.PLAYING ){

                	jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').hide();
                 }
            }

</script>
</div>