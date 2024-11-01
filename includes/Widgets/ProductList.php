<?php

namespace StorePlugin\ShopElement\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class ProductList extends Widget_Base {

	use \StorePlugin\ShopElement\Widgets\Traits\Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve product list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-product-list';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve product list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('Product List', 'shopelement');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
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
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return ['producs', 'list', 'products list'];
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
	 * @return array
	 */
	public function get_style_depends() {
		return ['product-list'];
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
	 * Register list widget controls.
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
				'label' => esc_html__('Product list style', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'nxtcode-pl__info-two',
				'options' => [
					'one'  => esc_html__('Style 1', 'shopelement'),
					'nxtcode-pl__info-two' => esc_html__('Style 2', 'shopelement'),
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
							'one'
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
				'label' => esc_html__('Content options', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => [ 'nxtcode-pl__info-two' ],
				],
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

		$this->add_control(
			'hide_content',
			[
				'label' => esc_html__( 'Hide content', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'shopelement' ),
				'label_off' => esc_html__( 'No', 'shopelement' ),
				'return_value' => 'no',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'words_length',
			[
				'label' => esc_html__('Words length', 'shopelement'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 15,
				'max' => 100,
				'step' => 5,
				'default' => 55,
				'condition'	=> [
					'hide_content!'	=> 'no'
				]
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => esc_html__('Pagination', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopelement'),
				'label_off' => esc_html__('Hide', 'shopelement'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__('Query', 'shopelement'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => [ 'nxtcode-pl__info-two' ],
				],
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
				'options' 		=> SHOPELEMENT_ACT()->du->product_taxonomies( 'product_cat' ),
			]
		);

		$this->add_control(
			'include_tags',
			[
				'label' 		=> esc_html__('Product tags', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> SHOPELEMENT_ACT()->du->product_taxonomies( 'product_tag' ),
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
			'product_list_content_section',
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
					'{{WRAPPER}} .nxtcode-pl__content > h3' => 'margin-top: {{SIZE}}{{UNIT}};',
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
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-pl__content > h3' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .nxtcode-pl__content > h3 a' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Color', 'shopelement'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-pl__content > h3 a:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .nxtcode-pl__content > h3 a',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .nxtcode-pl__content > h3',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-pl__content > h3',
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
					'{{WRAPPER}} .nxtcode-pl__price,.nxtcode-pl__price span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .nxtcode-pl__price,.nxtcode-pl__price span',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'price_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-pl__price,.nxtcode-pl__price span',
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
			'product_list_image',
			[
				'label' => esc_html__('Image', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-pl__thumbnail img', ['default_size' => '220', 'default_unit' => 'px']);

		$this->end_controls_section();

		// Button style section
		$this->start_controls_section(
			'product_list_button',
			[
				'label' => esc_html__('Button', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_button_style_control('{{WRAPPER}} .nxtcode-pl__add-to-cart > a, .nxtcode-pl__cart-btn > a');

		$this->end_controls_section();

		// List style section
		$this->start_controls_section(
			'product_list_style_section',
			[
				'label' => esc_html__('List', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'list_bottom_space',
			[
				'label' => esc_html__('Bottom space', 'shopelement'),
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
					'{{WRAPPER}} .nxtcode-pl__info' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Pagination style section
		$this->start_controls_section(
			'product_pagination_section',
			[
				'label' => esc_html__( 'Pagination', 'shopelement' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_pagination_style_control( '.nxtcode-shopelement-widget' );

		$this->end_controls_section();
	}

	/**
	 * Outputs a dummy layout based on the layout style setting.
	 *
	 * @since 1.0.0
	 */
	private function layout_style_image() {
		return [
			'one' => [
				'src' => '/assets/images/pro/product-list-1.jpg',
				'alt' => 'product list two'
			]
		];
	}

	/**
	 * Render list widget output on the frontend.
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

		$paged		= (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

		$args 		= [
			'status'			=> ['publish'],
			'limit'				=> $settings['item_per_page'],
			'page'				=> $paged,
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
		$settings['product_type'] ? ( $args['type'] = $settings['product_type'] ) : '';
		$products = new \WC_Product_Query($args);
		$product_lists = $products->get_products();
		$args['limit'] = -1;
		$args['return']	= 'ids';
		unset( $args['page'] );
		$max_nums = wc_get_products( $args );
		$max_num_products = ceil( count($max_nums) / $settings['item_per_page'] );

		// Product markup
		echo '<div class="nxtcode-shopelement-widget nxtcode-product-list"><div class="nxtcode-product-flex">';
		foreach ($product_lists as $product_list) : ?>
			<article id="product-<?php echo esc_attr($product_list->get_id()) ?>" <?php post_class("nxtcode-pl__info {$settings['layout_style']}") ?>>
				<div class="nxtcode-pl__item">
					<div class="nxtcode-pl__thumbnail-block">
						<div class="nxtcode-pl__thumbnail">
							<?php echo wp_kses_post($product_list->get_image()) ?>
						</div>

						<?php if( $settings['layout_style'] == 'nxtcode-pl__info-two' ) : ?>
							<div class="nxtcode-pl__cart-overlay">
								<div class="nxtcode-pl__cart-btn">
									<a href="<?php echo esc_url( $product_list->add_to_cart_url() ) ?>">
										<?php echo esc_html( $product_list->add_to_cart_text() ) ?>
									</a>
								</div>
							</div>
						<?php endif ?>

					</div>
					<div class="nxtcode-pl__content">
						<?php if( $settings['layout_style'] == 'nxtcode-pl__info-two' ) : ?>
							<div class="nxtcode-pl__cat">
								<?php $shopelement_woo_cat = get_the_terms( $product_list->get_id(), 'product_cat' ) ?>
								<span><?php echo esc_html( $shopelement_woo_cat[0]->name ) ?></span>
							</div>
						<?php endif ?>

						<?php if( $settings['rating_toggle'] != 'no' ) : ?>
						<div class="nxtcode-pl__rating-icon">
							<?php echo SHOPELEMENT_ACT()->du->render_star_ratings_HTML( $product_list ); ?>
						</div>
						<?php endif ?>

						<?php if( $settings['title_toggle'] != 'no' ) : ?>
						<h3><a href="<?php echo esc_url( $product_list->get_permalink() ) ?>"><?php echo esc_html($product_list->get_name()) ?></a></h3>
						<?php endif ?>

						<?php if( $settings['price_toggle'] != 'no' ) : ?>
						<div class="nxtcode-pl__price">
							<?php echo wp_kses_post($product_list->get_price_html()) ?>
						</div>
						<?php endif ?>

						<?php
							if( $settings['hide_content'] != 'no' ) {
								echo apply_filters( 'the_excerpt', wp_trim_words( $product_list->get_description(), $settings['words_length'] ) );
							}
						?>
					</div>
				</div>
			</article>
		<?php endforeach ?>
		</div>
		<?php if ($settings['pagination'] == 'yes') : ?>
			<nav class="woocommerce-pagination"><?php echo SHOPELEMENT_ACT()->du->pagination( $paged, $max_num_products ); ?></nav>
		<?php endif; ?>
		</div>
		<?php
	}
}
