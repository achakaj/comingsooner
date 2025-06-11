<?php
namespace ComingSooner\Admin;

use ComingSooner\Elementor\Template_Manager;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // For is_plugin_active()


class Admin {
    private $template_manager;

    public function __construct() {
        $this->template_manager = new Template_Manager();
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_coming_sooner_toggle', [$this, 'toggle_coming_soon']);
        add_action('wp_ajax_coming_sooner_save_template', [$this, 'save_template_selection']);
        add_action('wp_ajax_coming_sooner_save_template_type', [$this, 'save_template_type']);
        add_action('wp_ajax_coming_sooner_install_elementor', [$this, 'install_elementor']);
    }

    
    public function add_admin_menu(): void {
        $hook = add_menu_page(
            __('ComingSooner', 'coming-sooner'),
            __('Coming Soon', 'coming-sooner'),
            'manage_options',
            'coming-sooner',
            [$this, 'render_admin_page'],
            'dashicons-clock',
            80
        );
        add_action("load-$hook", [$this, 'verify_setup']);
    }

    public function verify_setup(): void {
        $required_files = [
            COMING_SOONER_PLUGIN_DIR . 'includes/functions.php',
            COMING_SOONER_PLUGIN_DIR . 'includes/Templates/coming-soon.php',
            COMING_SOONER_PLUGIN_DIR . 'includes/Templates/maintenance.php'
        ];

        foreach ($required_files as $file) {
            if (!file_exists($file)) {
                add_action('admin_notices', function() use ($file) {
                    echo '<div class="notice notice-error"><p>';
                    /* translators: %s: missing file path */
                    printf(
                        __('ComingSooner: Required file missing - %s', 'coming-sooner'),
                        esc_html(str_replace(COMING_SOONER_PLUGIN_DIR, '', $file))
                    );
                    echo '</p></div>';
                });
            }
        }
    }

    public function render_admin_page(): void {
        $is_active = get_option('coming_sooner_active', false);
        $selected_template = get_option('coming_sooner_template', 'coming-soon');
        $template_type = get_option('coming_sooner_template_type', 'default');
        $elementor_installed = $this->is_elementor_installed();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('ComingSooner Settings', 'coming-sooner'); ?></h1>

            <!-- Status Toggle -->
            <div class="card">
                <h2><?php esc_html_e('Status', 'coming-sooner'); ?></h2>
                <div class="toggle-switch-container">
                    <label class="switch">
                        <input type="checkbox" id="coming-soon-toggle" <?php checked($is_active, true); ?>>
                        <span class="slider round"></span>
                    </label>
                    <span class="toggle-label">
                        <?php esc_html_e('Enable Coming Soon Page', 'coming-sooner'); ?>
                    </span>
                </div>
            </div>

            <!-- Template Type Selection -->
            <div class="card">
                <h2><?php esc_html_e('Mode Selection', 'coming-sooner'); ?></h2>
                <div class="mode-selection">
                    <label>
                        <input type="radio" name="template_type" value="default" 
                            <?php checked($template_type, 'default'); ?>>
                        <?php esc_html_e('Basic Mode', 'coming-sooner'); ?>
                        <p class="description"><?php esc_html_e('Quick setup with pre-designed templates', 'coming-sooner'); ?></p>
                    </label>
                        <?php if ( ! is_plugin_active( 'elementor/elementor.php' ) ) : ?>
                            <button id="install-elementor" class="button button-primary">
                                <?php esc_html_e('Install Elementor Now', 'coming-sooner'); ?>
                            </button>
                        <?php else : ?>
                            <label>
                                <input type="radio" name="template_type" value="elementor" <?php checked($template_type, 'elementor'); ?>>
                                <?php esc_html_e('Elementor Mode', 'coming-sooner'); ?>
                                <p class="description"><?php esc_html_e('Advanced design with Elementor templates', 'coming-sooner'); ?></p>
                            </label>
                        <?php endif; ?>
                </div>
            </div>

            <!-- Default Templates -->
            <div class="card default-templates" style="<?php echo $template_type !== 'default' ? 'display:none' : ''; ?>">
                <h2><?php esc_html_e('Default Templates', 'coming-sooner'); ?></h2>
                <div class="template-grid">
                    <?php foreach ($this->template_manager->get_default_templates() as $template): ?>
                        <div class="template-card <?php echo $selected_template === $template['id'] ? 'selected' : ''; ?>">
                            <img src="<?php echo esc_url($template['thumbnail']); ?>" 
                                alt="<?php echo esc_attr($template['name']); ?>">
                            <h3><?php echo esc_html($template['name']); ?></h3>
                            <button class="button select-template" 
                                    data-template-type="default"
                                    data-template-id="<?php echo esc_attr($template['id']); ?>">
                                <?php esc_html_e('Select', 'coming-sooner'); ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Elementor Templates -->
            <div class="card elementor-templates" style="<?php echo $template_type !== 'elementor' ? 'display:none' : ''; ?>">
                <?php if ($elementor_installed): ?>
                    <h2><?php esc_html_e('Elementor Templates', 'coming-sooner'); ?></h2>
                    <div class="template-grid">
                        <?php foreach ($this->template_manager->get_elementor_templates() as $template): ?>
                            <div class="template-card <?php echo $selected_template === $template['id'] ? 'selected' : ''; ?>">
                                <img src="<?php echo esc_url($template['thumbnail']); ?>" 
                                    alt="<?php echo esc_attr($template['name']); ?>">
                                <h3><?php echo esc_html($template['name']); ?></h3>
                                <button class="button select-template" 
                                        data-template-type="elementor"
                                        data-template-id="<?php echo esc_attr($template['id']); ?>">
                                    <?php esc_html_e('Select', 'coming-sooner'); ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="create-new-template">
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=elementor_library')); ?>" 
                        class="button button-primary">
                            <?php esc_html_e('Create New Elementor Template', 'coming-sooner'); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="install-elementor">
                        <p><?php esc_html_e('Elementor is required to use advanced templates.', 'coming-sooner'); ?></p>
                        <button class="button button-primary" id="install-elementor">
                            <?php esc_html_e('Install Elementor Now', 'coming-sooner'); ?>
                        </button>
                        <p class="description"><?php esc_html_e('No page reload required', 'coming-sooner'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Promo / Service Offer Card -->
            <div class="card promo-card">
                <h2>🚀 <?php _e( 'Need Help Building or Maintaining Your Website?', 'coming-sooner' ); ?></h2>
                <p><?php _e( 'If you’d like a professional to build your website, or need help with website maintenance, I’m here for you!', 'coming-sooner' ); ?></p>
                <a href="mailto:achakaj.abdellah@gmail.com?subject=Website%20Help%20Request" class="button button-primary">
                    <?php _e( 'Contact Me', 'coming-sooner' ); ?>
                </a>
                <p class="description"><?php _e( 'Fast, reliable, and tailored to your needs.', 'coming-sooner' ); ?></p>
            </div>


        </div>
        <?php
    }

    public function toggle_coming_soon(): void {
        check_ajax_referer('coming-sooner-admin-nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Unauthorized', 'coming-sooner'), 403);
        }

