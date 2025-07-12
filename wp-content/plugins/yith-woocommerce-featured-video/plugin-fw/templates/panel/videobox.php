<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
*  Example to call this template
*
*  'section_general_settings_videobox'         => array(
*      'name' => __( 'Title of box', 'yith-plugin-fw' ),
*      'type' => 'videobox',
*      'default' => array(
*          'plugin_name'        => __( 'Plugin Name', 'yith-plugin-fw' ),
*          'title_first_column' => __( 'Title first column', 'yith-plugin-fw' ),
*          'description_first_column' => __('Lorem ipsum ... ', 'yith-plugin-fw'),
*          'video' => array(
*              'video_id'           => 'vimeo_code',
*              'video_image_url'    => '#',
*              'video_description'  => __( 'Lorem ipsum dolor sit amet....', 'yith-plugin-fw' ),
*          ),
*          'title_second_column' => __( 'Title first column', 'yith-plugin-fw' ),
*          'description_second_column' => __('Lorem ipsum dolor sit amet.... ', 'yith-plugin-fw'),
*          'button' => array(
*              'href' => 'http://www.yithemes.com',
*              'title' => 'Get Support and Pro Features'
*          )
*      ),
*      'id'   => 'yith_wcas_general_videobox'
*  ),
*/
?>
<div id="normal-sortables" class="meta-box-sortables yith-videobox-wrapper">
    <div id="<?php echo $id ?>" class="postbox">
        <h3><span><?php echo $name ?></span></h3>
        <div class="inside">
            <div class="yith_videobox">
                <div class="column"><h2><?php echo $default['title_first_column'] ?></h2>
                    <?php if ( isset( $default['video'] ) && !empty( $default['video'] ) ): ?>
                        <a class="yith-video-link" href="#" data-video-id="yith-video-iframe">
                            <img src="<?php echo $default['video']['video_image_url'] ?>">
                        </a>

                        <p class="yit-video-description">
                            <?php echo $default['video']['video_description'] ?>
                        </p>

                        <p class="yith-video-iframe">
                            <iframe src="//player.vimeo.com/video/<?php echo $default['video']['video_id'] ?>?title=0&amp;byline=0&amp;portrait=0" width="853" height="480" frameborder="0"></iframe>
                        </p>
                    <?php endif ?>
                    <?php if ( isset( $default['image'] ) && !empty( $default['image'] ) ): ?>
                        <a href="<?php echo $default['image']['image_link']  ?>" target="_blank" class="yith-image-frame">
                            <img src="<?php echo $default['image']['image_url'] ?>">
                        </a>
                    <?php endif ?>
                    <?php if ( isset( $default['description_first_column'] ) && $default['description_first_column'] != '' ): ?>
                        <p><?php echo $default['description_first_column'] ?></p>
                    <?php endif ?>
                </div>
                <div class="column two">
                    <h2><?php echo $default['title_second_column'] ?>?</h2>

                    <p><?php echo $default['description_second_column'] ?></p>

                    <?php if ( isset( $default['button'] ) && !empty( $default['button'] ) ): ?>
                        <p>
                            <a class="button-primary" href="<?php echo $default['button']['href'] ?>" target="_blank"><?php echo $default['button']['title'] ?></a>
                        </p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>