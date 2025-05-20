<?php
// ComingSooner helper functions

if (!function_exists('coming_sooner_doing_it_wrong')) {
    /**
     * Wrapper for _doing_it_wrong()
     */
    function coming_sooner_doing_it_wrong($function, $message, $version) {
        // @codeCoverageIgnoreStart
        if (defined('WP_DEBUG') && WP_DEBUG) {
            _doing_it_wrong(
                esc_html($function),
                esc_html($message),
                esc_html($version)
            );
        }
        // @codeCoverageIgnoreEnd
    }
}

if (!function_exists('coming_sooner_get_template')) {
    /**
     * Get template file path
     */
    function coming_sooner_get_template(string $template_name): string {
        $template_path = locate_template([
            "coming-sooner/{$template_name}",
            $template_name
        ]);

        if (!$template_path) {
            $template_path = COMING_SOONER_PLUGIN_DIR . "Templates/{$template_name}";
        }

        return apply_filters('coming_sooner_template_path', $template_path, $template_name);
    }
}

if (!function_exists('coming_sooner_debug_log')) {
    function coming_sooner_debug_log($message, $data = null) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('[ComingSooner] ' . $message);
            if ($data) {
                error_log(print_r($data, true));
            }
        }
    }
}