        $is_active = isset($_POST['active']) ? filter_var($_POST['active'], FILTER_VALIDATE_BOOLEAN) : false;
        update_option('coming_sooner_active', $is_active);
        
        wp_send_json_success([
            'message' => $is_active 
                ? __('Coming Soon page is now active', 'coming-sooner') 
                : __('Coming Soon page is deactivated', 'coming-sooner')
        ]);
    }

    public function save_template_selection(): void {
        check_ajax_referer('coming-sooner-admin-nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Unauthorized', 'coming-sooner'), 403);
        }

        $template_id = isset($_POST['template_id']) ? sanitize_text_field($_POST['template_id']) : '';
        $template_type = isset($_POST['template_type']) ? sanitize_text_field($_POST['template_type']) : 'default';
        
        update_option('coming_sooner_template', $template_id);
        update_option('coming_sooner_template_type', $template_type);
        
        wp_send_json_success([
            'message' => __('Template selected successfully', 'coming-sooner')
        ]);
    }

    public function save_template_type(): void {
        check_ajax_referer('coming-sooner-admin-nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Unauthorized', 'coming-sooner'), 403);
        }

        $template_type = isset($_POST['template_type']) ? sanitize_text_field($_POST['template_type']) : 'default';
        update_option('coming_sooner_template_type', $template_type);
        
        wp_send_json_success();
    }

    public function install_elementor(): void {
        check_ajax_referer('coming-sooner-admin-nonce', 'nonce');
        
        if (!current_user_can('install_plugins')) {
            wp_send_json_error(__('You do not have permission to install plugins', 'coming-sooner'), 403);
        }

        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        $plugin_slug = 'elementor';
        $plugin_zip = 'https://downloads.wordpress.org/plugin/elementor.latest-stable.zip';

        $upgrader = new \Plugin_Upgrader(new \Automatic_Upgrader_Skin());
        $installed = $upgrader->install($plugin_zip);
        
        if (is_wp_error($installed)) {
            wp_send_json_error($installed->get_error_message(), 500);
        }

        $activation = activate_plugin('elementor/elementor.php');
        
        if (is_wp_error($activation)) {
            wp_send_json_error($activation->get_error_message(), 500);
        }

        wp_send_json_success([
            'message' => __('Elementor installed and activated successfully!', 'coming-sooner'),
            'reload' => true
        ]);
    }

    private function is_elementor_installed(): bool {
        return did_action('elementor/loaded') || function_exists('elementor_load_plugin_textdomain');
    }

    public function enqueue_assets(string $hook): void {
        if ('toplevel_page_coming-sooner' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'coming-sooner-admin',
            COMING_SOONER_PLUGIN_URL . 'assets/dist/css/admin.css',
            [],
            COMING_SOONER_VERSION
        );

        wp_enqueue_script(
            'coming-sooner-admin',
            COMING_SOONER_PLUGIN_URL . 'assets/dist/js/admin.js',
            ['jquery', 'wp-i18n', 'updates'],
            COMING_SOONER_VERSION,
            true
        );

        wp_localize_script('coming-sooner-admin', 'comingSoonerData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('coming-sooner-admin-nonce'),
            'confirmInstall' => __('Are you sure you want to install Elementor?', 'coming-sooner'),
        ]);
    }
}
