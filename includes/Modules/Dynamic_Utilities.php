<?php

namespace StorePlugin\ShopElement\Modules;

/**
 * Dynamic Utilities contain methods for managing dynamic data within the plugin.
 *
 * This class encapsulates various methods for handling dynamic data within the ShopElement.
 * It provides functionalities related to retrieving, processing, and displaying dynamic content
 * within the plugin's modules and components.
 *
 * @package StorePlugin\ShopElement\Modules
 */
class Dynamic_Utilities {

	/**
	 * Retrieve WooCommerce product types.
	 *
	 * @return array Product types array with a default option.
	 */
	public function get_product_type() {
		return array_merge(['' => esc_html__('Default', 'shopelement')], wc_get_product_types());
	}

	/**
	 * Retrieve published products.
	 *
	 * @return array|\WC_Product[] Array of product objects.
	 */
	protected function get_product_object() {
		// Retrieve published products using WooCommerce function wc_get_products.
		$products = wc_get_products([
			'status'    => 'publish',
			'limit'     => -1,
			'orderby'   => 'ID',
			'order'     => 'ASC',
		]);

		return $products;
	}

	/**
	 * Retrieve the ID of the first published product.
	 *
	 * @return int|null ID of the first published product, or null if no product found.
	 */
	public function get_product_first_id() {
		// Retrieve the array of product objects using the previous function.
		$products = $this->get_product_object();

		// Check if there are any products.
		if (!empty($products)) {
			// Get the ID of the first product in the array.
			$first_id = $products[0]->get_id();
			return $first_id;
		}

		return null;

	}

	/**
	 * Fetch names and IDs of all published products.
	 *
	 * @return array Associative array containing product names as keys and IDs as values.
	 */
	public function fetch_product_name() {
		// Initialize an empty array to store product names and IDs.
		$products_name_id_map = [];

		// Retrieve all published products.
		$products = $this->get_product_object();

		// Populate the array with product names and IDs.
		if (is_array($products) && !empty($products)) {
			foreach ($products as $product) {
				// Get the name and ID of each product and store them in the array.
				$product_name = $product->get_name();
				$product_id = $product->get_id();
				$products_name_id_map[$product_name] = $product_id;
			}
		}

		return $products_name_id_map;
	}

	/**
	 * Retrieve names of all published WooCommerce products.
	 *
	 * @return array The formatted array of product names.
	 */
	public function get_products_name() {
		$products_map = $this->fetch_product_name();

		// Add a default option at the beginning of the array
		// $products_map = array_merge([esc_html__('Default', 'shopelement') => ''], $products_map);

		// Flip the array to make IDs the keys and names the values
		return array_flip($products_map);
	}

    /**
	 * Retrieve product taxonomies in a formatted array.
	 *
	 * @param string $taxonomy The taxonomy to retrieve terms from.
	 * @param bool   $default  Whether to include a default option.
	 * @param string $term_key The key to use for terms.
	 *
	 * @return array The formatted array of taxonomies.
	 */
	public function product_taxonomies($taxonomy, $default = true, $term_key = 'slug') {
		$terms_arr = [];

		// Retrieve terms from the specified taxonomy
		$terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

		// Add default option if required
		if ($default) {
			$terms_arr[] = [esc_html__('Default', 'shopelement') => ''];
		}

		// If terms exist and are non-empty, format them
		if (is_array($terms) && !empty($terms)) {
			foreach ($terms as $term) {
				$terms_arr[] = [ esc_html( $term->name ) => $term->$term_key ];
			}
		}

		// Merge the arrays and flip them for key-value reversal
		$get_terms = array_merge(...$terms_arr);
		return array_flip($get_terms);
	}

