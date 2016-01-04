<?php
/*
Plugin Name: D Counter
Plugin URI: http://ducdoan.com
Description: Count total visits, online
Version: 1.0
Author: Duc Doan
Author URI: http://ducdoan.com
License: GPL2
*/

defined( 'ABSPATH' ) || exit;

define( 'DC_URL', plugin_dir_url( __FILE__ ) );
define( 'DC_DIR', plugin_dir_path( __FILE__ ) );

require_once DC_DIR . '/inc/common.php';
require_once DC_DIR . '/inc/widget.php';