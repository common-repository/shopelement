<?php

namespace StorePlugin\ShopElement\Widgets;

/**
 * Elementor Brand Logo Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class BrandLogo extends \Elementor\Widget_Base {

	use \StorePlugin\ShopElement\Widgets\Traits\Style_Control_Trait;

	/**
	 * Get widget name.
	 *
	 * Retrieve brand logo widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'shopelement-brand-logo';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve brand logo widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('Brand Logo', 'shopelement');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve brand-logo widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-site-logo';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the brand-logo of categories the brand-logo widget belongs to.
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
	 * Retrieve the brand-logo of keywords the brand-logo widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return ['brand-logo', 'brand-logos', 'ordered', 'unordered'];
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
		return ['product-brand-logo', 'slick-style'];
	}

	/**
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return ['jquery','slick-script'];
	}

	/**
	 * Register brand logo widget controls.
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
				'label' => esc_html__('Brand logo style', 'shopelement'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'  => esc_html__('Style 1', 'shopelement'),
					'two' => esc_html__('Style 2', 'shopelement'),
				],
				'separator'	=> 'after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'shopelement'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* Start repeater */
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'brand_logo_id',
			[
				'label' => esc_html__('Brand Logo ID', 'shopelement'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Logo ID', 'shopelement'),
				'default' => esc_html__('logo #1', 'shopelement'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'shop_brand_logo',
			[
				'label' => esc_html__('Choose Logo', 'shopelement'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'brand_logo_link',
			[
				'label' => esc_html__('Link', 'shopelement'),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		/* End repeater */

		$this->add_control(
			'brand_logo_items',
			[
				'label' => esc_html__('Brand Logo Items', 'shopelement'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #1', 'shopelement'),
						'link' => '',
					],
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #2', 'shopelement'),
						'link' => '',
					],
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #3', 'shopelement'),
						'link' => '',
					],
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #4', 'shopelement'),
						'link' => '',
					],
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #5', 'shopelement'),
						'link' => '',
					],
					[
						'brand_logo_id' => esc_html__('Brand Logo Item #6', 'shopelement'),
						'link' => '',
					],
				],
				'title_field' => '{{{ brand_logo_id }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_options_section',
			[
				'label' => esc_html__('Slider Options', 'shopelement'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
				'desktop_default' => 5,
				'tablet_default' => 3,
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

		// Image style section
		$this->start_controls_section(
			'product_list_image',
			[
				'label' => esc_html__('Image', 'shopelement'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->general_image_style_control('{{WRAPPER}} .nxtcode-brandlogo__slide > a > img', ['default_size' => '220', 'default_unit' => 'px']);

		$this->end_controls_section();
	}

	/**
	 * Render brand logo widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="nxtcode-shopelement-widget nxtcode-brandlogo__info nxtcode-brandlogo__info-<?php echo esc_html( $settings['layout_style'] ) ?>">
			<div class="nxtcode-brandlogo__slider nxtcode-brandlogo-slider-<?php echo esc_attr( $this->get_id());?>">
				<?php
				foreach ($settings['brand_logo_items'] as $index => $item) {
					$repeater_setting_key = $this->get_repeater_setting_key('logo', 'brand_items', $index);
					$this->add_render_attribute($repeater_setting_key, 'class', 'brand-single-slide');
					$this->add_inline_editing_attributes($repeater_setting_key);
					$this->add_link_attributes("link_{$index}", $item['brand_logo_link']);
				?>
					<div <?php $this->print_render_attribute_string($repeater_setting_key); ?>>
						<div class="nxtcode-brandlogo__slide">
							<?php
							printf(
								'<a %1$s>
									<img src="%2$s" alt="Brand logo">
								</a>',
								$this->get_render_attribute_string("link_{$index}"),
								$item['shop_brand_logo']['url']
							);
							?>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(function($){
    			$(document).ready(function() {
					$("<?php echo '.nxtcode-brandlogo-slider-' . esc_attr( $this->get_id()) ?>").slick({
      					slidesToShow: <?php echo esc_attr( isset( $settings['item_per_row'] ) && $settings['item_per_row'] > 0 ? $settings['item_per_row'] : 5 ); ?>,
      					slidesToScroll: 1,
      					autoplay: <?php echo $settings['slider_autoplay'] == 'true' ? 'true' : 'false' ?>,
      					infinite: <?php echo $settings['slider_infinite'] == 'true' ? 'true' : 'false' ?>,
      					swipeToSlide: true,
						dots: true,
      					pauseOnHover: <?php echo $settings['slider_pauseOnHover'] == 'true' ? 'true' : 'false';?>,
      					responsive: [
							{
								breakpoint: 1024,
								settings: {
									slidesToShow: <?php echo esc_attr( isset( $settings['item_per_row_tablet'] ) && $settings['item_per_row_tablet'] > 0 ? $settings['item_per_row_tablet'] : 3 ); ?>
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
