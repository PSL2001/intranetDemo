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
function betterdocs_searchbox_block_init()
{
    // Skip block registration if Gutenberg is not enabled/merged.
    if (!function_exists('register_block_type')) {
        return;
    }
    $dir = dirname(__FILE__);

    $index_js = 'searchbox/index.js';
    wp_register_script(
        'betterdocs-searchbox-block-editor',
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

    $editor_style = 'searchbox/style.css';
    wp_register_style(
        'betterdocs-searchbox-block-editor',
        plugins_url($editor_style, __FILE__),
        array(),
        filemtime("$dir/$editor_style"),
        'all'
    );

    register_block_type(__DIR__ . '/searchbox', array(
        'editor_script' => 'betterdocs-searchbox-block-editor',
        'editor_style' => 'betterdocs-searchbox-block-editor',
        'render_callback' => 'betterdocs_searchbox_server_side_render'
    ));
}
add_action('init', 'betterdocs_searchbox_block_init');

/**
 * Search Box Server Side Render
 */
function betterdocs_searchbox_server_side_render($attributes)
{

    if (!is_admin()) {
        wp_enqueue_style('betterdocs-searchbox-block-editor');
    }

    $attributes = wp_parse_args(
        $attributes,
        [
            'blockId' => '',
            'placeholderText' => esc_html__('Search', 'betterdocs'),
        ]
    );

    $blockId = $attributes['blockId'];
    $placeholderText = $attributes['placeholderText'];


    $html = '';
    $html .= '<div class="' . $blockId . ' betterdocs-searchbox-wrapper">';
    $shortcode = sprintf('[betterdocs_search_form placeholder="' . $placeholderText . '"]', apply_filters('betterdocs_search_form_atts', []));
    $html .= do_shortcode(shortcode_unautop($shortcode));
    $html .= '</div>';

    return $html;
}
