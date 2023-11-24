<?php

class WPECRS_Main
{

	private $data_handler;

	public function __construct()
	{
		$this->data_handler = new WPECRS_Data_Handler();
		add_action('plugins_loaded', array($this, 'plugin_loaded'));
	}

	public function plugin_loaded()
	{
		add_action('admin_menu', array($this, 'add_admin_menus'));
		add_filter('plugin_action_links', array($this, 'add_settings_link'), 10, 2);
	}

	// Add settings link in plugins listing page
	public function add_settings_link($links, $file)
	{
		if ($file == plugin_basename(__FILE__)) {
			$settings_link = '<a href="edit.php?post_type=ppec-products&page=ppec-settings-page">Settings</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	}

	public function add_admin_menus()
	{
		if (function_exists('add_options_page')) {
			add_options_page('WP Express Checkout Settings Reset', 'WPEC Reset', 'manage_options', __FILE__, array($this, 'reset_settings_page'));
		}
	}

	public function reset_settings_page()
	{
?>
		<div class="wrap">
			<h2>WP Express Checkout Reset Settings</h2>

			<?php
			$this->display_reset_products_form();
			$this->display_reset_orders_form();
			$this->display_reset_admin_settings_form();
			$this->display_reset_all_settings_form();
			?>

			<style>
				.wpecrs_warning_box {
					background: #FFF6D5;
					border: 1px solid #D1B655;
					color: #3F2502;
					margin: 10px 0;
					padding: 5px 5px 5px 10px;
					text-shadow: 1px 1px #FFFFFF;
				}
			</style>
		</div>
	<?php
	}

	public function display_reset_products_form()
	{

		if (isset($_POST['wpecrs_reset_products']) && check_admin_referer('wpecrs-reset-products-nonce')) { //Do form submission tasks

			$errors = '';

			$is_success = $this->data_handler->reset_all_products_data();

			if ($is_success === false) {
				$errors .= '<p>' . __('Deletion of WP Express Checkout products failed.', 'wp_express_checkout') . '</p>';
			}

			if ($errors) {
				//didpsalay error message;
				echo '<div class="error fade">' . $errors . '</div>';
			} else {
				//echo a success message
				echo '<div id="message" class="updated fade"><p>' . __('WP Express Checkout products were deleted successfully.', 'wp-express-checkout') . '</p></div>';
			}
		}
	?>
		<div id="poststuff">
			<div id="post-body">
				<form action="" method="POST">
					<?php wp_nonce_field('wpecrs-reset-products-nonce'); ?>
					<div class="postbox">
						<h3 class="hndle"><label for="title"><?php _e('Reset All Products Data', 'wp-express-checkout'); ?></label></h3>
						<div class="inside">
							<div class="wpecrs_warning_box">
								<p>
									<b>WARNING: </b>
									<span>
										<?php _e('This will delete all the products from the database that was created by the WP Express Checkout plugin!', 'wp-express-checkout'); ?>
									</span>
								</p>
							</div>
							<input type="submit" name="wpecrs_reset_products" value="<?php _e('Reset', '') ?>" class="button-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php
	}


	public function display_reset_admin_settings_form()
	{

		if (isset($_POST['wpecrs_reset_admin_settings']) && check_admin_referer('wpecrs-reset-admin-settings-nonce')) { //Do form submission tasks
			$errors = '';

			$is_success = $this->data_handler->reset_admin_settings();

			if ($is_success === false) {
				$errors .= '<p>' . __('Deletion of ppdg-settings failed.', '') . '</p>';
			}

			if ($errors) {
				//didpsalay error message;
				echo '<div class="error fade">' . $errors . '</div>';
			} else {
				//echo a success message
				echo '<div id="message" class="updated fade"><p>' . __('WP Express Checkout settings was reset successfully.', 'wp-express-checkout') . '</p></div>';
			}
		}

	?>
		<div id="poststuff">
			<div id="post-body">
				<form action="" method="POST">
					<?php wp_nonce_field('wpecrs-reset-admin-settings-nonce'); ?>
					<div class="postbox">
						<h3 class="hndle"><label for="title"><?php _e('Reset Admin Settings', 'wp-express-checkout'); ?></label></h3>
						<div class="inside">
							<div class="wpecrs_warning_box">
								<p>
									<b>WARNING: </b>
									<span>
										<?php _e('This will reset all the admin settings data of the WP Express Checkout plugin!', 'wp-express-checkout'); ?>
									</span>
								</p>
							</div>
							<input type="submit" name="wpecrs_reset_admin_settings" value="<?php _e('Reset', '') ?>" class="button-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php
	}

	public function display_reset_all_settings_form()
	{
	?>
		<div id="poststuff">
			<div id="post-body">
				<form action="" method="POST">
					<?php wp_nonce_field('wpecrs-reset-all-nonce'); ?>
					<div class="postbox">
						<h3 class="hndle"><label for="title"><?php _e('Factory Reset', 'wp-express-checkout'); ?></label></h3>
						<div class="inside">
							<div class="wpecrs_warning_box">
								<p>
									<b>WARNING: </b>
									<span>
										<?php _e('This will erase everything of the WP Express Checkout plugin!', 'wp-express-checkout'); ?>
									</span>
								</p>
							</div>
							<input type="submit" name="wpecrs_reset_all" value="<?php _e('Reset', '') ?>" class="button-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php
	}

	public function display_reset_orders_form()
	{
	?>
		<div id="poststuff">
			<div id="post-body">
				<form action="" method="POST">
					<?php wp_nonce_field('wpecrs-reset-orders-nonce'); ?>
					<div class="postbox">
						<h3 class="hndle"><label for="title"><?php _e('Reset All Orders Data', 'wp-express-checkout'); ?></label></h3>
						<div class="inside">
							<div class="wpecrs_warning_box">
								<p>
									<b>WARNING: </b>
									<span>
										<?php _e('This will erase all orders data from the database that was created during checkout from the WP Express Checkout plugin!', 'wp-express-checkout'); ?>
									</span>
								</p>
							</div>
							<input type="submit" name="wpecrs_reset_orders" value="<?php _e('Reset', '') ?>" class="button-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
<?php
	}
}
