<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YIT_Ajax' ) ) {
    /**
     * YIT Ajax
     *
     * @class      YIT_Ajax
     * @package    Yithemes
     * @since      1.0
     * @author     Leanza Francesco <leanzafrancesco@gmail.com>
     */
    class YIT_Ajax {
        /**
         * @var string version of class
         */
        public $version = '1.0.0';

        /**
         * @var object The single instance of the class
         * @since 1.0
         */
        protected static $_instance = null;

        /**
         * Constructor
         *
         * @since      1.0
         * @author     Leanza Francesco <leanzafrancesco@gmail.com>
         */
        private function __construct() {

        }

        /**
         * get single instance
         *
         * @static
         * @return YIT_Ajax
         *
         * @since  1.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }
}

YIT_Ajax::instance();