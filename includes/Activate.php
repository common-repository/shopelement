<?php

/**
 * The file that defines actions on plugin activation.
 *
 * @package StorePlugin\ShopElement
 */
namespace StorePlugin\ShopElement;

/**
 * The plugin activation class.
 *
 * @since 1.0.0
 */
class Activate {
	/**
	 * Activate the plugin.
	 *
	 * @since 1.0.0
	 */
	public function activate(): void
	{
		update_option( 'shopelement_activation_info', [
			'version'	=> SHOPELEMENT_VERSION,
			'date'		=> gmdate('m d Y'),
		]);

		\flush_rewrite_rules();
	}
}
