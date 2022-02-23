<?php
/**
 * WooGA Enhanced Ecommerce
 *
 * @package   wooga-enhanced-ecommerce
 * @author    Bartłomiej Dziewa <bartlomiej.dziewa@outlook.com>
 * @copyright 2022 WooGA Enhanced Ecommerce
 * @license   MIT
 * @link      https://github.com/Rakim09
 *
 * Plugin Name:     WooGA Enhanced Ecommerce
 * Plugin URI:      https://github.com/Rakim09
 * Description:     Plugin extending WooCommerce integration with GoogleAnalytics
 * Version:         1.0.0
 * Author:          Bartłomiej Dziewa
 * Author URI:      https://github.com/Rakim09
 * Text Domain:     wooga-enhanced-ecommerce
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       WoogaEnhancedEcommerce
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const WOOGA_ENHANCED_ECOMMERCE_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$wooga_enhanced_ecommerce_autoloader = require plugin_dir_path( WOOGA_ENHANCED_ECOMMERCE_PLUGIN_FILE ) . 'vendor/autoload.php';

/**
 * Setup hooks (activation, deactivation, uninstall)
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'WoogaEnhancedEcommerce\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'WoogaEnhancedEcommerce\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'WoogaEnhancedEcommerce\Config\Setup', 'uninstall' ] );

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\WoogaEnhancedEcommerce\Bootstrap' ) ) {
	wp_die( __( 'WooGA Enhanced Ecommerce is unable to find the Bootstrap class.', 'wooga-enhanced-ecommerce' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $wooga_enhanced_ecommerce_autoloader ) {
		/**
		 * @see \WoogaEnhancedEcommerce\Bootstrap
		 */
		try {
			new \WoogaEnhancedEcommerce\Bootstrap( $wooga_enhanced_ecommerce_autoloader );
		} catch ( Exception $e ) {
			wp_die( __( 'WooGA Enhanced Ecommerce is unable to run the Bootstrap class.', 'wooga-enhanced-ecommerce' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \WoogaEnhancedEcommerce\Common\Functions
 * @since 1.0.0
 */
function wooga_enhanced_ecommerce(): \WoogaEnhancedEcommerce\Common\Functions {
	return new \WoogaEnhancedEcommerce\Common\Functions();
}
