<?php
/**
 * Plugin Name:     Free Gift For WC
 * Description:     Add a Free Gift to Cart
 * Author:          Chris Bibby
 * Author URI:      https://chrisbibby.com.au
 * Text Domain:     free-gift-for-wc
 * Domain Path:     /languages
 * Version:         1.1.0
 * GitHub Plugin URI: cmbibby/free-gift-for-wc
 * WC requires at least: 3.5.0
 * WC tested up to: 4.7.0
 *
 * @package         Free_Gift_For_Wc
 */

// Your code starts here.

namespace Free_Gift_WC;
require_once( __DIR__ ) . '/vendor/autoload.php';
class Loader {

	protected static $dir_path       = '';
	protected static $plugin_version = '1.0.0';

	public function __construct() {
		 self::$dir_path = plugin_dir_url( __FILE__ );
		new Plugin;
	}

	public static function get_dir_url() {
	  return self::$dir_path;
	}

	public static function get_plugin_version() {
	   return self::$plugin_version;
	}
}

add_action(
	'plugins_loaded',
	function() {
	new Loader;
}
	);

