<?php

namespace StorePlugin\ShopElement\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Elementor Carousel Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class ProductCarousel extends Widget_Base {

	use \StorePlugin\ShopElement\Widgets\Traits\Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve product carousel widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-product-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve product carousel widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('Product Carousel', 'shopelement');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve carousel widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the carousel of categories the carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['shopelement_cat'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the carousel of keywords the carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return ['producs', 'carousel', 'products carousel'];
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://storeplugin.net/docs/shopelement/';
	}

	/**
	 * Get widget promotion data.
	 *
	 * Retrieve the widget promotion data.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return array Widget promotion data.
	 */
	protected function get_upsale_data() {
		return [
			'condition' => true,
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'shopelement' ),
			'title' => esc_html__( 'Get the pro', 'shopelement' ),
			'description' => esc_html__( 'Get the premium version of the widget with additional styling capabilities.', 'shopelement' ),
			'upgrade_url' => esc_url( 'https://storeplugin.net/plugins/shopelement/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'shopelement' ),
		];
	}

	/**
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'product-grid-carousel', 'product-carousel', 'slick-style' ];
	}

	/**
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'jquery','slick-script' ];
	}

	/**
	 * Product type
	 *
	 * @return array
	 */
	protected function __product_type() {
		return array_merge(['' => esc_html__('Default', 'shopelement')], wc_get_product_types());
	}

