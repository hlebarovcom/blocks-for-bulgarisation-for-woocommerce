=== Blocks for Bulgarisation for WooCommerce ===
Contributors: jdbg
Tags: woocommerce, bgn, eur, dual-currency, checkout-blocks
Requires at least: 6.4
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires Plugins: woocommerce, bulgarisation-for-woocommerce

Adds a dual BGN/EUR price display to the WooCommerce Cart and Checkout blocks, extending Bulgarisation for WooCommerce to block-based cart/checkout.

== Description ==

Bulgaria's transition to the euro means shops trading in BGN are expected to display prices in both BGN and EUR side by side. The [Bulgarisation for WooCommerce](https://wordpress.org/plugins/bulgarisation-for-woocommerce/) plugin already does this for the classic (shortcode-based) cart and checkout, but does not cover the newer WooCommerce Cart and Checkout **blocks**.

This plugin fills that gap. With both plugins active, it adds the secondary currency amount next to:

* Each line item's unit price and subtotal in the cart, checkout, and mini-cart blocks
* The order summary Subtotal and Total rows
* The mini-cart footer subtotal
* A note in the order summary stating the fixed exchange rate used

Conversion uses the official fixed BGN/EUR rate of 1 EUR = 1.95583 BGN, matching Bulgarian National Bank convention.

= Requirements =

* [WooCommerce](https://wordpress.org/plugins/woocommerce/)
* [Bulgarisation for WooCommerce](https://wordpress.org/plugins/bulgarisation-for-woocommerce/), active and configured

This plugin does nothing on its own — it only extends Bulgarisation for WooCommerce's dual-price display to the block-based cart and checkout.

== Installation ==

1. Make sure WooCommerce and Bulgarisation for WooCommerce are installed and active.
2. Upload the plugin files to the `/wp-content/plugins/blocks-for-bulgarisation-for-woocommerce` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Visit a cart or checkout page built with WooCommerce Blocks to see the dual-currency prices.

== Frequently Asked Questions ==

= Does this work with the classic (shortcode) cart and checkout? =

No. The classic cart and checkout are already covered by Bulgarisation for WooCommerce itself. This plugin only targets the WooCommerce Cart and Checkout blocks.

= Why isn't anything showing up? =

Check that WooCommerce, Bulgarisation for WooCommerce, and this plugin are all active, and that your store currency is set to BGN or EUR. The dual-price display only appears for those two currencies.

= Is the exchange rate configurable? =

No. It uses the official fixed BGN/EUR peg (1 EUR = 1.95583 BGN), the same rate used by Bulgarisation for WooCommerce.

== Changelog ==

= 1.0.1 =
* Remove discouraged load_plugin_textdomain() call (translations are auto-loaded for WordPress.org-hosted plugins).

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.1 =
Minor fix, no functional changes.

= 1.0.0 =
Initial release.
