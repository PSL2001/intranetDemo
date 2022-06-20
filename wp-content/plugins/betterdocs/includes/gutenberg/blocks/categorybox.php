<?php

/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package betterdocs
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function betterdocs_categorybox_block_init()
{
    // Skip block registration if Gutenberg is not enabled/merged.
    if (!function_exists('register_block_type')) {
        return;
    }
    $dir = dirname(__FILE__);

    $index_js = 'categorybox/index.js';
    wp_register_script(
        'betterdocs-categorybox-block-editor',
        plugins_url($index_js, __FILE__),
        array(
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-editor',
            'wp-block-editor',
            'betterdocs-blocks-edit-post'
        ),
        filemtime("$dir/$index_js")
    );

    $editor_style = 'categorybox/style.css';
    wp_register_style(
        'betterdocs-categorybox-block-editor',
        plugins_url($editor_style, __FILE__),
        array(),
        filemtime("$dir/$editor_style"),
        'all'
    );

    register_block_type(__DIR__ . '/categorybox', array(
        'editor_script' => 'betterdocs-categorybox-block-editor',
        'editor_style' => 'betterdocs-categorybox-block-editor',
        'render_callback' => 'betterdocs_categorybox_server_side_render'
    ));
}
add_action('init', 'betterdocs_categorybox_block_init');

/**
 * Category Box Server Side Render
 */
function betterdocs_categorybox_server_side_render(array $attributes)
{
    if (!is_admin()) {
        wp_enqueue_style("betterdocs-categorybox-block-editor");
    }

    $attributes = wp_parse_args(
        $attributes,
        [
            'blockId' => '',
            'categories' => array(),
            'includeCategories' => '',
            'excludeCategories' => '',
            'boxPerPage' => 9,
            'orderBy' => 'name',
            'order' => 'asc',
            'layout' => 'default',
            'showIcon' => true,
            'showTitle' => true,
            'titleTag' => 'h2',
            'showCount' => true,
            'prefix' => '',
            'suffix' => __('articles', 'betterdocs'),
            'suffixSingular' => __('article', 'betterdocs'),
        ]
    );

    $blockId = $attributes['blockId'];
    $includeCategories = $attributes['includeCategories'];
    $excludeCategories = $attributes['excludeCategories'];
    $boxPerPage = $attributes['boxPerPage'];
    $orderBy = $attributes['orderBy'];
    $order = $attributes['order'];
    $layout = $attributes['layout'];
    $showIcon = $attributes['showIcon'];
    $showTitle = $attributes['showTitle'];
    $titleTag = $attributes['titleTag'];
    $showCount = $attributes['showCount'];
    $prefix = $attributes['prefix'];
    $suffix = $attributes['suffix'];
    $suffixSingular = $attributes['suffixSingular'];
    $enableNestedSubcategory = false;

    $terms_object = array(
        'taxonomy' => 'doc_category',
        'order'    => $order,
        'orderby'  => $orderBy,
        'hide_empty' => true,
        'number'   => $boxPerPage ? $boxPerPage : 9,
    );

    if ('doc_category_order' === $orderBy) {
        $terms_object['meta_key'] = 'doc_category_order';
        $terms_object['orderby'] = 'meta_value_num';
    }

    $includes = array();
    if ($includeCategories && $includeCategories !== '[]') {
        $includes = json_decode($includeCategories, true);
        $includes = array_map(function ($item) {
            return $item['value'];
        }, $includes);
    }

    $excludes = array();
    if ($excludeCategories && $excludeCategories !== '[]') {
        $excludes = json_decode($excludeCategories, true);
        $excludes = array_map(function ($item) {
            return $item['value'];
        }, $excludes);
    }

    if (is_array($includes) && count($includes)) {
        $terms_object['include']  = array_diff($includes, (array) $excludes);
    }

    if (is_array($excludes) && count($excludes)) {
        $terms_object['exclude'] = $excludes;
    }

    $taxonomy_objects = get_terms($terms_object);

    $html = '';
    $default_multiple_kb = false;

    $html .= "<div class='el-betterdocs-category-box-wrapper $blockId'>";
    $html .= "<div class='el-betterdocs-category-box el-betterdocs-column'>";


    if ($taxonomy_objects && !is_wp_error($taxonomy_objects)) {
        foreach ($taxonomy_objects as $term) {
            $term_id = $term->term_id;
            $term_slug = $term->slug;
            $count = $term->count;
            $get_term_count = betterdocs_get_postcount($count, $term_id, $enableNestedSubcategory);
            $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term_id, $term_slug, $count, $enableNestedSubcategory);
            if ($term_count > 0) {
                if ($layout === 'default') {
                    include BETTERDOCS_DIR_PATH . 'includes/gutenberg/template/category-box/Layout_Default.php';
                } else if ($layout === 'layout-2') {
                    include BETTERDOCS_DIR_PATH . 'includes/gutenberg/template/category-box/Layout_2.php';
                }
            }
        }
    } else {
        $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
    }

    $html .= "</div>";
    $html .= "</div>";

    return $html;
}
