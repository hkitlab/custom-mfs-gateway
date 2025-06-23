<?php
/**
 * Plugin Name: Custom MFS Payment Gateway
 * Plugin URI: https://yourwebsite.com
 * Description: A custom payment gateway for bKash, Nagad, Rocket, and Upay for WooCommerce.
 * Version: 1.0.0
 * Author: Md.Kibriya
 * Author URI: https://hkitlab.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: custom-mfs-gateway
 * Domain Path: /languages
 * WC requires at least: 4.0
 * WC tested up to: 8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Check if WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

// Main plugin class will be loaded here
add_action('plugins_loaded', 'init_custom_mfs_gateway');

function init_custom_mfs_gateway() {
    if (class_exists('WC_Payment_Gateway')) {
        require_once 'includes/class-wc-gateway-bkash.php';
        require_once 'includes/class-wc-gateway-nagad.php';
        // Add other gateways similarly
    }
}

// Add the gateways to WooCommerce
function add_to_woo_mfs_gateway($gateways) {
    $gateways[] = 'WC_Gateway_Bkash';
    $gateways[] = 'WC_Gateway_Nagad';
    // Add other gateways similarly
    return $gateways;
}
add_filter('woocommerce_payment_gateways', 'add_to_woo_mfs_gateway');

// Add settings link
function custom_mfs_gateway_settings_link($links) {
    $settings_link = '<a href="admin.php?page=wc-settings&tab=checkout&section=bkash">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'custom_mfs_gateway_settings_link');