<?php

namespace StorePlugin\ShopElement\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Stroke;
use \Elementor\Group_Control_Text_Shadow;

/**
 * Elementor Product Category Widget.
 *
 * @since 1.0.0
 */
class ProductCategory extends \Elementor\Widget_Base {

	use \StorePlugin\ShopElement\Widgets\Traits\Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve product category widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-product-category';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve product category widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('Product Category', 'shopelement');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve category widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-categories';
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
		return ['products', 'list', 'products list'];
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
		return ['product-category'];
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
		 * Start Content Tab
		 * ============================================================
		 */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'shopelement'),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__('Product list style', 'shopelement'),
				'type' => Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'  => esc_html__('Style 1', 'shopelement'),
					'two' => esc_html__('Style 2', 'shopelement'),
					'three' => esc_html__('Style 3', 'shopelement'),
				],
				'separator' => 'after',
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

		$this->add_responsive_control(
			'item_per_row',
			[
				'label' 		=> esc_html__('Category per row', 'shopelement'),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 2,
				'max' 			=> 5,
				'step' 			=> 1,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product-category__info' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
				],
				'condition' => [
					'layout_style' => ['one']
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__('Query', 'shopelement'),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_style' => ['one']
				]
			]
		);

		$this->add_control(
			'item_per_page',
			[
				'label' 		=> esc_html__('Categories per page', 'shopelement'),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 0,
				'max' 			=> 100,
				'step' 			=> 1,
				'default' 		=> 0,
			]
		);

		$this->add_control(
			'category_query',
			[
				'label' => esc_html__('Query category', 'shopelement'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'0' => esc_html__( 'Category (Parent Only)', 'shopelement' ),
					'child' => esc_html__( 'Category (Child Only)', 'shopelement' ),
					''  => esc_html__( 'All category', 'shopelement' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' 		=> esc_html__('Order by', 'shopelement'),
				'label_block'	=> true,
				'type' 			=> Controls_Manager::SELECT,
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
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					''		=> esc_html__('Default', 'shopelement'),
					'ASC'	=> esc_html__('ASC', 'shopelement'),
					'DESC'	=> esc_html__('DESC', 'shopelement'),
				],
			]
		);

		$this->add_control(
			'include_cats',
			[
				'label' => esc_html__('Include Category', 'shopelement'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => SHOPELEMENT_ACT()->du->product_taxonomies( 'product_cat', false, 'term_id' ),
			]
		);

		$this->add_control(
			'exclude_cats',
			[
				'label' => esc_html__('Exclude Category', 'shopelement'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => SHOPELEMENT_ACT()->du->product_taxonomies( 'product_cat', false, 'term_id' ),
			]
		);

		$this->add_control(
			'hide_empty_cat',
			[
				'label' => esc_html__('Hide empty', 'shopelement'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'shopelement'),
				'label_off' => esc_html__('No', 'shopelement'),
				'return_value' => '1',
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
			'category_content_section',
			[
				'label' => esc_html__('Content', 'shopelement'),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__('Title', 'shopelement'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_top_space',
			[
				'label' => esc_html__('Spacing Top', 'shopelement'),
				'type' => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .nxtcode-product-category__content > h4' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => esc_html__('Spacing Bottom', 'shopelement'),
				'type' => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .nxtcode-product-category__content > h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'shopelement'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product-category__content > h4 > a' => 'color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Hover Color', 'shopelement'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product-category__content > h4 > a:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .nxtcode-product-category__content > h4 > a',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Plus Jakarta Sans',],
        ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .nxtcode-product-category__content > h4',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-product-category__content > h4',
			]
		);

		$this->end_controls_section();

		// Image style section
		$this->start_controls_section(
			'category_image',
			[
				'label' => esc_html__('Image', 'shopelement'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-product-category__thumbnail img', ['default_size' => '220', 'default_unit' => 'px']);

		$this->end_controls_section();

		// List style section
		$this->start_controls_section(
			'category_grid_style_section',
			[
				'label' => esc_html__('Grid', 'shopelement'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_gap_space',
			[
				'label' => esc_html__('Column Gap', 'shopelement'),
				'type' => Controls_Manager::SLIDER,
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
				'default'	=> [
					'unit'	=> 'px',
					'size'	=> '30'
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product-category__info' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_bottom_space',
			[
				'label' => esc_html__('Bottom space', 'shopelement'),
				'type' => Controls_Manager::SLIDER,
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
				'default'	=> [
					'unit'	=> 'px',
					'size'	=> '30'
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-product-category__info' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
				'src' => '/assets/images/pro/product-category-2.jpg',
				'alt' => 'product cateogry two'
			],
			'three' => [
				'src' => '/assets/images/pro/product-category-3.jpg',
				'alt' => 'product cateogry three'
			],
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

		$cat_query = $settings['category_query'];
		$args	= [
			'taxonomy'		=> 'product_cat',
			'orderby'		=> $settings['orderby'],
			'order'			=> $settings['order'],
			'number'		=> $settings['item_per_page'],
			'include'		=> $settings['include_cats'],
			'exclude'		=> $settings['exclude_cats'],
			'hide_empty'	=> $settings['hide_empty_cat'],
			'pad_counts'	=> 1,
			'hierarchical'	=> 1,
		];

		$cat_query = ( $cat_query == '' || $cat_query == '0' ) ? ( $args['parent'] = $cat_query ) : $cat_query;
		$categories = get_terms( $args );

		if( is_array( $categories ) && ! empty( $categories ) ) {
			echo '<div class="nxtcode-shopelement-widget nxtcode-product-category__info nxtcode-product-category__info-',$settings['layout_style'],'">';
				foreach( $categories as $category ) :
					if( $cat_query == 'child' && $category->parent == 0 ) continue;
					$category_thumb_id 	= get_term_meta( $category->term_id, 'thumbnail_id', true );
					$category_thumb 	= wp_get_attachment_url( $category_thumb_id );
					?>
					<div class="nxtcode-product-category__single">
						<div class="nxtcode-product-category__single-inner">
							<div class="nxtcode-product-category__thumbnail">
								<?php if( $category_thumb ) : ?>
									<img src="<?php echo esc_url( $category_thumb ) ?>" alt="Product">
								<?php else: ?>
									<img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ) ?>" alt="Product">
								<?php endif ?>
								<div class="nxtcode-product-category__count">
									<span><?php echo esc_html( $category->count ) ?></span>
								</div>
							</div>
							<div class="nxtcode-product-category__content">
								<h4>
									<a href="<?php echo esc_url( get_term_link( $category, $category->taxonomy ) ) ?>">
										<?php echo esc_html( $category->name ) ?>
									</a>
								</h4>
								<div class="nxtcode-product-category__view">
									<a href="<?php echo esc_url( get_term_link( $category, $category->taxonomy ) ) ?>"><?php esc_html_e( 'View All', 'shopelement' ) ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				</div>
			<?php
		}
	}
}
