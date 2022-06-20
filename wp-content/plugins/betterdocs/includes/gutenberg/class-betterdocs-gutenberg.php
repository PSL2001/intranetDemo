<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BetterDocsGutenberg')) {
    class BetterDocsGutenberg
    {

        protected static $_instance = null;

        public static function get_instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        private function __construct()
        {
            // enqueue style
            add_action('wp_enqueue_scripts', [$this, 'enqueue_style']);
            // Load Admin Files
            $this->load_admin_dependencies();
            // Load All Block Files
            $this->load_block_dependencies();
            // load Admin Class
            new BetterDocsGutenbergAdmin();
        }

        public function enqueue_style()
        {
            wp_enqueue_style(
                'betterdocs-fontawesome-frontend',
                BETTERDOCS_URL . 'admin/assets/css/font-awesome5.css',
                array(),
                BETTERDOCS_VERSION,
                'all'
            );
        }

        private function load_admin_dependencies()
        {
            require_once BETTERDOCS_DIR_PATH . 'includes/gutenberg/class-betterdocs-gutenberg-admin.php';
        }

        private function load_block_dependencies()
        {
            // Categorybox Block
            require_once BETTERDOCS_DIR_PATH . 'includes/gutenberg/blocks/categorybox.php';
            require_once BETTERDOCS_DIR_PATH . 'includes/gutenberg/blocks/categorygrid.php';
            require_once BETTERDOCS_DIR_PATH . 'includes/gutenberg/blocks/searchbox.php';
        }
        /**
         * Generic data fetching wrapper
         * Uses the WP-API for fetching
         */
        public static function betterdocs_wp_remote_get($url)
        {
            $request = wp_remote_get($url);

            if (is_wp_error($request)) {
                return false;
            }

            return wp_remote_retrieve_body($request);
        }
    }

    BetterDocsGutenberg::get_instance();
}
