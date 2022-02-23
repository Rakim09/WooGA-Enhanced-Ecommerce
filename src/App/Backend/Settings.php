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

namespace WoogaEnhancedEcommerce\App\Backend;

use WoogaEnhancedEcommerce\Common\Abstracts\Base;

/**
 * Class Settings
 *
 * @package WoogaEnhancedEcommerce\App\Backend
 * @since 1.0.0
 */
class Settings extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This backend class is only being instantiated in the backend as requested in the Bootstrap class
		 *
		 * @see Requester::isAdminBackend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here for admin settings specific functions
		 */
		add_action( 'admin_menu', [ $this, 'registerSettingsMenu' ] );

		add_action( 'admin_init', [ $this, 'registerSettingFields' ] );

		add_filter('allowed_options', function($allowed_options) {
			$allowed_options['wooga-general-settings'][] = 'wooga_ga_tracking_id';
			$allowed_options['wooga-general-settings'][] = 'wooga_brand_taxonomy';
			return $allowed_options;
		});
	}

	/**
	 * Register plugin settings menu.
	 *
	 * @since 1.0.0
	 */
	public function registerSettingsMenu( )
	{
		add_options_page(
			__( 'WooGA Enhanced Ecommerce settings', $this->plugin->textDomain() ),
			__( 'WooGA Enhanced Ecommerce', $this->plugin->textDomain() ),
			'administrator',
			'wooga-general-settings',
			[ $this, 'renderSettingsPage' ],
		);
	}

	public function renderSettingsPage()
	{
		require_once $this->plugin->templatePath().'/admin/wooga-settings.php';
	}

	public function registerSettingFields()
	{

		add_settings_section(
			'wooga-general-settings-section',
			__( 'General', $this->plugin->textDomain() ),
			[ $this, 'settingsSectionCallback' ],
			'wooga-general-settings',
		);

		add_settings_field(
			'wooga_ga_tracking_id',
			'GA Tracking ID',
			[ $this, 'renderSettingsField' ],
			'wooga-general-settings',
			'wooga-general-settings-section',
			[
				'label_for' => 'wooga_ga_tracking_id'
			]
		);

		add_settings_field(
			'wooga_brand_taxonomy',
			'Product Brand taxonomy',
			[ $this, 'renderSettingsField' ],
			'wooga-general-settings',
			'wooga-general-settings-section',
			[
				'label_for' => 'wooga_brand_taxonomy'
			]
		);

		register_setting(
			'wooga-general-settings-section',
			'wooga_ga_tracking_id',
		);

		register_setting(
			'wooga-general-settings-section',
			'wooga_brand_taxonomy',
		);
	}

	public function settingsSectionCallback( array $args )
	{
		echo '<p>Set up your Google Analytics Tracking ID</p>';
	}
	

	public function renderSettingsField( array $args )
	{
		$value = get_option( $args['label_for'] );

		echo sprintf( 
			'<input
			name="%1$s"
			id="%1$s"
			type="text"
			value="%2$s"
			/>',
			$args['label_for'],
			$value
		);
	}
}
