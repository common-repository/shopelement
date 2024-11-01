<?php

/**
 * The file that defines actions on plugin deactivation.
 *
 * @package StorePlugin\ShopElement
 */
namespace StorePlugin\ShopElement;

/**
 * The plugin deactivation class.
 */
class Deactivate {
	/**
	 * Deactivate the plugin.
	 */
	public function deactivate(): void
	{
		\flush_rewrite_rules();
	}
}
