<?php 
/**
 * Custom REST API Endpoint
 */
add_action('rest_api_init', function () {
    register_rest_route('themes', '/campaign/', array(
        'methods'  => 'GET',
        'callback' => 'bti_themes_compaign_api_callback',
        array(
            'theme' => 'Alone',
            // 'btiFeatured' => '',
        ),
    ));
});

// Get post ID by theme name
function bti_get_post_id_by_theme_name($theme_name) {
    $args = array(
        'post_type'  => 'betheme',
        'meta_query' => array(
            array(
                'key'   => 'sub_title',
                'value' => $theme_name,
                'compare' => '='
            )
        ),
        'fields' => 'ids',
        'posts_per_page' => 1,
    );
    $posts = get_posts($args);

    return !empty($posts) ? $posts[0] : null;
}

/* Get purchase theme */
function bti_get_purchase_theme($theme_name = 'Alone') {
    $post_id = bti_get_post_id_by_theme_name($theme_name);

    $link = get_field('link_purchase', $post_id);

    return $link;

}

/* Related themes query */
function bti_related_themes_query($post_id, $limit = 5) {
    if (!$post_id) {
        return;
    }

    $related_themes = get_field('related_themes', $post_id);
    if($related_themes) {
        $related_themes = array_diff($related_themes, [$post_id]);
    }
    
    
    if (!$related_themes) {
        $taxonomy = 'betheme_categories';
        $terms = wp_get_post_terms($post_id, $taxonomy);
        $term_ids = wp_list_pluck($terms, 'term_id');
        
        $query_args = array(
            'post_type'      => get_post_type($post_id),
            'posts_per_page' => $limit,
            'post__not_in'   => [$post_id],
            'orderby' => 'menu_order',
            'order' => 'DESC',
            'tax_query'      => [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ],
            ],
        );
    } else {
        $query_args = array(
            'post_type'      => get_post_type($post_id),
            'post__in'   => $related_themes,
            'orderby'=>'post__in',
        );
    }

    return new WP_Query($query_args);
}

/* Get exclude related themes */
function bti_get_exclude_related_themes($post_id) {
    if (!$post_id) {
        return;
    }

    $list_themes = bti_related_themes_query($post_id);

    $exclude_themes = array();
    $exclude_themes[] = $post_id;

    if ($list_themes->have_posts()) {

        while ($list_themes->have_posts()): $list_themes->the_post();
            $exclude_themes[] = get_the_ID();
            
        endwhile;
        wp_reset_postdata();
    }
    return $exclude_themes;
}

/* New themes query */
function bti_new_themes_query($post_id, $limit = 6) {
    if (!$post_id) {
        return;
    }

    $exclude_themes = bti_get_exclude_related_themes($post_id);

    if(count($exclude_themes) <= 1) {
        $limit = $limit * 2;
    }
    
    $query_args = array(
        'post_type'      => get_post_type($post_id),
        'posts_per_page' => $limit,
        'post__not_in'   => $exclude_themes,
        'orderby' => 'menu_order',
        'order' => 'DESC',
    );

    return new WP_Query($query_args);
}

