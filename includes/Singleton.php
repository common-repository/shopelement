<?php

namespace StorePlugin\ShopElement;

use StorePlugin\ShopElement\Modules\Dynamic_Utilities;
use StorePlugin\ShopElement\Modules\Reusable_Controls;

final class Singleton {
    /**
     * Single instance
     *
     * @var mixed
     */
    private static $instance = null;

    /**
     * Get minimum elementor version
     *
     * @var string
     */
    const MIN_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Get minimum php version
     *
     * @var string
     */
    const MIN_PHP_VERSION = '7.4';

    /**
     * Dynamic Utilities' global object
     *
     * @var Dynamic_Utilities
     */
    public $du;

    /**
     * Reusable controls
     *
     * @var Reusable_Controls
     */
    public $controls;

    /**
	 * Construct privately and build global singleton objects.
	 *
	 * @since    1.0.0
	 */
    private function __construct()
    {
        $this->du       = new Dynamic_Utilities();
        $this->controls = new Reusable_Controls();
    }

    /**
     * Singleton does not allow cloning and serialization
     *
     * @return void
     */
    private function __clone() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden!', 'shopelement' ), '1.0.0' );
    }

    /**
     * Singleton does not allow cloning and unserialization
     *
     * @return void
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Unserialization is forbidden!', 'shopelement' ), '1.0.0' );
    }

    /**
     * Instansiate singleton object in init method
     *
     * @return null|object
     */
    public static function init() {
        if( is_null( self::$instance ) ) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function is_compatible() {

		// Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'admin_notice_missing_elementor' ] );
			return false;
		}

        // Make sure WC is installed
        if( ! function_exists( 'WC' ) ) {
            add_action( 'admin_notices', [ __CLASS__, 'admin_notice_missing_woocommerce' ] );
			return false;
        }

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MIN_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

    /**
     * Check if the pro plugin is active
     *
     * @return bool
     */
    public static function is_active() {
        $plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'shopelement-pro/shopelement-pro.php';

        // Check if pro version is active.
        if ( in_array( $plugin_path, wp_get_active_and_valid_plugins() ) ) {
            return false;
        }

        return true;
    }

	/**
	 * Setting page link from plugin page.
	 *
	 * @param array $links
	 * @return array
	 */
	public static function setting_link_next_plugin_activation( $links ) {
		if( self::is_active() ) {
			$links[] = '<a href="https://storeplugin.net/plugins/shopelement/?utm_source=activesite&utm_campaign=corder&utm_medium=link" target="_blank">Get Pro</a>';
		}
		return $links;
	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function admin_notice_missing_elementor() {
        // PHPCS:Ignore
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'shopelement' ),
			'<strong>' . esc_html__( 'Shop Element', 'shopelement' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'shopelement' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have WooCommerce installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function admin_notice_missing_woocommerce() {
        // PHPCS:Ignore
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'shopelement' ),
			'<strong>' . esc_html__( 'Shop Element', 'shopelement' ) . '</strong>',
			'<strong>' . esc_html__( 'WooCommerce', 'shopelement' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function admin_notice_minimum_elementor_version() {
        // PHPCS:Ignore
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'shopelement' ),
			'<strong>' . esc_html__( 'Shop Element', 'shopelement' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'shopelement' ) . '</strong>',
			 self::MIN_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function admin_notice_minimum_php_version() {
        // PHPCS:Ignore
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'shopelement' ),
			'<strong>' . esc_html__( 'Shop Element', 'shopelement' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'shopelement' ) . '</strong>',
			 self::MIN_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );

	}

}
