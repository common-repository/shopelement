<?php

/**
 * Plugin Name: ShopElement
 * Requires Plugins:  woocommerce, elementor
 * Description: Elementor Addons for WooCommerce. Build beautiful shop page with ShopElement elements.
 * Plugin URI:  https://storeplugin.net/plugins/shopelement/
 * Version:     2.0.0
 * Author:      StorePlugin
 * Author URI:  https://storeplugin.net
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: shopelement
 * Elementor tested up to: 3.24.7
 * Elementor Pro tested up to: 3.24.7
 */
/** Prevent unexpected access */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** PSR-4 compatible autoload */
$_autoload = require __DIR__ . '/vendor/autoload.php';

/** Import necessary classes */
use StorePlugin\ShopElement\Container;
use StorePlugin\ShopElement\PluginFactory;
use StorePlugin\ShopElement\Container\Dice;
use StorePlugin\ShopElement\Singleton;

/** Plugin version constant for ShopElement */
if( ! defined( 'SHOPELEMENT_VERSION' ) ) {
    define( 'SHOPELEMENT_VERSION', '2.0.0' );
}

/** Plugin name constant for ShopElement */
if( ! defined( 'SHOPELEMENT_NAME' ) ) {
    define( 'SHOPELEMENT_NAME', 'Shop Element' );
}

/** Plugin PATH constant for ShopElement */
if( ! defined( 'SHOPELEMENT_PATH' ) ) {
    define( 'SHOPELEMENT_PATH', __FILE__ );
}

/** Plugin DIR constant for ShopElement */
if( ! defined( 'SHOPELEMENT_DIR' ) ) {
    define( 'SHOPELEMENT_DIR', __DIR__ );
}

/** Plugin Base constant */
if( ! defined( 'SHOPELEMENT_BASE' ) ) {
    define( 'SHOPELEMENT_BASE', plugin_basename( SHOPELEMENT_PATH ) );
}

/** Plugin URI constant for ShopElement */
if( ! defined( 'SHOPELEMENT_URL' ) ) {
    define( 'SHOPELEMENT_URL', plugins_url( '', __FILE__ ) );
}

/** Load container with autowiring process. */
add_action( 'plugins_loaded', function() use( $_autoload ) {
    if( class_exists( Container::class ) ) {
        if( Singleton::is_compatible() && Singleton::is_active() ) {
            /**
             * Singleton global function
             *
             * @return null|object
             */
            function SHOPELEMENT_ACT() {
                return Singleton::init();
            }

            /** Boot ShopElement plugin */
            ( new Container( $_autoload->getPrefixesPsr4(), 'StorePlugin\ShopElement' ) )
                ->container( new Dice() )
                ->register();
                SHOPELEMENT_ACT();
        }
    }
});

/** Do things in plugin activation and deactivation */
register_activation_hook( SHOPELEMENT_PATH, fn() => PluginFactory::activate() );
register_deactivation_hook( SHOPELEMENT_PATH, fn() => PluginFactory::deactivate() );
add_filter( 'plugin_action_links_' . SHOPELEMENT_BASE, [ Singleton::class, 'setting_link_next_plugin_activation'] );
