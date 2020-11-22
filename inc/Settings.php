<?php
namespace Free_Gift_WC;
Class Settings{


	public function __construct()
	{

		add_filter( 'woocommerce_get_sections_products', array( $this, 'free_gift_add_settings_tab' ) );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'free_gift_settings' ), 10, 2 );
	}


	public function free_gift_add_settings_tab( $settings_tab ) {
		$settings_tab['product_free_gift'] = __( 'Free Gift Product', 'free-shipping-notice' );
		return $settings_tab;
	}


	public function free_gift_settings( $settings, $current_section ) {
		if ( 'product_free_gift' == $current_section ) {
			$custom_settings = array(
				array(
					'name' => __( 'Free Gift Product', 'free-shipping-notice' ),
					'type' => 'title',
					'desc' => __( 'Add a free gift in cart over a certain spend', 'free-shipping-notice' ),
					'id'   => 'wc_free_gift',
					'css'  => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Enable', 'back-in-stock-date-for-wc' ),
					'desc'    => __( 'Enable free gift in cart', 'back-in-stock-date-for-wc' ),
					'id'      => 'wc_free_gift_enable',
					'default' => 'no',
					'type'    => 'checkbox',
					'css'     => 'min-width:200px;',
				),
				array(
					'title'    => __( 'Free Product', 'free-shipping-notice' ),
					'type'     => 'number',
					'desc_tip' => __( 'The Product ID of the gift product', 'free-shipping-notice' ),
					'default'  => 0,
					'id'       => 'wc_free_gift_product_id',
					'css'      => 'height:100px;',
					'css'      => 'width:100px;',
				),
				array(
					'title'    => __( 'Cart Subtotal Value', 'free-shipping-notice' ),
					'type'     => 'number',
					'desc_tip' => __( 'The value above to apply the free gift', 'free-shipping-notice' ),
					'default'  => 0,
					'id'       => 'wc_free_gift_cart_amount',
					'css'      => 'height:100px;',
					'css'      => 'width:100px;',
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

	public static function get_product_id(){
		return get_option('wc_free_gift_product_id');
	}

	public static function get_free_gift_amount(){
		return get_option('wc_free_gift_cart_amount');
	}
}
