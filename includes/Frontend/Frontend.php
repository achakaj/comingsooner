<?php
namespace ComingSooner\Frontend;

class Frontend {
    public function __construct() {
        add_action('template_redirect', [$this, 'maybe_show_coming_soon_page']);
    }

    public function maybe_show_coming_soon_page(): void {
        if ($this->should_show_coming_soon()) {
            $this->render_coming_soon_page();
            exit;
        }
    }

    private function should_show_coming_soon(): bool {
        // Check if coming soon is active
        if (!get_option('coming_sooner_active', false)) {
            return false;
        }

        // Don't show for logged-in admins
        if (current_user_can('manage_options')) {
            return false;
        }

        return true;
    }

    private function render_coming_soon_page(): void {
        $template_id = get_option('coming_sooner_template', 'default');
        $template_type = get_option('coming_sooner_template_type', 'default');

        if ($template_type === 'elementor' && class_exists('\Elementor\Plugin')) {
            $this->render_elementor_template($template_id);
        } else {
            $this->render_default_template($template_id);
        }
    }

    private function render_default_template(string $template_id): void {
        $template_file = COMING_SOONER_PLUGIN_DIR . "includes/Templates/{$template_id}.php";
        
        if (file_exists($template_file)) {
            status_header(503);
            include $template_file;
        } else {
            // Fallback content
            echo '<h1>Coming Soon</h1><p>Website under construction</p>';
        }
    }

    private function render_elementor_template(int $template_id): void {
        if (class_exists('\Elementor\Plugin')) {
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id);
            exit;
        }
    }
}