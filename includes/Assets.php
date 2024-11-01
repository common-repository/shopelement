<?php

/**
 * The file that defines actions on plugin deactivation.
 *
 * @package StorePlugin\ShopElement
 */
namespace StorePlugin\ShopElement;

use StorePlugin\ShopElement\Contracts\ServiceInterface;

/**
 * Enqueue assets for custom order status plugin
 */
class Assets implements ServiceInterface {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function register(): void
	{
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_public_assets'] );
		add_action( 'admin_enqueue_scripts', [$this, 'enqueue_admin_assets'] );
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_editor_before_scripts' ] );
		add_action( 'elementor/editor/before_register_scripts', [ $this, 'register_editor_before_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_before_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_editor_after_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_after_styles' ] );

	}

    /**
	 * Register the assets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_admin_assets() {

	}

	/**
	 * Register the public assets.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_public_assets() {
		wp_enqueue_style( 'shopelement-style', SHOPELEMENT_URL . '/assets/css/shopelement.css', [], '1.0.0' );
		wp_register_style( 'slick-style', SHOPELEMENT_URL . '/assets/css/slick.css', [], '1.8.0' );
		wp_enqueue_style( 'icondivi-style', SHOPELEMENT_URL . '/assets/css/icondivi.css', [], '1.3.5' );
		wp_register_style( 'product-grid-carousel', SHOPELEMENT_URL . '/assets/css/product-grid-carousel.css', [], '1.0.0' );
		wp_register_style( 'product-grid', SHOPELEMENT_URL . '/assets/css/product-grid.css', [], '1.0.0' );
		wp_register_style( 'product-list', SHOPELEMENT_URL . '/assets/css/product-list.css', [], '1.0.0' );
		wp_register_style( 'product-carousel', SHOPELEMENT_URL . '/assets/css/product-carousel.css', [], '1.0.0' );
		wp_register_style( 'product-category', SHOPELEMENT_URL . '/assets/css/product-category.css', [], '1.0.0' );
		wp_register_style( 'product-brand-logo', SHOPELEMENT_URL . '/assets/css/logo.css', [], '1.0.0' );
		wp_enqueue_style( 'product-banner', SHOPELEMENT_URL . '/assets/css/product-banner.css', [], '1.0.0' );
		wp_enqueue_style( 'store-feature', SHOPELEMENT_URL . '/assets/css/store-feature.css', [], '1.0.0' );
		wp_register_style( 'product-review', SHOPELEMENT_URL . '/assets/css/product-review.css', [], '1.0.0' );
		wp_register_style( 'customer-review-carousel', SHOPELEMENT_URL . '/assets/css/customer-review-carousel.css', [], '1.0.0' );
		wp_register_style( 'customer-review', SHOPELEMENT_URL . '/assets/css/customer-review.css', [], '1.0.0' );
		wp_register_style( 'customer-reviewcarousel', SHOPELEMENT_URL . '/assets/css/customer-reviewcarousel.css', [], '1.0.0' );
		wp_enqueue_style( 'main-style', SHOPELEMENT_URL . '/assets/css/main.css', [], '1.0.0' );

		// wp_register_script( 'appear-script', SHOPELEMENT_URL . '/assets/js/jquery.appear.js', ['jquery'], false, true );
		// wp_register_script( 'countTo-script', SHOPELEMENT_URL . '/assets/js/jquery.countTo.js', ['jquery'], false, true );
		wp_register_script( 'swiper-script', SHOPELEMENT_URL . '/assets/js/swiper-bundle.min.js', [], '11.1.3', true );
		wp_register_script( 'slick-script', SHOPELEMENT_URL . '/assets/js/slick.min.js', [ 'jquery' ], '1.8.0', true );
		wp_register_script( 'customer-review-carousel', SHOPELEMENT_URL . '/assets/js/customer-review-carousel.js', [ 'jquery' ], '1.0.0', true );
		wp_register_script( 'testing-editor', SHOPELEMENT_URL . '/assets/js/testing-editor.js', [ 'jquery' ], '1.0.0', true );
		wp_register_script( 'main-script', SHOPELEMENT_URL . '/assets/js/main.js', [ 'jquery' ], '1.0.0', true );
	}

	public function enqueue_editor_after_styles() {
        wp_enqueue_script( 'shopelement-elementor-editor', SHOPELEMENT_URL . '/assets/js/elementor-editor.js', ['elementor-editor', 'jquery'], '1.0.0', true );
		wp_enqueue_style( 'shopelement-elementor-editor', SHOPELEMENT_URL . '/assets/css/elementor-editor.css', [], '1.0.0' );
	}

	public function register_editor_before_scripts() {

	}

	public function enqueue_editor_before_scripts() {

	}

}
