<?php

/**
 * Template Name: Default
 *
 */

$html .= '<article class="el-betterdocs-category-grid-post">
    <div class="el-betterdocs-cg-inner">';
if ($showHeader) {
    $html .= '<div class="el-betterdocs-cg-header">
                <div class="el-betterdocs-cg-header-inner">';
    if ($showIcon) {

        $cat_icon_id = get_term_meta($term->term_id, 'doc_category_image-id', true);
        if ($cat_icon_id) {
            $cat_icon = wp_get_attachment_image($cat_icon_id, 'thumbnail', ['alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true))]);
        } else {
            $cat_icon = '<img src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-grid-icon">';
        }

        $html .= '<div class="el-betterdocs-cat-icon">' . $cat_icon . '</div>';
    }
    if ($showTitle) {
        $html .= '<' . $titleTag . ' class="el-betterdocs-cat-title">' . $term->name . '</' . $titleTag . '>';
    }
    if ($showCount) {
        $html .= '<div class="el-betterdocs-item-count">' . $term_count . '</div>';
    }
    $html .= '</div>
            </div>';
}

if ($showList) {
    $html .= '<div class="el-betterdocs-cg-body">';
    $args = array(
        'post_type' => 'docs',
        'post_status' => 'publish',
        'posts_per_page' => $postsPerPage,
        'tax_query' => array(
            array(
                'taxonomy' => 'doc_category',
                'field' => 'slug',
                'terms' => $term->slug,
                'operator' => 'AND',
                'include_children' => false,
            ),
        ),
    );

    if ($postsOrderBy != 'betterdocs_order') {
        $args['orderby'] = $postsOrderBy;
        $args['order'] = $postsOrder;
    }

    $args = apply_filters('betterdocs_articles_args', $args, $term->term_id);

    $query = new \WP_Query($args);

    if ($query->have_posts()) {
        $html .= '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $attr = ['href="' . get_the_permalink() . '"'];

            $html .= '<li>';

            $html .= '<i class="' . $listIcon . ' el-betterdocs-cg-post-list-icon"></i>';
            $html .= '<a ' . implode(' ', $attr) . '>' . get_the_title() . '</a>
                    </li>';
        }
        $html .= '</ul>';
    }
    wp_reset_query();

    // Nested category query
    if ($enableNestedSubcategory) {
        include BETTERDOCS_DIR_PATH . 'includes/gutenberg/template/category-grid/Nested_Subcategory.php';
    }
    $html .= '</div>';
}

$html .= '<div class="el-betterdocs-cg-footer">';
if ($showButton) {
    $term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

    $html .= '<a class="el-betterdocs-cg-button" href="' . $term_permalink . '">';

    if ($buttonIconPosition === 'before') {
        $html .= '<i class="' . $buttonIcon . ' el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-left"></i>';
    }

    $html .= $buttonText;

    if ($buttonIconPosition === 'after') {

        $html .= '<i class="' . $buttonIcon . ' el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-right"></i>';
    }

    $html .= '</a>';
}
$html .= '</div>';
$html .= '</div>';
$html .= '</article>';
