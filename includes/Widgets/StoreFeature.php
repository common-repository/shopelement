<?php

namespace StorePlugin\ShopElement\Widgets;

use \StorePlugin\ShopElement\Widgets\Traits\Style_Control_Trait;
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
 * Elementor Store Feature Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class StoreFeature extends \Elementor\Widget_Base {

	use Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve storefeature widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-store-feature';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve storefeature widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Store Feature', 'shopelement' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve storefeature widget icon.
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
	 * Retrieve the list of categories the storefeature widget belongs to.
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
	 * Retrieve the list of keywords the storefeature widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'storefeature', 'store', 'feature' ];
	}

  /**
	 * Enqueue css dependency for product accordions
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'store-feature' ];
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
	 * Register storefeature widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_storefeature',
			[
				'label' => esc_html__( 'Store Feature', 'shopelement' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Store Feature Preset
		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__( 'Store Feature Style', 'shopelement' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'   => esc_html__( 'Style 1', 'shopelement' ),
					'two'   => esc_html__( 'Style 2', 'shopelement' ),
					'three' => esc_html__( 'Style 3', 'shopelement' ),
					'four'	=> esc_html__( 'Style 4', 'shopelement' ),
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Number', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Number', 'shopelement' ),
				'default' => esc_html__( '01', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout_style' => 'one',
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Feature Image', 'shopelement' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout_style' => ['two','three','four',]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'condition' => [
					'layout_style' => ['two','three','four',]
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'shopelement' ),
				'default' => esc_html__( 'Free Shipping', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Sub Title', 'shopelement' ),
				'default' => esc_html__( 'Capped at $39 per order', 'shopelement' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__( 'Number', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_style' => 'one',
				]
			]
		);

		$this->add_control(
			'heading_number',
			[
				'label' => esc_html__( 'Number', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__icon span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__icon span',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
					'layout_style' => ['two','three','four',]
				],
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-storefeature__icon img', ['default_size' => '120', 'default_unit' => 'px']);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_top_space',
			[
				'label' => esc_html__( 'Spacing Top', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
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
					'{{WRAPPER}} .nxtcode-storefeature__content h3' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => esc_html__( 'Spacing Bottom', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
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
					'{{WRAPPER}} .nxtcode-storefeature__content h3' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__content h3' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__content h3',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__content h3',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__content h3',
			]
		);

		$this->add_control(
			'heading_arrow_line',
			[
				'label' => esc_html__( 'Arrow Line', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'	=> [
					'layout_style'	=> 'four'
				]
			]
		);

		$this->add_control(
			'arrow_line_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__info-four .nxtcode-storefeature__content span' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'arrow_line_angle_color',
			[
				'label' => esc_html__( 'Line Angle Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__info-four .nxtcode-storefeature__content span::after' => 'border-left-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'heading_subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'shopelement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__content p',
				'fields_options' => [
          'typography' => ['default' => 'yes'],
					'font_family' => ['default' => 'Jost',],
        ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__content p',
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
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__info',
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
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__info',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .nxtcode-storefeature__info',
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-storefeature__info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();



	}

	/**
	 * Render storefeature widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'number', 'basic' );
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );

		?>

		<div class="nxtcode-shopelement-widget nxtcode-storefeature__info nxtcode-storefeature__info-<?php echo $settings['layout_style']; ?>">
			<div class="nxtcode-storefeature__icon">
			  <?php if ( $settings['layout_style'] == 'one') : ?>
				<span <?php echo $this->get_render_attribute_string( 'number' ); ?>><?php echo $settings['number']; ?></span>
				<?php endif; ?>
				<?php if ( $settings['layout_style'] == 'two' || $settings['layout_style'] == 'three' || $settings['layout_style'] == 'four') : ?>
					<?php
					if ( ! empty( $settings['image']['url'] ) ) {
						$image_html = wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ) );
						echo $image_html;
					}
					?>
				<?php endif; ?>
			</div>
			<div class="nxtcode-storefeature__content">
				<h3 <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo $settings['title']; ?></h3>
				<?php if ( $settings['layout_style'] == 'four') : ?>
				<span></span>
				<?php endif; ?>
				<p <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>><?php echo $settings['subtitle']; ?></p>
			</div>
		</div>

		<?php
	}

}
