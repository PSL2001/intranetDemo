<?php

// $sub_categories = BetterDocs_Helper::child_taxonomy_terms($term_id, false, $orderBy, $order, '');

$subterms_object = array(
    'taxonomy' => 'doc_category',
    'order' => $order,
    'orderby' => $orderBy,
    'number' =>  4,
    'hide_empty' => true,
    'parent' => $term_id
);

if ('doc_category_order' === $orderBy) {
    $subterms_object['meta_key'] = 'doc_category_order';
    $subterms_object['orderby'] = 'meta_value_num';
}

if (is_array($includes) && count($includes)) {
    $subterms_object['include'] = array_diff($includes, (array) $excludes);
}

if (is_array($excludes) && count($excludes)) {
    $subterms_object['exclude'] = $excludes;
}

$sub_categories = get_terms($subterms_object);

if ($sub_categories) {
    foreach ($sub_categories as $sub_category) {
        $html .= '<span class="elgb-betterdocs-grid-sub-cat-title">';
        $html .= '<i class="fas fa-angle-right toggle-arrow arrow-right"></i><i class="fas fa-angle-down toggle-arrow arrow-down"></i>';
        $html .= '<a href="javascript:void(0);">' . $sub_category->name . '</a></span>';
        $html .= '<div class="docs-sub-cat-wrapper"><ul class="docs-sub-cat-list">';

        $sub_args = array(
            'post_type' => 'docs',
            'post_status' => 'publish'
        );

        $tax_query = array(
            array(
                'taxonomy' => 'doc_category',
                'field'     => 'slug',
                'terms'    => $sub_category->slug,
                'operator' => 'AND',
                'include_children' => false
            ),
        );

        $sub_args['posts_per_page'] = $postPerSubcategory;

        if ($postsOrderBy != 'betterdocs_order') {
            $sub_args['orderby'] = $postsOrderBy;
            $sub_args['order'] = $postsOrder;
        }

        $sub_args['tax_query'] = apply_filters('betterdocs_list_tax_query_arg', $tax_query, $multiple_kb, $sub_category->slug, '');
        $sub_args = apply_filters('betterdocs_articles_args', $sub_args, $sub_category->term_id);

        $sub_post_query = new \WP_Query($sub_args);
        if ($sub_post_query->have_posts()) :
            while ($sub_post_query->have_posts()) : $sub_post_query->the_post();
                $sub_attr = ['href="' . get_the_permalink() . '"'];
                $html .= '<li class="sub-list">';

                $html .= '<i class="' . $listIcon . ' el-betterdocs-cg-post-list-icon"></i>';

                $html .= '<a ' . implode(' ', $sub_attr) . '>' . get_the_title() . '</a></li>';
            endwhile;
        endif;
        wp_reset_query();
        $html .= '</ul></div>';
    }
}
