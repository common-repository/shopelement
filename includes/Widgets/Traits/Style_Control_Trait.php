<?php
namespace StorePlugin\ShopElement\Widgets\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Button_Style_Trait
 *
 * @since 1.0.0
 */

trait Style_Control_Trait {


    /**
     * General button style control
     *
     * @param string $selector
     */
    public function general_button_style_control($selector) {
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => $selector,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'button_text_shadow',
				'selector' => $selector,
			]
		);

        $this->start_controls_tabs( 'tabs_button_style', [
			//'condition' => $args['section_condition'],
		] );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'shopelement' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => $selector,
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'shopelement' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					"{$selector}:hover, {$selector}:focus" => 'color: {{VALUE}};',
					"{$selector}:hover svg, {$selector}:focus svg" => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => "{$selector}:hover, {$selector}:focus",
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'shopelement' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					"{$selector}:hover, {$selector}:focus" => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'shopelement' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => $selector,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => $selector,
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label' => esc_html__( 'Padding', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
    }

    /**
     * General image style control
     */
    public function general_image_style_control($selector, $args = []) {
        $this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Width', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				// 'default' => [
				// 	'size' => $args['default_size'] ?? 100,
				// 	'unit' => $args['default_unit'] ?? '%',
				// ],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                    ],
				],
				'selectors' => [
					$selector => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => $selector,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'separator' => 'after',
				'selectors' => [
					$selector => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'shopelement' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'shopelement' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => $selector,
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__( 'Opacity', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					$selector => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'shopelement' ) . ' (s)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					$selector => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'shopelement' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => $selector,
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					$selector => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
    }

	/**
	 * Pagination style section
	 *
	 * @param string $selector
	 * @return void
	 */
	public function general_pagination_style_control( $selector ) {
		$this->add_responsive_control(
			'pagination_width',
			[
				'label' => esc_html__( 'Width', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					"{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers" => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_height',
			[
				'label' => esc_html__( 'Height', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					"{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers" => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_top_space',
			[
				'label' => esc_html__( 'Top space', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					"{{WRAPPER}} {$selector} .woocommerce-pagination" => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_bottom_space',
			[
				'label' => esc_html__( 'Bottom space', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					"{{WRAPPER}} {$selector} .woocommerce-pagination" => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'paginate_shape_style',
			[
				'label' => esc_html__( 'Border radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 4,
					'right' => 4,
					'bottom' => 4,
					'left' => 4,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > span" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > a" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label' => esc_html__( 'Alignment', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'shopelement' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'shopelement' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'shopelement' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					"{{WRAPPER}} {$selector} .woocommerce-pagination ul" => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => "{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers",
			]
		);

		$this->add_control(
			'pagination_color_title',
			[
				'label' => esc_html__( 'Colors', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		// Colors tab
		$this->start_controls_tabs( 'pagination_color_style_tab' );
		$this->start_controls_tab(
			'tab_pagi_color_normal',
			[
				'label' => esc_html__( 'Normal', 'shopelement' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > a" => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > a" => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label' => esc_html__( 'Active Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > span" => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_bg_color',
			[
				'label' => esc_html__( 'Active BG Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li > span" => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_border_title',
			[
				'label' => esc_html__( 'Border', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'pagination_border',
				'selector' => "{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers",
			]
		);

		$this->add_control(
			'pagination_active_border_title',
			[
				'label' => esc_html__( 'Border for Active Tab', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'pagination_active_border',
				'selector' => "{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers.current",
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagi_color_hover',
			[
				'label' => esc_html__( 'Hover', 'shopelement' ),
			]
		);

		$this->add_control(
			'pagination_color_hover',
			[
				'label' => esc_html__( 'Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li:hover > a" => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_bg_color_hover',
			[
				'label' => esc_html__( 'BG Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li:hover > a" => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_color_hover',
			[
				'label' => esc_html__( 'Active Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li:hover > span" => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_bg_color_hover',
			[
				'label' => esc_html__( 'Active BG Color', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} {$selector} nav.woocommerce-pagination > ul.page-numbers > li:hover > span" => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_hover_border_title',
			[
				'label' => esc_html__( 'Border', 'shopelement' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'pagination_hover_border',
				'selector' => "{{WRAPPER}} {$selector} .woocommerce-pagination .page-numbers li .page-numbers:hover",
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
	}

}