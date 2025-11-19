<?php
/*
Plugin Name: My Boilerplate Plugin
Plugin URI:  https://example.com/
Description: Boilerplate plugin that shows how to enqueue scripts and styles on frontend and admin, with a simple settings page.
Version:     0.1.1
Author:      Malcolm
Author URI:  https://example.com/
Text Domain: my-boilerplate-plugin
Domain Path: /languages
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'MBP_VERSION', '0.1.1' );
define( 'MBP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MBP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin dependencies
 */
require_once MBP_PLUGIN_DIR . 'inc/admin-settings.php';

/**
 * Enqueue frontend assets
 */
function mbp_enqueue_frontend_assets() {
    $options = get_option( 'mbp_settings', array( 'load_frontend' => '1' ) );
    if ( empty( $options['load_frontend'] ) || $options['load_frontend'] !== '1' ) {
        return;
    }

    wp_register_style(
            'mbp-frontend-style',
            MBP_PLUGIN_URL . 'assets/css/mbp-frontend.css',
            array(),
            MBP_VERSION
    );
    wp_enqueue_style( 'mbp-frontend-style' );

    wp_register_script(
            'mbp-frontend-script',
            MBP_PLUGIN_URL . 'assets/js/mbp-frontend.js',
            array( 'jquery' ),
            MBP_VERSION,
            true
    );

    wp_localize_script( 'mbp-frontend-script', 'MBP', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'mbp_nonce' ),
    ) );

    wp_enqueue_script( 'mbp-frontend-script' );
}
add_action( 'wp_enqueue_scripts', 'mbp_enqueue_frontend_assets' );

/**
 * Enqueue admin assets (only on plugin settings page)
 */
function mbp_enqueue_admin_assets( $hook_suffix ) {
    if ( $hook_suffix !== 'settings_page_mbp-settings' ) {
        return;
    }

    wp_enqueue_style(
            'mbp-admin-style',
            MBP_PLUGIN_URL . 'assets/css/mbp-admin.css',
            array(),
            MBP_VERSION
    );

    wp_enqueue_script(
            'mbp-admin-script',
            MBP_PLUGIN_URL . 'assets/js/mbp-admin.js',
            array( 'jquery' ),
            MBP_VERSION,
            true
    );
}
add_action( 'admin_enqueue_scripts', 'mbp_enqueue_admin_assets' );

