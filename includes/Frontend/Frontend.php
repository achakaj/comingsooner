<?php
namespace ComingSooner\Frontend;

class Frontend {
    public function __construct() {
        add_action('template_redirect', [$this, 'maybe_show_coming_soon_page']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets_frontend']);
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

    // If using Elementor
    if ($template_type === 'elementor' && class_exists('\Elementor\Plugin')) {

        // Check if the template_id is numeric before passing to the function
        if (is_numeric($template_id)) {
            $this->render_elementor_template((int)$template_id);
        } else {
            // Fallback or error message
            status_header(503);
            echo '<h1>Coming Soon</h1><p>Invalid template ID. Select or create a new one.</p>';
        }

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
        status_header(503);

        // Enqueue Elementor core frontend styles and plugin styles
        \Elementor\Plugin::instance()->frontend->enqueue_styles();
        wp_enqueue_style('coming-sooner-frontend');

        // Enqueue the Elementor template's dynamic CSS if it exists
        $css_file = get_post_meta($template_id, '_elementor_css_file', true);
        if ($css_file) {
            wp_enqueue_style(
                'elementor-template-' . $template_id,
                $css_file,
                ['elementor-frontend'],
                COMING_SOONER_VERSION
            );
        }

        wp_head();

        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id);

        wp_footer();

        exit;
    }
}

public function enqueue_assets_frontend(): void {
    // Only enqueue if we're showing the coming soon page
    if (!$this->should_show_coming_soon()) {
        return;
    }

    wp_enqueue_style(
        'coming-sooner-frontend',
        COMING_SOONER_PLUGIN_URL . 'assets/dist/css/frontend.css',
        [],
        COMING_SOONER_VERSION
    );

    wp_enqueue_script(
        'coming-sooner-frontend',
        COMING_SOONER_PLUGIN_URL . 'assets/dist/js/frontend.js',
        ['jquery', 'wp-i18n', 'updates'],
        COMING_SOONER_VERSION,
        true
    );

    // If using Elementor, enqueue its assets
    if (get_option('coming_sooner_template_type', 'default') === 'elementor') {
        wp_enqueue_script('elementor-frontend');
    }
}



}