/* Get related themes */
function bti_get_related_themes($theme_name = 'Alone') {
    $post_id = bti_get_post_id_by_theme_name($theme_name);
    
    if (!$post_id) {
        return '<h3 class="bti-not-found">' . __('No Related Themes by ', 'bedemo') . $theme_name . '</h3>';
    }

    $list_themes = bti_related_themes_query($post_id);
    
    ob_start();

    if ($list_themes->have_posts()) {
        ?>
        <span class="bti-list-related">
            <?php echo esc_html__('Related Themes', 'bedemo'); ?>
        </span>
        <?php 

        while ($list_themes->have_posts()): $list_themes->the_post();

            $title = get_the_title();
            $sub_title = get_field('sub_title');
            $thumb = get_field('thumb_preview');
            $thumb_url = $thumb['url'] ? $thumb['url'] : get_template_directory_uri() . '/assets/images/bti-placeholder.jpg';
            $link = get_field('link_theme');
            $price = get_field('price');

            ?>
                <a target="_blank" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                    <div class="bti-theme">
                        <div class="bti-img-hover bti-lazy-load">
                            <img itemprop="image" data-image="<?php echo esc_url($thumb_url); ?>" width="225" height="114" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bti-placeholder.jpg'); ?>" alt="<?php echo esc_attr($sub_title); ?>">
                        </div>
                        <div class="bti-theme-info">
                            <div class="bti-theme-title">
                                <?php 
                                    echo '<span class="bti-theme-name">' . $sub_title . '</span>';

                                    $taxonomy = 'betheme_categories'; 
                                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                                    $term = array_pop($terms);
                                    echo '<span class="bti-theme-tag">' . $term->name . '</span>';
                                ?>
                            </div>
                            <?php echo '<div class="bti-theme-price">' . $price . '</div>'; ?>
                        </div>
                    </div>
                </a>
            <?php
        endwhile;
        wp_reset_postdata();
    }

    return ob_get_clean();
}

/* Get new themes */
function bti_get_new_themes($theme_name = 'Alone', $limit = 6) {
    $post_id = bti_get_post_id_by_theme_name($theme_name);
    
    if (!$post_id) {
        return '<h3 class="bti-not-found">' . __('No New Themes by ', 'bedemo') . $theme_name . '</h3>';
    }

    $list_themes = bti_new_themes_query($post_id);
    
    ob_start();

    if ($list_themes->have_posts()) {
        ?>
        <span class="bti-list-new">
            <?php echo esc_html__('New Themes', 'bedemo'); ?>
        </span>
        <?php 

        while ($list_themes->have_posts()): $list_themes->the_post();

            $title = get_the_title();
            $sub_title = get_field('sub_title');
            $thumb = get_field('thumb_preview');
            $thumb_url = $thumb['url'] ? $thumb['url'] : get_template_directory_uri() . '/assets/images/bti-placeholder.jpg';
            $link = get_field('link_theme');
            $price = get_field('price');

            ?>
                <a target="_blank" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                    <div class="bti-theme">
                        <div class="bti-img-hover bti-lazy-load">
                            <img itemprop="image" data-image="<?php echo esc_url($thumb_url); ?>" width="225" height="114" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bti-placeholder.jpg'); ?>" alt="<?php echo esc_attr($sub_title); ?>">
                        </div>
                        <div class="bti-theme-info">
                            <div class="bti-theme-title">
                                <?php 
                                    echo '<span class="bti-theme-name">' . $sub_title . '</span>';

                                    $taxonomy = 'betheme_categories'; 
                                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                                    $term = array_pop($terms);
                                    echo '<span class="bti-theme-tag">' . $term->name . '</span>';
                                ?>
                            </div>
                            <?php echo '<div class="bti-theme-price">' . $price . '</div>'; ?>
                        </div>
                    </div>
                </a>
            <?php
        endwhile;
        wp_reset_postdata();
    }

    return ob_get_clean();
}

