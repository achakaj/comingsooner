<?php
namespace ComingSooner;

class Plugin {
    private static $instance;
    
    private function __construct() {
        // Private constructor to prevent direct instantiation
    }
    
    public static function instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function init(): void {
        $this->load_dependencies();
        $this->register_hooks();
    }
    
private function load_dependencies(): void {
    try {
        // Load helper functions
        $functions_file = __DIR__ . '/functions.php';
        if (file_exists($functions_file)) {
            require_once $functions_file;
        } else {
            throw new \RuntimeException('Functions file is missing');
        }

        // Load admin classes if in admin area
        if (is_admin()) {
            $admin_file = __DIR__ . '/Admin/Admin.php';
            if (file_exists($admin_file)) {
                require_once $admin_file;
                new \ComingSooner\Admin\Admin();
            }
        }

        // Load frontend classes
        $frontend_file = __DIR__ . '/Frontend/Frontend.php';
        if (file_exists($frontend_file)) {
            require_once $frontend_file;
            new \ComingSooner\Frontend\Frontend();
        }

    } catch (\Exception $e) {
        add_action('admin_notices', function() use ($e) {
            echo '<div class="notice notice-error"><p>';
            printf(
                __('ComingSooner initialization error: %s', 'coming-sooner'),
                esc_html($e->getMessage())
            );
            echo '</p></div>';
        });
        
        // Log the error
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('ComingSooner Error: ' . $e->getMessage());
        }
    }
}
    
    private function register_hooks(): void {
        // Common hooks
        add_action('init', [$this, 'register_assets']);
        
        // Activation/deactivation hooks are registered in main plugin file
    }
    
    public function register_assets(): void {
        // Register common styles and scripts
        wp_register_style(
            'coming-sooner-frontend',
            COMING_SOONER_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            COMING_SOONER_VERSION
        );
        
        wp_register_script(
            'coming-sooner-frontend',
            COMING_SOONER_PLUGIN_URL . 'assets/js/frontend.js',
            ['jquery'],
            COMING_SOONER_VERSION,
            true
        );
    }
    
    public static function activate(): void {
        // Activation code here
        update_option('coming_sooner_version', COMING_SOONER_VERSION);
        
        // Create required database tables
        \ComingSooner\Models\Template::create_table();
    }
    
    public static function deactivate(): void {
        // Deactivation cleanup (optional)
    }
}