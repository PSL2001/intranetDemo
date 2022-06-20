<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class BetterDocsGutenbergAdmin
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);
        add_filter('block_categories_all', [$this, 'add_block_categories'], 1, 2);
    }
    public function enqueue_styles($hook)
    {
        /**
         * Only for Admin Add/Edit Pages
         */
        if ($hook == 'post-new.php' || $hook == 'post.php' || $hook == 'site-editor.php') {
            wp_enqueue_style(
                'fontpicker-default-theme',
                BETTERDOCS_URL . 'admin/assets/css/fonticonpicker.base-theme.react.css',
                array(),
                BETTERDOCS_VERSION,
                'all'
            );

            wp_enqueue_style(
                'eb-fontawesome-admin',
                BETTERDOCS_URL . 'admin/assets/css/font-awesome5.css',
                array(),
                BETTERDOCS_VERSION,
                'all'
            );

            wp_enqueue_style(
                'fontpicker-material-theme',
                BETTERDOCS_URL . 'admin/assets/css/fonticonpicker.material-theme.react.css',
                array(),
                BETTERDOCS_VERSION,
                'all'
            );

            wp_enqueue_style(
                'betterdocs-admin-editor-css',
                BETTERDOCS_URL . 'includes/gutenberg/admin/editor-css/style.css',
                array(),
                BETTERDOCS_VERSION,
                'all'
            );
        }
    }

    /**
     * Add a block category
     *
     * @param array $categories Block categories.
     *
     * @return array
     */
    public function add_block_categories($categories)
    {
        $categories_slugs = wp_list_pluck($categories, 'slug');

        return in_array('betterdocs', $categories_slugs, true) ? $categories : array_merge(
            $categories,
            [
                [
                    'slug' => 'betterdocs',
                    'title' => __('Betterdocs', 'betterdocs'),
                ]
            ]
        );
    }
}
