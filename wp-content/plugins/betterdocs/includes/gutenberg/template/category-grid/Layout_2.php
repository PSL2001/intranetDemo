<?php

/**
 * Template Name: Layout 2
 *
 */

$html .= '<article class="el-betterdocs-category-grid-post layout-2">
    <div class="el-betterdocs-cg-inner">';

if ($showHeader) {
    $html .= '<div class="el-betterdocs-cg-header">';
    if ($showCount) {
        $html .= '<div class="el-betterdocs-item-count" data-content="' . $term_count . '"></div>';
    }
    if ($showTitle) {
        $html .= '<' . $titleTag . ' class="el-betterdocs-cat-title">' . $term->name . '</' . $titleTag . '>';
    }
    $html .= '</div>';
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

    $args = apply_filters('betterdocs_articles_args', $args);
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
$html .= '</div>
    </div>
</article>';
