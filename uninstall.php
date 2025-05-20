<?php
// Exit if uninstall not called from WordPress
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Check if we need to remove data
if ('1' === get_option('coming_sooner_remove_data_on_uninstall')) {
    global $wpdb;
    
    // Remove options
    delete_option('coming_sooner_settings');
    delete_option('coming_sooner_version');
    
    // Remove database tables
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}coming_sooner_templates");
    
    // Clear any cached data
    wp_cache_flush();
}