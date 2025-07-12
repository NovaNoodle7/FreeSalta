<?php
if( !defined( 'ABSPATH' ) )
    exit;

$video_settings   =   array(

    'video-settings'  =>  array(

        'video-general_setting_section_start' =>  array(
            'name'  =>  __('General Settings', 'yith-woocommerce-featured-video' ),
            'type'  =>  'title',
            'id'    =>  'ywcfav_video-general_setting_section_start'
        ),

        'aspectratio' => array(
            'name' => __('Aspect Ratio', 'yith-woocommerce-featured-video'),
            'type' => 'select',
            'options' => array( '16_9' => '16:9', '4_3' => '4:3' ),
            'desc'	=> __( 'Choose the aspect ratio for your video', 'yith-woocommerce-featured-video' ),
            'default' => '16_9',
            'id' => 'ywcfav_aspectratio'
        ),
        'video_general_setting_section_end'   =>  array(
            'type'  =>  'sectionend',
            'id'    =>  'ywcfav_video_general_setting_section_end'
        )
    )
);

return apply_filters( 'ywcfav_free_video_settings', $video_settings );