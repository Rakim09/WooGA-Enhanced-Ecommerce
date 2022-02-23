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
?>
<?php
/**
 * @see \WoogaEnhancedEcommerce\App\Backend\Settings
 */
?>
<div class="wrap">
    <h2><?= $this->plugin->name(); ?></h2>
    <form method="POST" action="options.php">
        <?php
        settings_fields('wooga-general-settings');
        do_settings_sections('wooga-general-settings');
        ?>
        <?php submit_button(); ?>
    </form>
</div>