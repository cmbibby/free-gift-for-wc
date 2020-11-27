<?php
namespace Free_Gift_WC;
class Settings {


	public function __construct() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'free_gift_add_settings_tab' ) );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'free_gift_settings' ), 10, 2 );
	}


	public function free_gift_add_settings_tab( $settings_tab ) {
		$settings_tab['product_free_gift'] = __( 'Free Gift Product', 'free-gift-for-wc' );
		return $settings_tab;
	}


	public function free_gift_settings( $settings, $current_section ) {
		if ( 'product_free_gift' == $current_section ) {
			$custom_settings = array(
				array(
					'name' => __( 'Free Gift Product', 'free-gift-for-wc' ),
					'type' => 'title',
					'desc' => __( 'Add a free gift in cart over a certain spend', 'free-gift-for-wc' ),
					'id'   => 'wc_free_gift',
					'css'  => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Enable', 'free-gift-for-wc' ),
					'desc'    => __( 'Enable free gift in cart', 'free-gift-for-wc' ),
					'id'      => 'wc_free_gift_enable',
					'default' => 'no',
					'type'    => 'checkbox',
					'css'     => 'min-width:200px;',
				),
				array(
					'title'    => __( 'Free Product', 'free-gift-for-wc' ),
					'type'     => 'select',
					'desc_tip' => __( 'The Product ID of the gift product', 'free-gift-for-wc' ),
					'id'       => 'wc_free_gift_product_id',
					'options'  => $this->get_products(),
				),
				array(
					'title'    => __( 'Cart Subtotal Value', 'free-gift-for-wc' ),
					'type'     => 'number',
					'desc_tip' => __( 'The value above to apply the free gift', 'free-gift-for-wc' ),
					'default'  => 0,
					'id'       => 'wc_free_gift_cart_amount',
				),
				array(
					'title'    => 'Excluded roles',
					'type'     => 'multiselect',
					'desc_tip' => 'Don\'t allow these roles to get a free gift',
					'id'       => 'wc_free_gift_excluded_roles',
					'options'  => $this->get_user_roles(),
				),

				'section_end' => array(
					'type' => 'sectionend',
					'id'   => 'wc_free_gift',
				),
			);
			return $custom_settings;
		} else {
			return $settings;
		}
	}

	protected function get_user_roles() {
		$roles = new \WP_Roles;
		return $roles->get_names();
	}

	public static function get_product_id() {
		return get_option( 'wc_free_gift_product_id' );
	}

	public static function get_excluded_roles() {
		return get_option( 'wc_free_gift_excluded_roles' );
	}
	public static function get_free_gift_amount() {
		return get_option( 'wc_free_gift_cart_amount' );
	}

	protected function get_products() {
		$args = array(
			'status' => 'publish',
			'limit'  => 999,
		);

		$products = \wc_get_products( $args );

		$product_array = [];

		foreach ( $products as $product ) {

			$product_array[ $product->get_id() ] = $product->get_name();
		}
		return $product_array;
	}
}
