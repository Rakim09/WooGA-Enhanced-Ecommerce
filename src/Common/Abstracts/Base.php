<?php
/**
 * WooGA Enhanced Ecommerce
 *
 * @package   wooga-enhanced-ecommerce
 * @author    Bartłomiej Dziewa <bartlomiej.dziewa@outlook.com>
 * @copyright 2022 WooGA Enhanced Ecommerce
 * @license   MIT
 * @link      https://github.com/Rakim09
 */

declare( strict_types = 1 );

namespace WoogaEnhancedEcommerce\Common\Abstracts;

use WoogaEnhancedEcommerce\Config\Plugin;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package WoogaEnhancedEcommerce\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base {
	/**
	 * @var Plugin : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin;

	/**
	 * Base constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin = Plugin::init();
	}
}
