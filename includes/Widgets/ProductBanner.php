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
 * Elementor Product Banner Widget.
 *
 * @since 1.0.0
 */
class ProductBanner extends Widget_Base {

    use Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-product-banner';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Banner', 'shopelement' );
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
		return 'eicon-bullet-list';
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
		return [ 'shopelement_cat' ];
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
		return [ 'product banner', 'banner', 'product'];
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
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Banner Content', 'shopelement' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        // banner style preset
        $this->add_control(
            'layout_style',
            [
                'label' => esc_html__( 'Banner Style', 'shopelement' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'one',
                'options' => [
                    'one'  => esc_html__( 'Style 1', 'shopelement' ),
                    'two' => esc_html__( 'Style 2', 'shopelement' ),
                    'three' => esc_html__( 'Style 3', 'shopelement' ),
					'four'	=> esc_html__( 'Style 4', 'shopelement' ),
					'five'	=> esc_html__( 'Style 5', 'shopelement' ),
					'six'	=> esc_html__( 'Style 6', 'shopelement' ),
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
							'five',
							'six'
						],
					],
				]
			);
		endif;

        // sub title
        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'shopelement' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'UP TO 60% OFF', 'shopelement' ),
                'placeholder' => esc_html__( 'Enter your sub title', 'shopelement' ),
                'label_block' => true,
				'condition' => [
					'layout_style' => ['one']
				]
            ]
        );

        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'shopelement' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Better Quality Better Services for Your Furniture', 'shopelement' ),
				'placeholder' => esc_html__( 'Enter your title', 'shopelement' ),
				'label_block' => true,
				'condition' => [
					'layout_style' => ['one', 'four']
				]
			]
		);

        // button text
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'shopelement' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Shop Now', 'shopelement' ),
                'placeholder' => esc_html__( 'Enter your button text', 'shopelement' ),
				'condition' => [
					'layout_style' => ['one', 'four']
				]
            ]
        );

        // button link
        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'shopelement' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
					'url' => '#',
				],
                'placeholder' => esc_html__( '#', 'shopelement' ),
				'condition' => [
					'layout_style' => ['one', 'four']
				]
            ]
        );

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'shopelement' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'layout_style' => ['one', 'four']
				],
				//'icon_exclude_inline_options' => $args['icon_exclude_inline_options'],
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'shopelement' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => esc_html__( 'Before', 'shopelement' ),
					'right' => esc_html__( 'After', 'shopelement' ),
				],
				'condition' => [
					'layout_style' => ['one', 'four']
				]
			]
		);

		$this->add_control(
			'button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'shopelement' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 50,
					],
					'em' => [
						'max' => 5,
					],
					'rem' => [
						'max' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-productbanner__btn-content' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => ['one', 'four']
				]
			]
		);

        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Product Image', 'shopelement' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'layout_style' => ['one', 'four']
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
				'separator' => 'none',
				'condition' => [
					'image[url]!' => '',
					'layout_style' => ['one', 'four']
				],
			]
		);

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
					'{{WRAPPER}} .nxtcode-productbanner__content > h3' => 'padding-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .nxtcode-productbanner__content > h3' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .nxtcode-productbanner__content > h3' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content > h3',
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
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content > h3',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content > h3',
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
					'{{WRAPPER}} .nxtcode-productbanner__content > span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content > span',
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
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content > span',
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
				],
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-productbanner__thumbnail img', ['default_size' => '220', 'default_unit' => 'px']);

		$this->end_controls_section();


        $this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'shopelement' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_style!' => 'two'
				]
			]
		);

        $this->general_button_style_control('{{WRAPPER}} .nxtcode-productbanner-button');

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
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__single',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_background',

				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__content',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
						'label' => esc_html__( 'Title Background Type', 'shopelement' ),
					],
					'color' => [
						'label' => esc_html__( 'Title Background Color', 'shopelement' ),
					],
				],
				'condition' => [
					'layout_style' => 'four'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'selector' => '{{WRAPPER}} .nxtcode-productbanner__single',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-productbanner__single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'shopelement' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .nxtcode-productbanner__single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'two' => [
				'src' => '/assets/images/pro/product-banner-2.jpg',
				'alt' => 'product banner two'
			],
			'three' => [
				'src' => '/assets/images/pro/product-banner-3.jpg',
				'alt' => 'product banner three'
			],
			'five' => [
				'src' => '/assets/images/pro/product-banner-5.jpg',
				'alt' => 'product banner five'
			],
			'six' => [
				'src' => '/assets/images/pro/product-banner-6.jpg',
				'alt' => 'product banner six'
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

		?>
        <div class="nxtcode-shopelement-widget nxtcode-productbanner__info nxtcode-productbanner__info-<?php echo $settings['layout_style']; ?>">
			<div class="nxtcode-productbanner__single">
				<div class="nxtcode-productbanner__content">
					<?php if ( ! empty( $settings['sub_title'] ) ) : ?>
					<span><?php echo $settings['sub_title']; ?></span>
					<?php endif; ?>
					<h3><?php echo $settings['title']; ?></h3>
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
					<a href="<?php echo $settings['link']['url']; ?>" class="nxtcode-productbanner__btn">
						<span class="nxtcode-productbanner__btn-content">
							<span><?php echo $settings['button_text']; ?></span>
							<?php
							if ( ! empty( $settings['button_icon'] ) ) {
								echo '<span class="nxtcode-productbanner__btn-icon nxtcode-productbanner__btn-icon-align-' . $settings['button_icon_align'] . '">';
								Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
								echo '</span>';
							}
							?>
						</span>
					</a>
					<?php endif; ?>
				</div>
				<div class="nxtcode-productbanner__thumbnail">
					<?php
					if ( ! empty( $settings['image']['url'] ) ) {
						$image_html = wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ) );

						echo $image_html;
					}
					//echo '<img src="' . esc_url( $settings['image']['url'] ) . '" class="elementor-animation-'. $settings['hover_animation'] .'" alt="">';?>
				</div>
			</div>
      	</div>
		<?php
	}

}
