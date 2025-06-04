<?php
/**
 * Plugin Name: ComingSooner
 * Plugin URI: https://achakaj.com/coming-sooner
 * Description: A lightweight and customizable plugin that lets you easily create stunning Coming Soon and Maintenance Mode pages for your website.
 * Version: 1.0.0
 * Author: Abdel Achakaj
 * Author URI: https://achakaj.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: coming-sooner
 * Domain Path: /languages
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define plugin constants
define('COMING_SOONER_VERSION', '1.0.0');
define('COMING_SOONER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COMING_SOONER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('COMING_SOONER_BASENAME', plugin_basename(__FILE__));

//required PHP version
if (version_compare(PHP_VERSION, '8.0', '<')) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>';
        /* translators: %s: current PHP version */
        printf(
            __('ComingSooner requires PHP 8.0 or higher. Your server is running PHP %s.', 'coming-sooner'),
            PHP_VERSION
        );
        echo '</p></div>';
    });
    return;
}

// Autoload classes
require_once COMING_SOONER_PLUGIN_DIR . 'vendor/autoload.php';

// Initialize the plugin
add_action('plugins_loaded', function() {
    // Load text domain
    load_plugin_textdomain(
        'coming-sooner',
        false,
        dirname(COMING_SOONER_BASENAME) . '/languages'
    );

    // Initialize the main plugin class
    ComingSooner\Plugin::instance()->init();
});

// Register activation and deactivation hooks
register_activation_hook(__FILE__, ['ComingSooner\Plugin', 'activate']);
register_deactivation_hook(__FILE__, ['ComingSooner\Plugin', 'deactivate']);