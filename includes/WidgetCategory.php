<?php

namespace StorePlugin\ShopElement;

use StorePlugin\ShopElement\Contracts\ServiceInterface;

/**
 * Register elementor widgets
 *
 * @package StorePlugin\ShopElement
 */
class WidgetCategory implements ServiceInterface {

    public function register(): void {
        add_action( 'elementor/elements/categories_registered', [ $this, 'shopelement_elementor_category' ] );
    }

     /**
     * Create shop element category
     *
     * @param object $elements_manager
     * @return void
     */
    public function shopelement_elementor_category( $elements_manager ) {
        $elements_manager->add_category(
            'shopelement_cat',
            [
                'title' => esc_html__( 'Shop Element', 'shopelement' ),
                'icon'  => 'eicon-cart-light'
            ]
        );
    }

}
