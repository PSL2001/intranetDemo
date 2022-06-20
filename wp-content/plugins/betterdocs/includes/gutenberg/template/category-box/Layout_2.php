<?php

/**
 * Template Name: Layout 2
 *
 */

$term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

$html .= '<a href="' . $term_permalink . '" class="el-betterdocs-category-box-post layout__2">';
$html .= '<div class="el-betterdocs-cb-inner">';

if ($showIcon) {
    $cat_icon_id = get_term_meta($term->term_id, 'doc_category_image-id', true);

    if ($cat_icon_id) {
        $cat_icon = wp_get_attachment_image($cat_icon_id, 'thumbnail', ['alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true))]);
    } else {
        $cat_icon = '<img src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-box-icon">';
    }

    $html .= '<div class="el-betterdocs-cb-cat-icon__layout-2">' . $cat_icon . '</div>';
}

if ($showTitle) {
    $html .= '<' . $titleTag . ' class="el-betterdocs-cb-cat-title__layout-2"><span>' . $term->name . '</span></' . $titleTag . '>';
}

if ($showCount) {
    $html .= '<div class="el-betterdocs-cb-cat-count__layout-2"><span class="count-inner__layout-2">' . $term_count . '</span></div>';
}

$html .= '</div>';
$html .= '</a>';
