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

namespace WoogaEnhancedEcommerce\Common\Traits;

/**
 * The singleton skeleton trait to instantiate the class only once
 *
 * @package WoogaEnhancedEcommerce\Common\Traits
 * @since 1.0.0
 */
trait Singleton {
	private static $instance;

	final private function __construct() {
	}

	final private function __clone() {
	}

	final private function __wakeup() {
	}

	/**
	 * @return self
	 * @since 1.0.0
	 */
	final public static function init(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
