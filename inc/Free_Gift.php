<?php

/**
 * Free gift logic modified from here https://stackoverflow.com/questions/64872198/add-free-gifted-product-for-a-minimal-cart-amount-in-woocommerce
 */

namespace Free_Gift_WC;

class Free_Gift {

	public function __construct() {
		// check the user role is allowed a free gift

		add_action( 'woocommerce_before_calculate_totals', array( $this, 'maybe_add_free_gift' ) );
		add_filter( 'woocommerce_cart_item_price', array( $this, 'change_minicart_free_gifted_item_price' ), 10, 3 );
	}

	// Add free gifted product for specific cart subtotal

	function maybe_add_free_gift( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		// Settings
		$free_product_id   = Settings::get_product_id();
		$targeted_subtotal = Settings::get_free_gift_amount();

		$cart_subtotal = 0; // Initializing

		// Loop through cart items (first loop)
		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
			// When free product is is cart
			if ( $free_product_id == $cart_item['product_id'] ) {
				$free_key = $cart_item_key;
				$free_qty = $cart_item['quantity'];
				$cart_item['data']->set_price( 0 ); // Optionally set the price to zero
			} else {
				if ( key_exists( 'line_total', $cart_item ) && key_exists( 'line_tax', $cart_item ) ) {
					$cart_subtotal += $cart_item['line_total'] + $cart_item['line_tax'];
				}
			}
		}

		// If subtotal match and free product is not already in cart, add it
		if ( ! isset( $free_key ) && $cart_subtotal >= $targeted_subtotal ) {
			$cart->add_to_cart( $free_product_id );
		}
		// If subtotal doesn't match and free product is already in cart, remove it
		elseif ( isset( $free_key ) && $cart_subtotal < $targeted_subtotal ) {
			$cart->remove_cart_item( $free_key );
		}
		// Keep free product quantity to 1.
		elseif ( isset( $free_qty ) && $free_qty > 1 ) {
			$cart->set_quantity( $free_key, 1 );
		}
	}

	// Display free gifted product price to zero on minicart

	public function change_minicart_free_gifted_item_price( $price_html, $cart_item, $cart_item_key ) {
		$free_product_id = Settings::get_product_id();

		if ( $cart_item['product_id'] == $free_product_id ) {
			return wc_price( 0 );
		}
		return $price_html;
	}
}
