<?php
function storeone_get_social_block() {
    $open_new_tab  = (get_theme_mod('storeone_social_new_tab', true)) ? 'target="_blank"' : '';
    $link_facebook = get_theme_mod('storeone_social_link_facebook');
    $link_google   = get_theme_mod('storeone_social_link_google');
    $link_youtube  = get_theme_mod('storeone_social_link_youtube');
    $link_twitter  = get_theme_mod('storeone_social_link_twitter');
    $link_linkedin = get_theme_mod('storeone_social_link_linkedin');
    $link_instagram = get_theme_mod('storeone_social_link_instagram');
    $is_all_empty  = true;
    ?>
        <ul class="bgs-social">
            <?php if (!empty($link_facebook)): $is_all_empty = false;?>
	            <li><a href="<?php echo esc_url($link_facebook); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-facebook"></i></a></li>
            <?php endif;?>
            <?php if (!empty($link_google)): $is_all_empty = false;?>
	            <li><a href="<?php echo esc_url($link_google); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-google-plus"></i></a></li>
            <?php endif;?>
            <?php if (!empty($link_youtube)): $is_all_empty = false;?>
	            <li><a href="<?php echo esc_url($link_youtube); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-twitter"></i></a></li>
            <?php endif;?>
            <?php if (!empty($link_twitter)): $is_all_empty = false;?>
	            <li><a href="<?php echo esc_url($link_twitter); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-youtube"></i></a></li>
            <?php endif;?>
            <?php if (!empty($link_instagram)): $is_all_empty = false;?>
                <li><a href="<?php echo esc_url($link_instagram); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-instagram"></i></a></li>
            <?php endif;?>
            <?php if (!empty($link_linkedin)): $is_all_empty = false;?>
	            <li><a href="<?php echo esc_url($link_linkedin); ?>"  <?php echo esc_attr($open_new_tab); ?>><i class="fa fa-linkedin"></i></a></li>
	        <?php endif;?>
            <?php if ($is_all_empty && current_user_can('edit_theme_options')): ?>
            <li class="empty-slinks"><a href="<?php echo esc_url(admin_url('customize.php')); ?>" target="_blank"><i class="fa fa-info"></i> <?php esc_html_e('Add/Edit Social Links in Customizer', 'storeone');?> </a> </li>
            <?php endif;?>
        </ul>
    <?php
}

function storeone_excerpt_more($more) {
    if ( is_admin() ) {
        return $more;
    }
    
    return '';
}
add_filter('excerpt_more', 'storeone_excerpt_more');

function storeone_comment_form_fields($fields) {

    $fields['author'] = '<div class="form-group col-md-4"><label  for="name">' . __('NAME', 'storeone') . ':</label><input type="text" class="form-control" id="name" name="author" placeholder="' . esc_attr__('Full Name', 'storeone') . '"></div>';
    $fields['email']  = '<div class="form-group col-md-4"><label for="email">' . __('EMAIL', 'storeone') . ':</label><input type="email" class="form-control" id="email" name="email" placeholder="' . esc_attr__('Your Email Address', 'storeone') . '"></div>';
    $fields['url']    = '<div class="form-group col-md-4"><label  for="url">' . __('WEBSITE', 'storeone') . ':</label><input type="text" class="form-control" id="url" name="url" placeholder="' . esc_attr__('Website', 'storeone') . '"></div>';
    return $fields;
}
add_filter('comment_form_fields', 'storeone_comment_form_fields');

function storeone_comment_form_defaults($defaults) {
    $defaults['submit_field']   = '<div class="form-group col-md-4">%1$s %2$s</div>';
    $defaults['comment_field']  = '<div class="form-group col-md-12"><label  for="message">' . __('COMMENT', 'storeone') . ':</label><textarea class="form-control" rows="5" id="comment" name="comment" placeholder="' . esc_attr__('Message', 'storeone') . '"></textarea></div>';
    $defaults['title_reply_to'] = __('Post Your Reply Here To %s', 'storeone');
    $defaults['class_submit']   = 'btn btn-theme';
    $defaults['label_submit']   = __('SUBMIT COMMENT', 'storeone');
    $defaults['title_reply']    = '<h2>' . __('Post Your Comment Here', 'storeone') . '</h2>';
    $defaults['role_form']      = 'form';
    return $defaults;

}
add_filter('comment_form_defaults', 'storeone_comment_form_defaults');

function storeone_comment($comment, $args, $depth) {
    // get theme data.
    global $comment_data;
    // translations.
    $leave_reply = $comment_data['translation_reply_to_coment'] ? $comment_data['translation_reply_to_coment'] : __('Reply', 'storeone');?>
        <div class="col-xs-12 border">
            <div class="col-xs-2">
            <?php echo get_avatar($comment, $size = '80'); ?>
            </div>
            <div class="col-xs-10">
                <h4><?php comment_author();?></h4>
                <h5><?php if (('d M  y') == get_option('date_format')): ?>
                <?php comment_date('F j, Y');?>
                <?php else: ?>
                <?php comment_date();?>
                <?php endif;?>
                <?php esc_html_e('at', 'storeone');?>&nbsp;<?php comment_time('g:i a');?></h5>
                <p><?php comment_text();?></p>
                <?php comment_reply_link(array_merge($args, array('reply_text' => $leave_reply, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                <?php if ($comment->comment_approved == '0'): ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'storeone');?></em>
                <br/>
                <?php endif;?>
            </div>
        </div>
        <?php
}


add_action( 'tgmpa_register', 'storeone_register_required_plugins' );
function storeone_register_required_plugins() {

    $plugins = array(
        // This is an example of how to include a plugin bundled with a theme.
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        
        array(
            'name'      => __('StoreOne Extension', 'storeone'),
            'slug'      => 'storeone-extension',
            'required'  => false,
        ),
        array(
            'name'      => __('Kirki', 'storeone'),
            'slug'      => 'kirki',
            'required'  => false,
        ),
    );
    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'storeone',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'storeone-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa( $plugins, $config );
}
