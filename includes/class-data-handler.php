<?php

/**
 * Class used to communicate to the plugin's tables in the database.
 */
class WPECRS_Data_Handler
{

	public $db_name;

	public function __construct()
	{
	}

	public function reset_admin_settings()
	{
		$result = delete_option('ppdg-settings');
		return $result;
	}

	/**
	 * Delete Posts, Post meta and taxonomies.
	 *
	 * @return boolean
	 */
	public function reset_all_products_data()
	{
		global $wpdb;

		$delete_post_data = $wpdb->query("DELETE a,b 
								FROM $wpdb->posts a 
								LEFT JOIN $wpdb->postmeta b ON a.ID = b.post_id 
								WHERE a.post_type='ppec-products';");

		$delete_taxonomies = $wpdb->query("DELETE a,b,c
								FROM      $wpdb->term_taxonomy      a
								LEFT JOIN $wpdb->term_relationships b ON a.term_taxonomy_id = b.term_taxonomy_id
								LEFT JOIN $wpdb->terms              c ON a.term_id = c.term_id
								WHERE a.taxonomy = 'wpec_categories'"
		);

		if (!$delete_post_data) {
			return false;
		}elseif (!$delete_taxonomies) {
			return false;
		}else{
			return true;
		}
	}
}
