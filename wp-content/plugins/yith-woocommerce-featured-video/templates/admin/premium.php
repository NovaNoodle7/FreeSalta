<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
    overflow-x: hidden;
}
.section h1{
    text-align: center;
    text-transform: uppercase;
    color: #808a97;
    font-size: 35px;
    font-weight: 700;
    line-height: normal;
    display: inline-block;
    width: 100%;
    margin: 50px 0 0;
}
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
    display: table-cell;
    vertical-align: middle;
    width: auto;
    margin-right: 15px;
}
.section h2,
.section h3 {
    display: inline-block;
    vertical-align: middle;
    padding: 0;
    font-size: 24px;
    font-weight: 700;
    color: #808a97;
    text-transform: uppercase;
}

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YWCFAV_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YWCFAV_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/01-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.two{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/02-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.three{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/03-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.four{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/04-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.five{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/05-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.six{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/06-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.seven{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/07-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.eight{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/08-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.nine{
    background-image: url(<?php echo YWCFAV_ASSETS_URL?>/images/09-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}

@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
        width: 100%;
        padding: 0 15px;
    }
    .section-odd .col-1 {
        float: left;
        margin-right: -100%;
    }
    .section-odd .col-2 {
        float: right;
        margin-top: 65%;
    }
}

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Featured  Video%2$s to benefit from all features!','yith-woocommerce-featured-video'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-featured-video');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-featured-video');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-woocommerce-featured-video');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/01.png" alt="<?php _e('Soundcloud','yith-woocommerce-featured-video');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Audio files by SoundCloud','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('One of the new features of the premium version you can benefit from is the freedom to associate one or more %1$sSoundCloud%2$s audio files to your products.%3$s Create the playlist of the tracks you want to link to the product in order to listen to them one after one.', 'yith-woocommerce-featured-video'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Video uploading','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Create your customized video gallery to show with the product to offer your users more and more information to evaluate the plugin. And there\'s more: with the premium version of the plugin, you can also select a video from your %1$sWordPress gallery%2$s, so that you don\'t have to use %1$sYouTube%2$s or %1$sVimeo%2$s platforms.', 'yith-woocommerce-featured-video'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/02.png" alt="<?php _e('Video uploading','yith-woocommerce-featured-video');?>" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/03.png" alt="<?php _e('Management and play options','yith-woocommerce-featured-video');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Management and play options','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('A tailored settings panel for you and your users to manage videos. %3$s Set the automatic play of videos to catch your customers\' attention, and select the volume level you want. With a simple click, you can prevent video from being stopped, hoping that this will keep users watching the content you are offering. %3$sMoreover, you can choose whether to activate the %1$svideo control%2$s bar for your users, in order to let them use control buttons to manage videos.', 'yith-woocommerce-featured-video'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('Modal window ','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Purchase the premium version of %1$sYITH WooCommerce Featured Audio & Video Content%2$s if you want to play video and audio files linked to products in a %1$smodal window%2$s. A wise style choice for the market.', 'yith-woocommerce-featured-video'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/04.png" alt="Modal window " />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/05.png" alt="<?php _e('Style of the control bar','yith-woocommerce-featured-video');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Style of the control bar','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Customize the style of the video control bar you can see in the products of your shop. Go to the settings panel to %1$scustomize all colors of the bar%2$s with few clicks to make it suitable to your site.','yith-woocommerce-featured-video'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Product variations','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'The plugin is not just about simple products: %1$sadd video and audio files in your variations too%2$s, in order to set different contents even for the variations of the same product.','yith-woocommerce-featured-video' ),'<b>','</b>','<br>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/06.png" alt="Product variations" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCFAV_ASSETS_URL?>/images/07.png" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCFAV_ASSETS_URL?>/images/07-icon.png" />
                    <h2><?php _e('Video and Audio in sidebar','yith-woocommerce-featured-video');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Now you can show videos and audio in the %1$sproduct page sidebar%2$s. %3$sA nice alternative if you don\'t want to show them below the product main image ','yith-woocommerce-featured-video'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Featured Audio & Video Content%2$s to benefit from all features!','yith-woocommerce-featured-video'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-featured-video');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-featured-video');?></span>
                </a>
            </div>
        </div>
    </div>
</div>