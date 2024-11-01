<?php

namespace StorePlugin\ShopElement\Widgets;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Text_Stroke;
use \Elementor\Icons_Manager;

/**
 * Elementor Customer Review Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class CustomerReview extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve customerreview widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-customer-review';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve customerreview widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Customer Review', 'shopelement' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve customerreview widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the customerreview widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'shopelement_cat' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the customerreview widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'customerreview', 'customer', 'review' ];
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

	public function get_style_depends() {
		return ['customer-review-carousel', 'customer-review'];
	}

	/**
	 * Register customerreview widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_customerreview',
			[
				'label' => esc_html__( 'Customer Review', 'shopelement' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// Customer Review Preset

		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__( 'Review Style', 'shopelement' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'two',
				'options' => [
					'one'   => esc_html__( 'Style 1', 'shopelement' ),
					'two'   => esc_html__( 'Style 2', 'shopelement' ),
					'three' => esc_html__( 'Style 3', 'shopelement' ),
					'four'	=> esc_html__( 'Style 4', 'shopelement' ),
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
							'one',
							'three',
						],
					],
				]
			);
		endif;

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'shopelement' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Content', 'shopelement' ),
				'default' => esc_html__( 'Duis aute irure dolor in reprehenderit voluptate velit esse cillum dolore eu fugiat excepteur sint occaecat cupidatat non proident, sunt in officia deserunt mollit anim', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout_style' => ['two','four']
				]
			]
		);

		$this->add_control(
			'avatar',
			[
				'label' => esc_html__( 'Reviewer Avatar', 'shopelement' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout_style' => ['two','four',]
				]
			]
		);

		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Reviewer Name', 'shopelement' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Reviewer Name', 'shopelement' ),
				'default' => esc_html__( 'Nicolas Jone', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout_style' => ['two','four']
				]
			]
		);

		$this->add_control(
			'designation',
			[
				'label' => esc_html__( 'Reviewer Designation', 'shopelement' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Reviewer Designation', 'shopelement' ),
				'default' => esc_html__( 'Store Customer', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout_style' => ['two']
				]
			]
		);

		$this->add_control(
			'reviewer_rating_icon',
			[
				'label' => esc_html__( 'Reviewer Rating', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', ],
				'range' => [
					'%' => [
						'min' => 1,
						'step'	=> 0.1,
						'max' => 5,
					]
				],
				'default' => [
					'unit'	=> '%',
					'size'	=> 5
				],
				'condition'	=> [
					'layout_style'	=> ['two', 'four']
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_review',
			[
				'label' => esc_html__( 'Content', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'review_description',
			[
				'label' => esc_html__( 'Description', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'review_description_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'review_description_typography',
				'selector' => '{{WRAPPER}} .nxtcode-review__content p',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
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

		$this->start_controls_section(
			'section_style_reviewer',
			[
				'label' => esc_html__( 'Reviewer Info', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'reviewer_avatar',
			[
				'label' => esc_html__( 'Avatar', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_responsive_control(
			'width_',
			[
				'label' => esc_html__( 'Width', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'size'	=> '80',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-avatar img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'size'	=> '80',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-avatar img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'shopelement' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'shopelement' ),
					'fill' => esc_html__( 'Fill', 'shopelement' ),
					'cover' => esc_html__( 'Cover', 'shopelement' ),
					'contain' => esc_html__( 'Contain', 'shopelement' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-avatar img' => 'object-fit: {{VALUE}};',
				],
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .nxtcode-review__reviewer-avatar img',
				'separator' => 'before',
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout_style!' => 'one',
				]
			]
		);

		$this->add_control(
			'reviewer_name',
			[
				'label' => esc_html__( 'Name', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'reviewer_name_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-info h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'reviewer_name_typography',
				'selector' => '{{WRAPPER}} .nxtcode-review__reviewer-info h3',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->add_control(
			'reviewer_designation',
			[
				'label' => esc_html__( 'Designation', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style' => ['two']
				]
			]
		);

		$this->add_control(
			'reviewer_designation_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__reviewer-info h5' => 'color: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => ['two']
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'reviewer_designation_typography',
				'selector' => '{{WRAPPER}} .nxtcode-review__reviewer-info h5',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
				'condition' => [
					'layout_style' => ['two']
				]
			]
		);

	$this->end_controls_section();

    $this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .nxtcode-review__info',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'selector' => '{{WRAPPER}} .nxtcode-review__info',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .nxtcode-review__info',
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-review__info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
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
			'one' => [
				'src' => '/assets/images/pro/customer-review-1.jpg',
				'alt' => 'customer review one'
			],
			'three' => [
				'src' => '/assets/images/pro/customer-review-3.jpg',
				'alt' => 'customer review three'
			],
		];
	}

	/**
	 * Render customerreview widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
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

		$this->add_inline_editing_attributes( 'name', 'basic' );
		$this->add_inline_editing_attributes( 'designation', 'basic' );
		$this->add_inline_editing_attributes( 'review_title', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );

		?>

    	<div class="nxtcode-shopelement-widget nxtcode-review__info nxtcode-review__info-<?php echo $settings['layout_style']; ?>">
			<div class="nxtcode-review__header">
				<div class="nxtcode-review__reviewer">
				  <?php if ( $settings['layout_style'] !== 'one') : ?>
					<div class="nxtcode-review__reviewer-avatar">
						<img src="<?php echo $settings['avatar']['url']; ?>" alt="">
					</div>
					<?php endif; ?>
					<div class="nxtcode-review__reviewer-info">
						<div class="nxtcode-review__rating">
							<?php echo SHOPELEMENT_ACT()->du->render_star_ratings_HTML( $settings['reviewer_rating_icon']['size'] ) ?>
						</div>
						<div class="nxtcode-review__name">
							<h3 <?php echo $this->get_render_attribute_string( 'name' ); ?>><?php echo $settings['name']; ?></h3>
							<?php if ( $settings['layout_style'] == 'two' ) : ?>
							<h5 <?php echo $this->get_render_attribute_string( 'designation' ); ?>><?php echo $settings['designation']; ?></h5>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="nxtcode-review__content">
				<p <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo $settings['description']; ?></p>
			</div>
		</div>

		<?php
	}

}
