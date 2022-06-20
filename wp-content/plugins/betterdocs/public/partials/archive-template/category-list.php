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

echo '<div class="betterdocs-wraper betterdocs-main-wraper">';

	$live_search = BetterDocs_DB::get_settings('live_search');
    if ( $live_search == 1 ) {
        echo BetterDocs_Public::search();
    }

	echo '<div class="betterdocs-archive-wrap betterdocs-archive-main betterdocs-category-list">';
        $output        = betterdocs_generate_output();
        $terms_orderby = BetterDocs_DB::get_settings('terms_orderby');
        $terms_order   = BetterDocs_DB::get_settings('terms_order');
        if (BetterDocs_DB::get_settings('alphabetically_order_term') == 1) {
            $terms_orderby = 'name';
        }
		$shortcode = do_shortcode('[betterdocs_category_grid title_tag="'.BetterDocs_Helper::html_tag($output['betterdocs_category_title_tag']).'" terms_order="'.$terms_order.'" terms_orderby="'.esc_html($terms_orderby).'"]');
		echo apply_filters('betterdocs_category_list_shortcode', $shortcode, $terms_orderby);
	echo '</div>
</div>';

get_footer();
