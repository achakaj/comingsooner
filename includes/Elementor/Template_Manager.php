<?php
namespace ComingSooner\Elementor;

class Template_Manager {
    public function get_default_templates(): array {
        return [
            'coming-soon' => [
                'id' => 'coming-soon',
                'name' => __('Coming Soon', 'coming-sooner'),
                'thumbnail' => COMING_SOONER_PLUGIN_URL . 'assets/images/default-coming-soon.jpg',
                'file' => 'coming-soon.php'
            ],
            'maintenance' => [
                'id' => 'maintenance',
                'name' => __('Maintenance Mode', 'coming-sooner'),
                'thumbnail' => COMING_SOONER_PLUGIN_URL . 'assets/images/default-maintenance.jpg',
                'file' => 'maintenance.php'
            ]
        ];
    }

    public function get_elementor_templates(): array {
        if (!did_action('elementor/loaded')) {
            return [];
        }

        $templates = [];
        $posts = get_posts([
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);

        foreach ($posts as $post) {
            $templates[] = [
                'id' => $post->ID,
                'name' => $post->post_title,
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium')
            ];
        }

        return $templates;
    }
}