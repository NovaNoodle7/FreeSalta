<?php
if( !defined( 'ABSPATH' ) )
    exit;

if( !class_exists( 'YITH_WC_Audio_Video' ) ){

    class YITH_WC_Audio_Video
    {

        protected static $_instance;
        protected $_panel;
        protected $_panel_page;
        protected $_official_documentation;
        protected $_premium_landing_url;
        protected  $_premium_live_demo;
        protected $_premium;
        protected $_suffix;
        protected $services;
        protected $hosts;


        public function __construct()
        {

            //Init class attributes
            $this->_panel = null;
            $this->_panel_page = 'yith_wc_featured_audio_video';
            $this->_official_documentation = 'https://yithemes.com/docs-plugins/yith-woocommerce-featured-audio-video-content/';
            $this->_premium_landing_url = 'https://yithemes.com/themes/plugins/yith-woocommerce-featured-audio-video-content/';
            $this->_premium_live_demo   =   'http://plugins.yithemes.com/yith-woocommerce-featured-audio-video-content';
            $this->_premium = 'premium.php';
            $this->_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            $this->services = apply_filters( 'ywcfav_add_video_services', array(
                        'youtube' => 'Youtube',
                        'vimeo' => 'Vimeo',
            ));

            $this->hosts    =   apply_filters( 'ywcfav_add_hosts', array(
                   'youtube'=> array(
                        'youtube.com' ,
                        'www.youtube.com',
                        'youtu.be' ,
                        'www.youtu.be'),
                    'vimeo'=> array(
                        'www.vimeo.com',
                        'vimeo.com' )
                        ) );

            // Load Plugin Framework
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );
            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YWCFAV_DIR . '/' . basename(YWCFAV_FILE)), array( $this, 'action_links' ) );
            //Add row meta
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            add_action( 'yith_wc_featured_audio_video_premium', array( $this, 'premium_tab' ) );
            add_action( 'admin_menu', array( $this, 'add_ywcfav_menu' ), 5 );


            add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_video_field' ) );
            add_action( 'woocommerce_process_product_meta', array( $this, 'save_video_url' ), 10, 2 );


            add_action( 'wp_enqueue_scripts', array( $this, 'include_style_and_script' ) );
            add_filter( 'yith_wczm_featured_video_enabled', array( $this, 'product_has_video' ) );
            add_filter( 'yith_featured_video_enabled' , array( $this, 'product_has_video' ) );
            
            
            add_action( 'wp_ajax_get_featured_content', array( $this, 'get_featured_content' ) );
            add_action( 'wp_ajax_nopriv_get_featured_content', array( $this, 'get_featured_content' ) );
            add_action( 'wp_ajax_get_video_image', array( $this, 'get_video_image' ) );
            add_action( 'wp_ajax_nopriv_get_video_image', array( $this, 'get_video_image' ) );

	        add_action( 'wp_enqueue_scripts', array( $this, 'fix_woocommerce_style_issue' ), 99 );
        }

        /** return single instance of class
         * @author YITHEMES
         * @since 2.0.0
         * @return YITH_WC_Audio_Video
         */
        public static function get_instance()
        {
            if( is_null( self::$_instance ) ){
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function plugin_fw_loader(){
            if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file ) ;
                }
            }
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links($links)
        {

            $links[] = '<a href="' . admin_url("admin.php?page={$this->_panel_page}") . '">' . __('Settings', 'yith-woocommerce-featured-video') . '</a>';

            $premium_live_text = defined( 'YWCFAV_FREE_INIT' ) ?  __( 'Premium live demo', 'yith-woocommerce-featured-video' ) : __( 'Live demo', 'yith-woocommerce-featured-video' );

            $links[] = '<a href="'.$this->_premium_live_demo.'" target="_blank">'.$premium_live_text.'</a>';

            if (defined('YWCFAV_FREE_INIT')) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __('Premium Version', 'yith-woocommerce-featured-video') . '</a>';
            }

            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status)
        {
            if ((defined('YWCFAV_INIT') && (YWCFAV_INIT == $plugin_file)) ||
                (defined('YWCFAV_FREE_INIT') && (YWCFAV_FREE_INIT == $plugin_file))
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __('Plugin Documentation', 'yith-woocommerce-featured-video') . '</a>';
            }

            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri()
        {
            return defined('YITH_REFER_ID') ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url .'?refer_id=1030585';
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  void
         */
        public function premium_tab()
        {
            $premium_tab_template = YWCFAV_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if (file_exists($premium_tab_template)) {
                include_once($premium_tab_template);
            }
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function add_ywcfav_menu()
        {
            if (!empty($this->_panel)) {
                return;
            }

            $admin_tabs = apply_filters('ywcfav_add_premium_tab', array(
                'video-settings' => __('Video Settings', 'yith-woocommerce-featured-video'),
                'premium-landing' => __('Premium Version', 'yith-woocommerce-featured-video')
            ));

            $args = array(
                'create_menu_page' => true,
                'parent_slug' => '',
                'page_title' => __( 'Featured Video' , 'yith-woocommerce-featured-video' ),
                'menu_title' => __( 'Featured Video' , 'yith-woocommerce-featured-video' ),
                'capability' => 'manage_options',
                'parent' => '',
                'parent_page' => 'yit_plugin_panel',
                'page' => $this->_panel_page,
                'admin-tabs' => $admin_tabs,
                'options-path' => YWCFAV_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce($args);
        }


        public function add_video_field()
        {
            $args = apply_filters( 'ywcfav_simple_url_video_args', array(
                'id' => '_video_url',
                'label' => __('Featured Video URL', 'yith-woocommerce-featured-video'),
                'placeholder' => __('Video URL', 'yith-woocommerce-featured-video'),
                'desc_tip' => true,
                'description' => sprintf(__('Enter the URL for the video you want to show in place of the featured image in the product detail page. (the services enabled are: %s).', 'yith-woocommerce-featured-video'), implode(', ', $this->services))
            ));

            wc_get_template( 'admin/add_simple_url_video.php', $args,'', YWCFAV_TEMPLATE_PATH );
        }

        public function save_video_url( $post_id, $post )
        {
            if ( isset( $_POST['_video_url'] ) ) {
                $product = wc_get_product( $post_id );

                yit_save_prop( $product, '_video_url', esc_url($_POST['_video_url']));
            }

        }

        public function product_has_video(){

            global $post;

            if ( ! isset( $post->ID ) ) {
                return;
            }


            $free_featured = get_post_meta( $post->ID, '_video_url', true );
            $result = !empty( $free_featured );

            return apply_filters( 'yith_featured_video_premium_enabled', $result );
        }
        

        public function get_featured_content(){

            $product_id = isset( $_REQUEST['product_id'] ) ? $_REQUEST['product_id'] : false;
            $result = false;
            $template = '';
            $template_name = '';

            if( $product_id ) {

                $product = wc_get_product( $product_id );
                $video_url = yit_get_prop( $product, '_video_url' );

                if( !empty( $video_url ) ) {

                    $result = true;
                    $video_host = parse_url( esc_url( $video_url ) );
                    $args['url'] = $video_url;
                    $args['atts'] = $args;
                    $args['product_id'] = $product_id;

                    if( in_array( $video_host['host'], $this->hosts['youtube'] ) ) {

                        $template_name = 'template_video_youtube_player.php';

                    }
                    elseif( in_array( $video_host['host'], $this->hosts['vimeo'] ) ) {

                        $template_name = 'template_video_vimeo_player.php';
                    }


                    ob_start();
                    wc_get_template( $template_name, $args, YWCFAV_TEMPLATE_PATH , YWCFAV_TEMPLATE_PATH );
                    $template = ob_get_contents();
                    ob_end_clean();
                }
            }

            wp_send_json( array( 'result' => $result, 'template' => $template ) );
        }

        public function get_video_image(){

            $video_info = isset( $_REQUEST['video_info'] ) ? explode(',',$_REQUEST['video_info'] ) : array();

            $result = false;
            $img_url = '';
            if( count( $video_info ) ==2  ){

                $video_id = $video_info[0];
                $host = $video_info[1];
                switch( $host ) {

                    case 'vimeo' :
                        $img_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.xml';
                        $xml = simplexml_load_file($img_url);
                        $img_url = (string)$xml->video->thumbnail_large;
                        $tmp = getimagesize($img_url);

                        $result = !is_wp_error( $tmp );

                        break;
                    case 'youtube':
                        $img_url = 'https://img.youtube.com/vi/' .$video_id . '/maxresdefault.jpg';
                        $get_response = wp_remote_get($img_url);
                        $result =  !is_wp_error( $get_response ) && $get_response['response']['code'] == '200' ;

                        break;
                }
            }

            if( !$result ){
                $img_url = YWCFAV_ASSETS_URL.'/images/videoplaceholder.jpg';
            }

            wp_send_json( array( 'image_url' => $img_url , 'result'=> $result ) );
        }



        public function include_style_and_script() {

            if( is_product() ) {

                global $post;

                $product_id = $post->ID;
                wp_enqueue_script( 'youtube-api', '//www.youtube.com/player_api' );
                wp_enqueue_script( 'vimeo-api', '//f.vimeocdn.com/js/froogaloop2.min.js' );
                wp_enqueue_style( 'ywcfav_style', YWCFAV_ASSETS_URL . 'css/ywcfav_frontend.css', array(), YWCFAV_VERSION );

                $ywcfav_params  = apply_filters( 'ywcfav_params', array(
                                        'ajax_url' => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
                                       'img_class_container' => '.woocommerce-product-gallery__image',
                                       'no_img_class_container' => '.woocommerce-product-gallery__image--placeholder',
                                        'has_feature_content' => $this->product_has_video(),
                                        'product_id' => $product_id ,
                                        'actions' => array(
                                            'get_featured_content' => 'get_featured_content',
                                            'get_video_image'   => 'get_video_image'
                                        )
                                    )
                                );

                wp_register_script( 'ywcfav_frontend', YWCFAV_ASSETS_URL.'js/'.yit_load_js_file( 'ywcfav_frontend.js' ), array( 'jquery' ), YWCFAV_VERSION, true );

                wp_localize_script( 'ywcfav_frontend', 'ywcfav_frontend_param', $ywcfav_params );

                wp_enqueue_script( 'ywcfav_frontend' );
            }
        }

        public function fix_woocommerce_style_issue(){

	        if( is_product() && $this->product_has_video() ){

		        $style= '.flex-viewport { 
                            height:auto!important;
                    }';
		        wp_add_inline_style( 'ywcfav_style', $style );
	        }
        }


    }

}