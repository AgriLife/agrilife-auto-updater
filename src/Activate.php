<?php
namespace AgriLife\AutoUpdate;

/**
 * Plugin activation class
 * @package AgriLife-AutoUpdate
 * @since 1.0.0
 */
class Activate {

	public function run( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				$this->activate_network();
			} else {
				$this->activate_single_site();
			}
		} else {
			$this->activate_single_site();
		}

	}

	protected function get_blog_ids() {

		global $wpdb;

		$blog_ids = $wpdb->get_col("select blog_id from $wpdb->blogs order by blog_id asc");

		return $blog_ids;

	}

	/**
	 * Fires activation commands for each site on the network
	 * @since 1.0.0
	 * @return void
	 */
	protected function activate_network() {

		$blog_ids = $this->get_blog_ids();

		foreach ( $blog_ids as $id ) {
			switch_to_blog( $id );
			$this->activate_single_site();
		}

		restore_current_blog();

	}

	/**
	 * Runs activation commands for a single site
	 * @since 1.0.0
	 * @return void
	 */
	private function activate_single_site() {

		do_action( 'agrilife_autoupdate_activation' );

	}

}