	/**
	 * Generate pagination links for WooCommerce products.
	 *
	 * @param int $paged            Current page number.
	 * @param int $max_num_products Total number of products.
	 *
	 * @return string               HTML for pagination links.
	 */
	public function pagination($paged, $max_num_products) {
		// Fetch base URL for pagination
		$base = esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));

		// Generate pagination links
		return paginate_links(
			apply_filters(
				'woocommerce_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					// 'format'    => '',
					'add_args'  => false,
					'current'   => $paged,
					'total'     => $max_num_products,
					'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
					'next_text' => is_rtl() ? '&larr;' : '&rarr;',
					'type'      => 'list',
					'end_size'  => 3,
					'mid_size'  => 3,
				)
			)
		);
	}

	/**
	 * Generate HTML for star ratings based on WooCommerce product ratings.
	 *
	 * @param object $wc_products The WooCommerce product object.
	 *
	 * @return void The HTML for star ratings.
	 */
	public function render_star_ratings_HTML( $rating ) {
		// Calculate the average rating and convert it to percentage
		$average = is_object( $rating ) ? $rating->get_average_rating() : $rating;
		$ratings = ( is_object( $rating ) ? ( $average / 5 ) * 100 : ( $average * 20 ) );

		// Generate HTML for star ratings
		printf(
			'<div class="rating-icon">
				<svg class="rating-icon__fill" width="83" height="15" viewBox="0 0 83 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_19_392)"><path d="M15 5.79538L9.54964 5.43705L7.49701 0.280334L5.44439 5.43705L0 5.79538L4.1758 9.34107L2.80553 14.7197L7.49701 11.7542L12.1885 14.7197L10.8183 9.34107L15 5.79538Z" fill="#cccccc" /></g><g clip-path="url(#clip1_19_392)"><path d="M32 5.79538L26.5496 5.43705L24.497 0.280334L22.4444 5.43705L17 5.79538L21.1758 9.34107L19.8055 14.7197L24.497 11.7542L29.1885 14.7197L27.8183 9.34107L32 5.79538Z" fill="#cccccc" /></g><g clip-path="url(#clip2_19_392)"><path d="M49 5.79538L43.5496 5.43705L41.497 0.280334L39.4444 5.43705L34 5.79538L38.1758 9.34107L36.8055 14.7197L41.497 11.7542L46.1885 14.7197L44.8183 9.34107L49 5.79538Z" fill="#cccccc" /></g><g clip-path="url(#clip3_19_392)"><path d="M66 5.79538L60.5496 5.43705L58.497 0.280334L56.4444 5.43705L51 5.79538L55.1758 9.34107L53.8055 14.7197L58.497 11.7542L63.1885 14.7197L61.8183 9.34107L66 5.79538Z" fill="#cccccc" /></g><g clip-path="url(#clip4_19_392)"><path d="M83 5.79538L77.5496 5.43705L75.497 0.280334L73.4444 5.43705L68 5.79538L72.1758 9.34107L70.8055 14.7197L75.497 11.7542L80.1885 14.7197L78.8183 9.34107L83 5.79538Z" fill="#cccccc" /></g><defs><clipPath id="clip0_19_392"><rect width="15" height="15" fill="white" /></clipPath><clipPath id="clip1_19_392"><rect width="15" height="15" fill="white" transform="translate(17)" /></clipPath><clipPath id="clip2_19_392"><rect width="15" height="15" fill="white" transform="translate(34)" /></clipPath><clipPath id="clip3_19_392"><rect width="15" height="15" fill="white" transform="translate(51)" /></clipPath><clipPath id="clip4_19_392"><rect width="15" height="15" fill="white" transform="translate(68)" /></clipPath></defs>
				</svg>
				<div class="rating-icon__active" style="width: %s">
					<div class="rating-icon__active-width">
						<svg class="rating-icon__fill-active" width="83" height="15" viewBox="0 0 83 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_19_392)"><path d="M15 5.79538L9.54964 5.43705L7.49701 0.280334L5.44439 5.43705L0 5.79538L4.1758 9.34107L2.80553 14.7197L7.49701 11.7542L12.1885 14.7197L10.8183 9.34107L15 5.79538Z" fill="#FF9900" /></g><g clip-path="url(#clip1_19_392)"><path d="M32 5.79538L26.5496 5.43705L24.497 0.280334L22.4444 5.43705L17 5.79538L21.1758 9.34107L19.8055 14.7197L24.497 11.7542L29.1885 14.7197L27.8183 9.34107L32 5.79538Z" fill="#FF9900" /></g><g clip-path="url(#clip2_19_392)"><path d="M49 5.79538L43.5496 5.43705L41.497 0.280334L39.4444 5.43705L34 5.79538L38.1758 9.34107L36.8055 14.7197L41.497 11.7542L46.1885 14.7197L44.8183 9.34107L49 5.79538Z" fill="#FF9900" /></g><g clip-path="url(#clip3_19_392)"><path d="M66 5.79538L60.5496 5.43705L58.497 0.280334L56.4444 5.43705L51 5.79538L55.1758 9.34107L53.8055 14.7197L58.497 11.7542L63.1885 14.7197L61.8183 9.34107L66 5.79538Z" fill="#FF9900" /></g><g clip-path="url(#clip4_19_392)"><path d="M83 5.79538L77.5496 5.43705L75.497 0.280334L73.4444 5.43705L68 5.79538L72.1758 9.34107L70.8055 14.7197L75.497 11.7542L80.1885 14.7197L78.8183 9.34107L83 5.79538Z" fill="#FF9900" /></g><defs><clipPath id="clip0_19_392"><rect width="15" height="15" fill="white" /></clipPath><clipPath id="clip1_19_392"><rect width="15" height="15" fill="white" transform="translate(17)" /></clipPath><clipPath id="clip2_19_392"><rect width="15" height="15" fill="white" transform="translate(34)" /></clipPath><clipPath id="clip3_19_392"><rect width="15" height="15" fill="white" transform="translate(51)" /></clipPath><clipPath id="clip4_19_392"><rect width="15" height="15" fill="white" transform="translate(68)" /></clipPath></defs>
						</svg>
					</div>
				</div>
			</div>',
			esc_attr( "{$ratings}%" ),
		);
	}

	/**
	 * Render review counts for Woo products
	 *
	 * @param int $review_count It needs get_review_count() method
	 * @return void
	 */
	public function render_review_count_HTML( $review_count ) {
		printf(
			'<span>%d %s</span>',
			absint( $review_count ),
			( $review_count > 1 ) ? esc_html__( 'reviews', 'shopelement' ) : esc_html__( 'review', 'shopelement' )
		);
	}

	/**
	 * Render WooCommerce Category count.
	 *
	 * @param int $category_count
	 * @return void
	 */
	public function render_category_count_HTML( $category_count ) {
		printf(
			'<div class="nxtcode-product-category__number">
				<span>%d %s</span>
			</div>',
			absint( $category_count ),
			( $category_count > 1 ) ? esc_html__( 'Products', 'shopelement' ) : esc_html__( 'Product', 'shopelement' )
		);
	}

	/**
	 * Display the discount percentage for a WooCommerce product.
	 *
	 * @param object $wc_products The WooCommerce product object.
	 */
	public function render_price_discount_HTML($wc_product) {
		// Get regular and sale prices, strip tags, and convert to float
		$regular_price = floatval(wp_strip_all_tags($wc_product->get_regular_price()));
		$sale_price = floatval(wp_strip_all_tags($wc_product->get_sale_price()));

		// Check if regular price or sale price is empty.
		if( ( empty( $regular_price ) || empty( $sale_price ) ) ) {
			return;
		}

		// Calculate the discount percentage
		$discount = round(($regular_price - $sale_price) / $regular_price * 100);

		// Display the discount percentage
		printf( '<span>%d%%</span>', esc_html( "-{$discount}" ) );
	}

}
