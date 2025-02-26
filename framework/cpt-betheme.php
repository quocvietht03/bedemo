<?php
/*
 * BearsThemess CPT
 */

function bedemo_betheme_register() {

	$cpt_slug = get_theme_mod('bedemo_betheme_slug');

	if(isset($cpt_slug) && $cpt_slug != ''){
		$cpt_slug = $cpt_slug;
	} else {
		$cpt_slug = 'betheme';
	}

	$labels = array(
		'name'               => esc_html__( 'BearsThemes', 'bedemo' ),
		'singular_name'      => esc_html__( 'betheme', 'bedemo' ),
		'add_new'            => esc_html__( 'Add New', 'bedemo' ),
		'add_new_item'       => esc_html__( 'Add New', 'bedemo' ),
		'all_items'          => esc_html__( 'All BearsThemes', 'bedemo' ),
		'edit_item'          => esc_html__( 'Edit BearsThemes', 'bedemo' ),
		'new_item'           => esc_html__( 'Add New BearsThemes', 'bedemo' ),
		'view_item'          => esc_html__( 'View Item', 'bedemo' ),
		'search_items'       => esc_html__( 'Search BearsThemes', 'bedemo' ),
		'not_found'          => esc_html__( 'No betheme(s) found', 'bedemo' ),
		'not_found_in_trash' => esc_html__( 'No betheme(s) found in trash', 'bedemo' )
	);

  $args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-admin-post',
		'rewrite'         => array('slug' => $cpt_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'excerpt', 'thumbnail', 'comments')
  );

  add_filter( 'enter_title_here',  'bedemo_betheme_change_default_title');

  register_post_type( 'betheme' , $args );
}
add_action('init', 'bedemo_betheme_register', 1);


function bedemo_betheme_taxonomy() {

	register_taxonomy(
		"betheme_categories",
		array("betheme"),
		array(
			"hierarchical"   => true,
			"label"          => "Categories",
			"singular_label" => "Category",
			"rewrite"        => true
		)
	);

	register_taxonomy(
        'betheme_tag',
        'betheme',
        array(
            'hierarchical'  => false,
            'label'         => __( 'Tags', 'bedemo' ),
            'singular_name' => __( 'Tag', 'bedemo' ),
            'rewrite'       => true,
            'query_var'     => true
        )
    );

}
add_action('init', 'bedemo_betheme_taxonomy', 1);


function bedemo_betheme_change_default_title( $title ) {
	$screen = get_current_screen();

	if ( 'betheme' == $screen->post_type )
		$title = esc_html__( "Enter the betheme's name here", 'bedemo' );

	return $title;
}


function bedemo_betheme_edit_columns( $betheme_columns ) {
	$betheme_columns = array(
		"cb"                     => "<input type=\"checkbox\" />",
		"title"                  => esc_html__('Title', 'bedemo'),
		"thumbnail"              => esc_html__('Thumbnail', 'bedemo'),
		"betheme_categories" 			 => esc_html__('Categories', 'bedemo'),
		"date"                   => esc_html__('Date', 'bedemo'),
	);
	return $betheme_columns;
}
add_filter( 'manage_edit-betheme_columns', 'bedemo_betheme_edit_columns' );

function bedemo_betheme_column_display( $betheme_columns, $post_id ) {

	switch ( $betheme_columns ) {

		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 64;
			$height = (int) 64;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb; // No need to escape
			} else {
				echo esc_html__('None', 'bedemo');
			}
			break;

		// Display the betheme tags in the column view
		case "betheme_categories":

		if ( $category_list = get_the_term_list( $post_id, 'betheme_categories', '', ', ', '' ) ) {
			echo $category_list; // No need to escape
		} else {
			echo esc_html__('None', 'bedemo');
		}
		break;
	}
}
add_action( 'manage_betheme_posts_custom_column', 'bedemo_betheme_column_display', 10, 2 );

function bt_filter_themes() {
    if ( ! isset( $_POST['cat_id'] ) || ! isset( $_POST['json_data'] ) ) {
        wp_die();
    }

    $cat_id = intval( $_POST['cat_id'] );
    $json_data = $_POST['json_data'];

	$args = [
		'post_type' => 'betheme',
		'post_status' => 'publish',
		'posts_per_page' => $json_data['posts_per_page'],
		'orderby' => $json_data['orderby'],
		'order' => $json_data['order'],
	];
	if (!empty($cat_id) && $cat_id != 0) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'betheme_categories',
				'field'    => 'term_id',
				'terms'    => $cat_id,
			],
		];
	}
	if (! empty($json_data['ids'])) {
		$args['post__in'] = $json_data['ids'];
	}

	if (! empty($json_data['ids_exclude'])) {
		$args['post__not_in'] = $json_data['ids_exclude'];
	}

    $query = new WP_Query( $args );
	ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
			get_template_part('framework/templates/theme', 'style1', array('image-size' => $json_data['thumbnail_size'], 'layout' => 'default'));
        }
    } 
	wp_reset_postdata();
	$output['items'] = ob_get_clean();
 
	wp_send_json_success($output);
    wp_die();
}
add_action( 'wp_ajax_bt_filter_themes', 'bt_filter_themes' );
add_action( 'wp_ajax_nopriv_bt_filter_themes', 'bt_filter_themes' );
