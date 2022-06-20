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
function betterdocs_categorygrid_block_init()
{
    // Skip block registration if Gutenberg is not enabled/merged.
    if (!function_exists('register_block_type')) {
        return;
    }
    $dir = dirname(__FILE__);

    $index_js = 'categorygrid/index.js';
    wp_register_script(
        'betterdocs-categorygrid-block-editor',
        plugins_url($index_js, __FILE__),
        array(
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-editor',
            'wp-block-editor',
            'masonry',
            'betterdocs-blocks-edit-post'
        ),
        filemtime("$dir/$index_js")
    );

    $editor_style = 'categorygrid/style.css';
    wp_register_style(
        'betterdocs-categorygrid-block-editor',
        plugins_url($editor_style, __FILE__),
        array(),
        filemtime("$dir/$editor_style"),
        'all'
    );

    $grid_script = 'categorygrid/assets/js/categorygrid.js';
    wp_register_script(
        'betterdocs-categorygrid-js',
        plugins_url($grid_script, __FILE__),
        array('masonry'),
        filemtime("$dir/$grid_script")
    );



    register_block_type(__DIR__ . '/categorygrid', array(
        'editor_script' => 'betterdocs-categorygrid-block-editor',
        'editor_style' => 'betterdocs-categorygrid-block-editor',
        'render_callback' => 'betterdocs_categorygrid_server_side_render'
    ));
}
add_action('init', 'betterdocs_categorygrid_block_init');

/**
 * Category Grid Server Side Render
 */
function betterdocs_categorygrid_server_side_render(array $attributes)
{
    if (!is_admin()) {
        wp_enqueue_style("betterdocs-categorygrid-block-editor");
        wp_enqueue_script("betterdocs-categorygrid-js");
    }

    $attributes = wp_parse_args(
        $attributes,
        [
            'blockId' => '',
            'categories' => array(),
            'includeCategories' => '',
            'excludeCategories' => '',
            'gridPerPage' => 9,
            'orderBy' => 'name',
            'order' => 'asc',
            'layout' => 'default',
            'showIcon' => true,
            'showTitle' => true,
            'titleTag' => 'h2',
            'showCount' => true,
            'showIcon' => true,
            'showTitle' => true,
            'showList' => true,
            'layoutMode' => 'grid',
            'showHeader' => true,
            'showButton' => true,
            'buttonText' => esc_html__('Explore More', 'betterdocs'),
            'listIcon' => 'far fa-file-alt',
            'postsPerPage' => 5,
            'postsOrderBy' => 'date',
            'postsOrder' => 'asc',
            'enableNestedSubcategory' => false,
            'postPerSubcategory' => 3,
            'buttonIconPosition' => 'after',
            'buttonIcon' => 'fas fa-angle-right',
            'buttonPosition' => 'after',
            'showButtonIcon' => true,
            'colRange' => 3,
            'TABcolRange' => 2,
            'MOBcolRange' => 1,
            'gridSpaceRange' => 10,
            'TABgridSpaceRange' => 10,
            'MOBgridSpaceRange' => 10,
        ]
    );

    $blockId = $attributes['blockId'];
    $includeCategories = $attributes['includeCategories'];
    $excludeCategories = $attributes['excludeCategories'];
    $gridPerPage = $attributes['gridPerPage'];
    $orderBy = $attributes['orderBy'];
    $order = $attributes['order'];
    $layout = $attributes['layout'];
    $showIcon = $attributes['showIcon'];
    $showTitle = $attributes['showTitle'];
    $titleTag = $attributes['titleTag'];
    $showCount = $attributes['showCount'];
    $enableNestedSubcategory = $attributes['enableNestedSubcategory'];
    $postsPerPage = $attributes['postsPerPage'];
    $postsOrderBy = $attributes['postsOrderBy'];
    $postsOrder = $attributes['postsOrder'];
    $colRange = $attributes['colRange'];
    $TABcolRange = $attributes['TABcolRange'];
    $MOBcolRange = $attributes['MOBcolRange'];
    $showHeader = $attributes['showHeader'];
    $showList = $attributes['showList'];
    $listIcon = $attributes['listIcon'];
    $showButton = $attributes['showButton'];
    $showButtonIcon = $attributes['showButtonIcon'];
    $buttonIconPosition = $attributes['buttonIconPosition'];
    $buttonIcon = $attributes['buttonIcon'];
    $buttonText = $attributes['buttonText'];
    $postPerSubcategory = $attributes['postPerSubcategory'];
    $layoutMode = $attributes['layoutMode'];
    $gridSpaceRange = $attributes['gridSpaceRange'];
    $TABgridSpaceRange = $attributes['TABgridSpaceRange'];
    $MOBgridSpaceRange = $attributes['MOBgridSpaceRange'];
    $multiple_kb = false;

    // responsive class name
    $gridColomnDesktopClass = $colRange ? " betterdocs-grid-$colRange" : "betterdocs-grid-3";
    $gridColomnTabClass = $TABcolRange ? " betterdocs-grid-tablet-$TABcolRange" : "betterdocs-grid-tablet-2";
    $gridColomnMobileClass = $MOBcolRange ? " betterdocs-grid-mobile-$MOBcolRange" : "betterdocs-grid-mobile-1";

    $terms_object = array(
        'taxonomy' => 'doc_category',
        'order' => $order,
        'orderby' => $orderBy,
        'number' => $gridPerPage ? $gridPerPage : 5,
        'hide_empty' => true,
    );

    if ('doc_category_order' === $orderBy) {
        $terms_object['meta_key'] = 'doc_category_order';
        $terms_object['orderby'] = 'meta_value_num';
    }

    if ($enableNestedSubcategory) {
        $terms_object['parent'] = 0;
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
        $terms_object['include'] = array_diff($includes, (array) $excludes);
    }

    if (is_array($excludes) && count($excludes)) {
        $terms_object['exclude'] = $excludes;
    }

    $taxonomy_objects = get_terms($terms_object);

    $html = '';


    $html .= '<div class="betterdocs-block ' . $blockId . $gridColomnDesktopClass . $gridColomnTabClass . $gridColomnMobileClass . '">';
    $html .= '<div class="betterdocs-category-grid-wrapper">';
    $html .= '<div class="betterdocs-category-grid ' . $layoutMode . '" data-column="' . $colRange . '" data-tab-column="' . $TABcolRange . '" data-mobile-column="' . $MOBcolRange . '" data-colomn-space="' . $gridSpaceRange . '" data-tab-colomn-space="' . $TABgridSpaceRange . '" data-mobile-colomn-space="' . $MOBgridSpaceRange . '">';


    if ($taxonomy_objects && !is_wp_error($taxonomy_objects)) {
        foreach ($taxonomy_objects as $term) {
            $term_id = $term->term_id;
            $term_slug = $term->slug;
            $count = $term->count;
            $get_term_count = betterdocs_get_postcount($count, $term_id, $enableNestedSubcategory);
            $term_count = apply_filters('betterdocs_postcount', $get_term_count, false, $term_id, $term_slug, $count, $enableNestedSubcategory);
            if ($term_count > 0) {
                if ($layout === 'default') {
                    include BETTERDOCS_DIR_PATH . 'includes/gutenberg/template/category-grid/Layout_Default.php';
                } else if ($layout === 'layout-2') {
                    include BETTERDOCS_DIR_PATH . 'includes/gutenberg/template/category-grid/Layout_2.php';
                }
            }
        }
    } else {
        $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
    }
    wp_reset_postdata();

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
