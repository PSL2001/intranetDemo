<?php

/**
 * Template archive docs
 *
 * @link       https://wpdeveloper.com
 * @since      1.0.0
 *
 * @package    BetterDocs
 * @subpackage BetterDocs/public
 */

get_header();

$docs_orderby = BetterDocs_DB::get_settings('alphabetically_order_post');
$docs_order = BetterDocs_DB::get_settings('docs_order');
$terms_orderby = BetterDocs_DB::get_settings('terms_orderby');
$terms_order   = BetterDocs_DB::get_settings('terms_order');

$nested_subcategory = BetterDocs_DB::get_settings('archive_nested_subcategory');

global $wp_query;
$term_slug = $wp_query->query['doc_category'];
$term = get_term_by('slug', $wp_query->query['doc_category'], 'doc_category');

    echo '<div class="betterdocs-category-wraper betterdocs-single-wraper">';
    $live_search = BetterDocs_DB::get_settings('live_search');
    if ( $live_search == 1 ) {
        echo BetterDocs_Public::search();
    }

	echo '<div class="betterdocs-content-area">';
		$enable_archive_sidebar = BetterDocs_DB::get_settings('enable_archive_sidebar');
		if ($enable_archive_sidebar == 1) {
			echo '<aside id="betterdocs-sidebar">
				<div class="betterdocs-sidebar-content betterdocs-category-sidebar">';
                    $output = betterdocs_generate_output();
                    if (BetterDocs_DB::get_settings('alphabetically_order_term') == 1) {
                        $terms_orderby = 'name';
                    }
                    $shortcode = do_shortcode('[betterdocs_category_grid terms_order="'.$terms_order.'" terms_orderby="'.esc_html($terms_orderby).'" title_tag="'.BetterDocs_Helper::html_tag($output['betterdocs_sidebar_title_tag']).'" sidebar_list="true" posts_per_grid="-1"]');
                    echo apply_filters('betterdocs_sidebar_category_shortcode', $shortcode, $terms_orderby, $terms_order);
				echo '</div>
			</aside>';
		}

		echo '<div id="main" class="docs-listing-main">
			<div class="docs-category-listing">';
				$enable_breadcrumb = BetterDocs_DB::get_settings('enable_breadcrumb');

				if ($enable_breadcrumb == 1) {
					betterdocs_breadcrumbs();
				}
                $output = betterdocs_generate_output();

				echo '<div class="docs-cat-title">';
					echo wp_sprintf('<'.BetterDocs_Helper::html_tag($output['betterdocs_archive_title_tag']).' class="docs-cat-heading">%s </'.BetterDocs_Helper::html_tag($output['betterdocs_sidebar_title_tag']).'>', $term->name);
					echo wp_sprintf('<p>%s </p>', wpautop($term->description));
				echo '</div>
				<div class="docs-list">';
					$multikb = apply_filters('betterdocs_cat_template_multikb', false);
					$args = BetterDocs_Helper::list_query_arg('docs', $multikb, $term->slug, -1, $docs_orderby, $docs_order);
					$args = apply_filters('betterdocs_articles_args', $args, $term->term_id);
					$post_query = new WP_Query($args);

					if ($post_query->have_posts()) :
						echo '<ul>';
						while ($post_query->have_posts()) : $post_query->the_post();
							echo '<li>' . BetterDocs_Helper::list_svg() . '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
						endwhile;
						echo '</ul>';
					endif;
					wp_reset_query();

					// Sub category query
					if ($nested_subcategory == 1) {
						nested_category_list(
							$term->term_id,
							$multikb,
							'',
							'docs',
                            $docs_orderby,
                            $docs_order,
                            $terms_orderby,
                            $terms_order,
                            '',
                            ''
						);
					}
				echo '</div>
			</div>
		</div>
	</div>
</div>';

get_footer();
