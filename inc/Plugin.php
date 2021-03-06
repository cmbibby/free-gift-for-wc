<?php

namespace Free_Gift_WC;

class Plugin {

	public function __construct() {
		 new Settings;
		// check to see whether the user is allowed a free gift
		$user_id        = \get_current_user_id();
		$user           = new \WP_User( $user_id );
		$excluded_roles = Settings::get_excluded_roles();
		if ( ! is_array( $excluded_roles ) || empty( array_intersect( $user->roles, $excluded_roles ) ) ) {
			new Free_Gift;
		}
	}
}
