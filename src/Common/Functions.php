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

namespace WoogaEnhancedEcommerce\Common;

use WoogaEnhancedEcommerce\App\Frontend\Templates;
use WoogaEnhancedEcommerce\Common\Abstracts\Base;

/**
 * Main function class for external uses
 *
 * @see wooga_enhanced_ecommerce()
 * @package WoogaEnhancedEcommerce\Common
 */
class Functions extends Base {
	/**
	 * Get plugin data by using wooga_enhanced_ecommerce()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData(): array {
		return $this->plugin->data();
	}

	/**
	 * Get the template instantiated class using wooga_enhanced_ecommerce()->templates()
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates(): Templates {
		return new Templates();
	}
}
