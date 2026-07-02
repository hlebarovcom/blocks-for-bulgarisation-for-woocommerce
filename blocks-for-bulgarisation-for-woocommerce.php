<?php
/**
 * Plugin Name: Blocks for Bulgarisation for WooCommerce
 * Description: Extends the WooCommerce Cart and Checkout blocks with dual BGN/EUR price display, mirroring the Bulgarisation for WooCommerce plugin behaviour for block-based cart/checkout.
 * Author: Jordan Hlebarov
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce, bulgarisation-for-woocommerce
 * Text Domain: blocks-for-bulgarisation-for-woocommerce
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_notices', 'bulg_blocks_admin_notice' );

function bulg_blocks_admin_notice() {
	if ( function_exists( 'woo_bg_get_option' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		wp_kses_post(
			sprintf(
				/* translators: 1: Plugin name, 2: Required plugin name */
				__( '<strong>%1$s</strong> requires the <strong>%2$s</strong> plugin to be installed and active.', 'blocks-for-bulgarisation-for-woocommerce' ),
				'Blocks for Bulgarisation for WooCommerce',
				'Bulgarisation for WooCommerce'
			)
		)
	);
}

add_action( 'wp_enqueue_scripts', 'bulg_blocks_enqueue' );

function bulg_blocks_enqueue() {
	if ( ! function_exists( 'WC' ) || ! function_exists( 'woo_bg_get_option' ) ) {
		return;
	}

	$asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	if ( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = include $asset_file;

	wp_register_script(
		'bulg-blocks',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		// wc-blocks-checkout is WooCommerce's WP handle for @woocommerce/blocks-checkout.
		// It is not listed in index.asset.php because @wordpress/dependency-extraction-webpack-plugin
		// does not handle @woocommerce/* packages — we declare the external manually in webpack.config.js.
		array_merge( $asset['dependencies'], [ 'wc-blocks-checkout' ] ),
		$asset['version'],
		true
	);

	wp_set_script_translations( 'bulg-blocks', 'blocks-for-bulgarisation-for-woocommerce', plugin_dir_path( __FILE__ ) . 'languages' );

	wp_enqueue_style(
		'bulg-blocks',
		plugin_dir_url( __FILE__ ) . 'build/index.css',
		[],
		$asset['version']
	);

	wp_localize_script(
		'bulg-blocks',
		'bulgBlocksData',
		[
			'locale'   => get_locale(),
			'currency' => get_woocommerce_currency(),
			'debug'    => defined( 'WP_DEBUG' ) && WP_DEBUG,
		]
	);

	wp_enqueue_script( 'bulg-blocks' );
}