function bti_themes_compaign_api_callback($request) {
    $theme = trim($request->get_param('theme'));
    $link_purchase = bti_get_purchase_theme($theme);

    $post_id = bti_get_post_id_by_theme_name($theme);
    $enable_related = get_field('enable_related_themes', $post_id);
    
    ob_start();
    
    ?>
    <section class="bti-sidearea bti-bearsthemes bti-btn-horizontal-right bti-btn-alt-no bti-loaded">
        <?php if($enable_related) { ?>
            <div class="bti-theme-dropdown" style="top: calc(40% - 25px);">
                <div class="bti-btn">
                    <span class="bti-icon">
                        <img itemprop="image" width="26" height="26" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/site-icon.png'); ?>" alt="<?php echo esc_html('Bearsthemes', 'bdemo'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2l0 64-112 0C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96l96 0 0 64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z"/>
                        </svg>
                    </span>
                    <span class="bti-text-name">
                        <?php echo esc_html__('RELATED', 'bedemo'); ?>
                    </span>
                </div>
            </div>

            <?php if($link_purchase) { ?>
                <div class="bti-purchase" style="top: calc(40% + 25px);">
                    <a target="_blank" href="<?php echo esc_url($link_purchase); ?>" class="bti-btn" title="<?php echo esc_attr('Buy ' . $theme . ' Now!'); ?>">
                        <span class="bti-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64l0 48-128 0 0-48zm-48 48l-64 0c-26.5 0-48 21.5-48 48L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-208c0-26.5-21.5-48-48-48l-64 0 0-48C336 50.1 285.9 0 224 0S112 50.1 112 112l0 48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                            </svg>
                        </span>
                        <span class="bti-purchase-text">
                            <?php echo esc_html__('BUY NOW', 'bedemo'); ?>
                        </span>
                    </a>
                </div>
            <?php } ?>

            <div class="bti-list-holder">
                <div class="bti-list">
                    <div class="bti-list-inner">
                        <div class="bti-logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/site-logo.png'); ?>" alt="<?php echo esc_html('Bearsthemes', 'bdemo'); ?>" />
                            </a>
                        </div>

                        <?php 
                            echo bti_get_related_themes($theme);
                            echo bti_get_new_themes($theme); 
                        ?>
                    </div>
                </div>

                <div class="bti-list-bottom">
                    <a class="bti-link-holder" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
                        <span class="link-text-holder">
                            <?php echo esc_html__('VIEW ALL BEARSTHEMES', 'bedemo'); ?>
                        </span>
                        <span class="link-svg-holder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path d="M32 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c53 0 96-43 96-96l0-306.7 73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 109.3 160 416c0 17.7-14.3 32-32 32l-96 0z"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <a class="bti-buy-on-envato" href="<?php echo esc_url($link_purchase); ?>" title="<?php echo esc_attr('Buy ' . $theme . 'On Envato'); ?>" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.9868 20C11.4808 20 11.8814 19.5995 11.8814 19.1055C11.8814 18.6114 11.4808 18.2109 10.9868 18.2109C10.4928 18.2109 10.0923 18.6114 10.0923 19.1055C10.0923 19.5995 10.4928 20 10.9868 20Z"></path>
                    <path d="M16.1249 13.0141L11.0852 13.554C10.993 13.5641 10.9453 13.4462 11.0187 13.3891L15.9507 9.54932C16.271 9.2876 16.4749 8.87979 16.3874 8.44308C16.2999 7.77355 15.7468 7.33683 15.0484 7.42433L9.68984 8.2087C9.59531 8.22277 9.54453 8.10167 9.62031 8.04386L14.932 3.98843C15.9804 3.17359 16.0671 1.57203 15.107 0.640798C14.2336 -0.232631 12.8359 -0.203725 11.9625 0.669704L3.40318 9.37432C3.08287 9.72353 2.93756 10.1892 3.02506 10.6845C3.17037 11.4704 3.9563 11.9946 4.74301 11.8493L9.35703 10.9079C9.45703 10.8876 9.51172 11.0212 9.425 11.0759L4.30552 14.3524C3.6649 14.7602 3.37428 15.4875 3.5774 16.2157C3.7813 17.1766 4.74223 17.7297 5.67347 17.4969L13.3258 15.6118C13.4117 15.5907 13.475 15.6907 13.4195 15.7594L12.2242 17.2344C11.9039 17.6422 12.4281 18.1953 12.8648 17.875L16.7953 14.6438C17.4937 14.0618 17.0281 12.9258 16.1257 13.0133L16.1249 13.0141Z"></path>
                </svg>
                <?php echo esc_html__('Buy', 'bedemo') . '<span>' . $theme . esc_html__(' Now', 'bedemo') . '</span>'; ?>
            </a>
        <?php } ?>
    </section>
    <?php
    $campaign_html = ob_get_clean();
    return rest_ensure_response($campaign_html);
}