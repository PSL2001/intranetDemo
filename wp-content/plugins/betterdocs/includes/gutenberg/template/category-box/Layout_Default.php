<?php

/**
 * Template Name: Default
 *
 */


$term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

$html .= '<a href="' . $term_permalink . '" class="el-betterdocs-category-box-post">
    <div class="el-betterdocs-cb-inner">';

if ($showIcon) {
    $cat_icon_id = get_term_meta($term->term_id, 'doc_category_image-id', true);

    if ($cat_icon_id) {
        $cat_icon = wp_get_attachment_image($cat_icon_id, 'thumbnail', ['alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true))]);
    } else {
        $cat_icon = '<img src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-box-icon">';
    }

    $html .= '<div class="el-betterdocs-cb-cat-icon">' . $cat_icon . '</div>';
}

if ($showTitle) {
    $html .= '<' . $titleTag . ' class="el-betterdocs-cb-cat-title">' . $term->name . '</' . $titleTag . '>';
}

if ($showCount) {
    if ($term_count == 1) {
        $html .= '<div class="el-betterdocs-cb-cat-count"><span class="count-prefix">'.$prefix.'</span>'.$term_count.'<span class="count-suffix">'.$suffixSingular.'</span></div>';
    } else {
        $html .= '<div class="el-betterdocs-cb-cat-count"><span class="count-prefix">'.$prefix.'</span>'.$term_count.'<span class="count-suffix">'.$suffix.'</span></div>';
    }
}

$html .= '</div>
</a>';