	/**
	 * Register carousel widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * ============================================================
		 * Start Layout Tab
		 * ============================================================
		 */
		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__('Layout', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__('Product carousel style', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'  => esc_html__('Style 1', 'shopelement'),
					'two' => esc_html__('Style 2', 'shopelement'),
					'three' => esc_html__('Style 3', 'shopelement'),
				],
			]
		);

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.19.0', '>' ) ) :
			$this->add_control(
				'pro_version_notice_1',
				[
					'type' => Controls_Manager::NOTICE,
					'notice_type' => 'warning',
					'dismissible' => false,
					'heading' => esc_html__( 'Only available in pro version!', 'shopelement' ),
					'content' => sprintf("%1\$s <a href='%2\$s' class='table-addons-notice-button' target='_blank'>%3\$s</a>",
						__( 'This content type is available in pro version only.', 'shopelement' ),
						'https://storeplugin.net/plugins/shopelement/',
						__( 'Get Pro Version', 'shopelement' )
					),
					'condition' => [
						'layout_style' => [
							'two',
							'three',
						],
					],
				]
			);
		endif;

		$this->end_controls_section();

		/**
		 * ============================================================
		 * Start Content Tab
		 * ============================================================
		 */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => ['one']
				]
			]
		);

		$this->add_control(
			'title_toggle',
			[
				'label' => esc_html__( 'Hide title', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'shopelement' ),
				'label_off' => esc_html__( 'No', 'shopelement' ),
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'rating_toggle',
			[
				'label' => esc_html__( 'Hide ratings', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'shopelement' ),
				'label_off' => esc_html__( 'No', 'shopelement' ),
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'review_toggle',
			[
				'label' => esc_html__( 'Hide review', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'shopelement' ),
				'label_off' => esc_html__( 'No', 'shopelement' ),
				'condition'	=> [
					'layout_style' => 'one'
				],
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'price_toggle',
			[
				'label' => esc_html__( 'Hide price', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'shopelement' ),
				'label_off' => esc_html__( 'No', 'shopelement' ),
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_options_section',
			[
				'label' => esc_html__('Slider Options', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => ['one']
				]
			]
		);

		$this->add_responsive_control(
			'item_per_row',
			[
				'label' 		=> esc_html__( 'Products per row', 'shopelement' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 12,
				'step' 			=> 1,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
			'slider_dots',
			[
				'label' => esc_html__( 'Dots', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'slider_arrows',
			[
				'label' => esc_html__( 'Arrows', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'slider_pauseOnHover',
			[
				'label' => esc_html__( 'Pause on hover', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
			'slider_infinite',
			[
				'label' => esc_html__( 'Infinite', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__('Query', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => ['one']
				]
			]
		);

		$this->add_control(
			'item_per_page',
			[
				'label' 		=> esc_html__('Products per page', 'shopelement'),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 100,
				'step' 			=> 1,
				'default' 		=> get_option('posts_per_page'),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' 		=> esc_html__('Order by', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					''				=> esc_html__('Default', 'shopelement'),
					'ID'			=> esc_html__('ID', 'shopelement'),
					'title'			=> esc_html__('Title', 'shopelement'),
					'name'			=> esc_html__('Name', 'shopelement'),
					'type'			=> esc_html__('Type', 'shopelement'),
					'date'			=> esc_html__('Date', 'shopelement'),
					'modified'		=> esc_html__('Modified', 'shopelement'),
					'menu_order'	=> esc_html__('Menu order', 'shopelement'),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' 		=> esc_html__('Order', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					''		=> esc_html__('Default', 'shopelement'),
					'ASC'	=> esc_html__('ASC', 'shopelement'),
					'DESC'	=> esc_html__('DESC', 'shopelement'),
				],
			]
		);

		$this->add_control(
			'product_type',
			[
				'label' 		=> esc_html__('Product type', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> $this->__product_type(),
			]
		);

		$this->add_control(
			'include_products',
			[
				'label' => esc_html__('Include Products', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => SHOPELEMENT_ACT()->du->get_products_name(),
			]
		);

		$this->add_control(
			'exclude_products',
			[
				'label' => esc_html__('Exclude Products', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => SHOPELEMENT_ACT()->du->get_products_name(),
			]
		);

		$this->add_control(
			'include_cats',
			[
				'label' 		=> esc_html__('Product categories', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> SHOPELEMENT_ACT()->du->product_taxonomies('product_cat'),
			]
		);

		$this->add_control(
			'include_tags',
			[
				'label' 		=> esc_html__('Product tags', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> SHOPELEMENT_ACT()->du->product_taxonomies('product_tag'),
			]
		);

		$this->add_control(
			'featured',
			[
				'label' => esc_html__('Featured', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopelement'),
				'label_off' => esc_html__('Hide', 'shopelement'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'stock_status',
			[
				'label' => esc_html__('Hide out of stock', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopelement'),
				'label_off' => esc_html__('Hide', 'shopelement'),
				'return_value' => 'instock',
				'default' => '',
			]
		);

		$this->end_controls_section();

		/**
		 * ============================================================
		 * Start Style Tab
		 * ============================================================
		 */
		$this->start_controls_section(
			'product_carousel_content_section',
			[
				'label' => esc_html__('Content', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__('Title', 'shopelement'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_top_space',
			[
				'label' => esc_html__('Spacing Top', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product__content > h5' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => esc_html__('Spacing Bottom', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
					'default' => [
						'unit' => 'px',
						'size' => 17,
					],
				],
				'selectors' => [
					'{{WRAPPER}} div.nxtcode-product__rating-comment' => 'padding-bottom: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'shopelement'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product__content > h5 > a' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Hover Color', 'shopelement'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product__content > h5 > a:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .nxtcode-product__content > h5 > a',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Plus Jakarta Sans',],
        ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .nxtcode-product__content > h5',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-product__content > h5',
			]
		);

		$this->add_control(
			'heading_price',
			[
				'label' => esc_html__('Price', 'shopelement'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__('Color', 'shopelement'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product__price,.nxtcode-product__price span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .nxtcode-product__price,.nxtcode-product__price span',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Plus Jakarta Sans',],
        ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'price_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-product__price,.nxtcode-product__price span',
			]
		);

		$this->add_control(
			'heading_rating',
			[
				'label' => esc_html__('Rating', 'shopelement'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__('Rating Color', 'shopelement'),
				'type' => Controls_Manager::COLOR,
				'default' => '#cccccc',
				'selectors' => [
					'{{WRAPPER}} .rating-icon__fill path' => 'fill: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'rating_active_color',
			[
				'label' => esc_html__('Rating Active Color', 'shopelement'),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9900',
				'selectors' => [
					'{{WRAPPER}} .rating-icon__fill-active path' => 'fill: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		// Image style section
		$this->start_controls_section(
			'product_carousel_image',
			[
				'label' => esc_html__('Image', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-product__thumbnail img', ['default_size' => '220', 'default_unit' => 'px']);

		$this->end_controls_section();

		// Button style section
		$this->start_controls_section(
			'product_carousel_button',
			[
				'label' => esc_html__('Button', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_button_style_control('{{WRAPPER}} .nxtcode-product__add-to-cart');

		$this->end_controls_section();
	}

	/**
	 * Outputs a dummy layout based on the layout style setting.
	 *
	 * @since 1.0.0
	 */
	private function layout_style_image() {
		return [
			'two' => [
				'src' => '/assets/images/pro/product-carousel-2.jpg',
				'alt' => 'product carousel two'
			],
			'three' => [
				'src' => '/assets/images/pro/product-carousel-3.jpg',
				'alt' => 'product carousel three'
			],
		];
	}

	/**
	 * Render carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings 	= $this->get_settings_for_display();
		$layout_styles = $this->layout_style_image();

		if ( array_key_exists( $settings['layout_style'], $layout_styles ) ) {
			$image = $layout_styles[ $settings['layout_style'] ];
			printf(
				'<img class="dummy-style" src="%s" alt="%s">',
				plugins_url($image['src'], SHOPELEMENT_PATH),
				$image['alt']
			);

			return;
		}

		$args 		= [
			'status'			=> ['publish'],
			'limit'				=> $settings['item_per_page'],
			'include'			=> $settings['include_products'],
			'exclude'			=> $settings['exclude_products'],
			'category'			=> $settings['include_cats'],
			'tag'				=> $settings['include_tags'],
			'featured'			=> $settings['featured'],
			'stock_status'		=> $settings['stock_status'],
			'orderby'			=> $settings['orderby'],
			'order'				=> $settings['order'],
		];

		// Query object
		$settings['product_type'] ? ($args['type'] = $settings['product_type']) : '';
		$products = new \WC_Product_Query($args);
		$product_carousels = $products->get_products();

		echo '<div class="nxtcode-shopelement-widget nxtcode-product-carousel-' . esc_attr( $this->get_id()) .' nxtcode-product__info nxtcode-product-carousel__info nxtcode-product__info-',$settings['layout_style'],' nxtcode-product-carousel__info-',$settings['layout_style'],'">';
		foreach ($product_carousels as $product_carousel) : ?>
			<div id="product-<?php echo esc_attr($product_carousel->get_id()) ?>" <?php post_class("nxtcode-product__single") ?>>
				<div class="nxtcode-product__single-inner">
					<div class="nxtcode-product__block">
						<div class="nxtcode-product__thumbnail">
							<?php echo wp_kses_post($product_carousel->get_image()) ?>
						</div>

						<div class="nxtcode-product__badge">
							<?php echo $product_carousel->is_on_sale() ? sprintf( __( '<div class="nxtcode-product__arrival-text"><span>%s</span></div>' ), 'New' ) : '' ?>
							<div class="nxtcode-product__price-off">
								<?php SHOPELEMENT_ACT()->du->render_price_discount_HTML( $product_carousel ) ?>
							</div>
						</div>

						<div class="nxtcode-product__cart-btn">
							<a href="<?php echo esc_url($product_carousel->add_to_cart_url()) ?>" class="nxtcode-product__add-to-cart">
								<?php echo esc_html($product_carousel->add_to_cart_text()) ?>
							</a>
						</div>
					</div>

					<?php
						if(
							$settings['title_toggle'] != 'no'
							|| $settings['rating_toggle'] != 'no'
							|| $settings['review_toggle'] != 'no'
							|| $settings['price_toggle'] != 'no'
						) :
					?>
					<div class="nxtcode-product__content">
						<?php if( $settings['title_toggle'] != 'no' ) : ?>
						<h5>
							<a href="<?php echo esc_url($product_carousel->get_permalink()) ?>">
								<?php echo esc_html($product_carousel->get_name()) ?>
							</a>
						</h5>
						<?php endif ?>

						<?php if( $settings['rating_toggle'] != 'no' || $settings['review_toggle'] != 'no' ) : ?>
						<div class="nxtcode-product__rating-comment">
							<?php if( $settings['rating_toggle'] != 'no' ) : ?>
							<div class="nxtcode-product__rating">
								<?php echo SHOPELEMENT_ACT()->du->render_star_ratings_HTML( $product_carousel ) ?>
							</div>
							<?php endif ?>

							<?php if( $settings['review_toggle'] != 'no' && $settings['layout_style'] == 'one' ) : ?>
							<div class="nxtcode-product__review">
								<?php printf( '<span>%d %s</span>', $product_carousel->get_review_count(), ( $product_carousel->get_review_count() > 1 ) ? 'reviews' : 'review' ) ?>
							</div>
							<?php endif ?>
						</div>
						<?php endif ?>

						<?php if( $settings['price_toggle'] != 'no' ) : ?>
						<div class="nxtcode-product__price">
							<?php echo wp_kses_post($product_carousel->get_price_html()) ?>
						</div>
						<?php endif ?>
					</div>
					<?php endif ?>
				</div>
			</div>
		<?php endforeach ?>
		</div>

		<script type="text/javascript">
			jQuery(function($){
    			$(document).ready(function() {
					$("<?php echo '.nxtcode-product-carousel-' . esc_attr( $this->get_id()) ?>").slick({
      					slidesToShow: <?php echo esc_attr( isset( $settings['item_per_row'] ) && $settings['item_per_row'] > 0 ? $settings['item_per_row'] : 3 ); ?>,
      					slidesToScroll: 1,
      					autoplay: <?php echo $settings['slider_autoplay'] == 'true' ? 'true' : 'false' ?>,
      					infinite: <?php echo $settings['slider_infinite'] == 'true' ? 'true' : 'false' ?>,
      					swipeToSlide: true,
						dots: <?php echo $settings['slider_dots'] == 'true' ? 'true' : 'false' ?>,
						arrows: <?php echo $settings['slider_arrows'] == 'true' ? 'true' : 'false' ?>,
      					pauseOnHover: <?php echo $settings['slider_pauseOnHover'] == 'true' ? 'true' : 'false';?>,
      					responsive: [
							{
								breakpoint: 1024,
								settings: {
									slidesToShow: <?php echo esc_attr( isset( $settings['item_per_row_tablet'] ) && $settings['item_per_row_tablet'] > 0 ? $settings['item_per_row_tablet'] : 2 ); ?>
								}
							},
							{
								breakpoint: 768,
								settings: {
									slidesToShow: <?php echo esc_attr( isset( $settings['item_per_row_mobile'] ) && $settings['item_per_row_mobile'] > 0 ? $settings['item_per_row_mobile'] : 1 ); ?>
								}
							}
      					]
    				});
    			});
			});
		</script>

	<?php
	}
}