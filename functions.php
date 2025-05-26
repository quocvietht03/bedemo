<?php
/* Register Sidebar */
if (!function_exists('bedemo_register_sidebar')) {
	function bedemo_register_sidebar(){
		register_sidebar(array(
			'name' => esc_html__('Main Sidebar', 'bedemo'),
			'id' => 'main-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
		));
	}
	add_action( 'widgets_init', 'bedemo_register_sidebar' );
}

/* Add Support Upload Image Type SVG */
function bedemo_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'bedemo_mime_types');

/* Enqueue Script */
if (!function_exists('bedemo_enqueue_scripts')) {
	function bedemo_enqueue_scripts() {
		global $bedemo_options;

		/* Fonts */
		wp_enqueue_style( 'bedemo-fonts', get_template_directory_uri().'/assets/css/fonts.css',  array(), false );
		wp_enqueue_style( 'bedemo-main', get_template_directory_uri().'/assets/css/main.css',  array(), false );
		wp_enqueue_style( 'bedemo-style', get_template_directory_uri().'/style.css',  array(), false );
		wp_enqueue_script( 'bedemo-main', get_template_directory_uri().'/assets/js/main.js', array('jquery'), '', true);

		/* Load custom style */
		$custom_style = '';
		// $custom_style .= '.test{color: red;}';

		if($custom_style){
			wp_add_inline_style( 'bedemo-style', $custom_style );
		}

		/* Custom script */
		$custom_script = '';
		if (isset($bedemo_options['custom_js_code']) && $bedemo_options['custom_js_code']) {
			$custom_script .= $bedemo_options['custom_js_code'];
		}
		if ($custom_script) {
			wp_add_inline_script( 'bedemo-main', $custom_script );
		}

		/* Options to script */
		$mobile_width = 991;

		$js_options = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'enable_mobile' => $mobile_width
		);
		wp_localize_script( 'bedemo-main', 'option_ob', $js_options );
		wp_enqueue_script( 'bedemo-main' );

	}
	add_action( 'wp_enqueue_scripts', 'bedemo_enqueue_scripts' );
}

/* Add Stylesheet And Script Backend */
if (!function_exists('bedemo_enqueue_admin_scripts')) {
	function bedemo_enqueue_admin_scripts(){
		wp_enqueue_style( 'bedemo-fonts', get_template_directory_uri().'/assets/css/fonts.css',  array(), false );
		wp_enqueue_script( 'bedemo-admin-main', get_template_directory_uri().'/assets/js/admin-main.js', array('jquery'), '', true);
		wp_enqueue_style( 'bedemo-admin-main', get_template_directory_uri().'/assets/css/admin-main.css', array(), false );
	}
	add_action( 'admin_enqueue_scripts', 'bedemo_enqueue_admin_scripts');
}

/* CPT Load */
require_once get_template_directory().'/framework/cpt-betheme.php';

/* ACF Options */
require_once get_template_directory() . '/framework/acf-options.php';

/* Shortcodes */
require_once get_template_directory().'/framework/shortcodes.php';

/* Add Comment Rating */
require_once get_template_directory().'/framework/comment-rating.php';

/* Template functions */
require_once get_template_directory().'/framework/template-helper.php';

/* Post Functions */
require_once get_template_directory().'/framework/templates/post-helper.php';

/* Block Load */
require_once get_template_directory().'/framework/block-load.php';

/* Widgets Load */
require_once get_template_directory().'/framework/widget-load.php';

/* Interactive API */
require_once get_template_directory().'/framework/interactive-api.php';


if(function_exists('get_field')){
	/* Orbit circle effect */
	function bedemo_body_class($classes) {
		$orbit_circle = get_field('effect_orbit_circle', 'options');
		$bg_pattern = get_field('effect_bg_pattern', 'options');
		$bg_buble = get_field('effect_bg_buble', 'options');
		$bg_scroll = get_field('effect_bg_scroll', 'options');
		$img_zoom = get_field('effect_img_zoom', 'options');

		if($orbit_circle) {
			$classes[] = 'bt-orbit-enable';
		}

		if($bg_pattern) {
			$classes[] = 'bt-bg-pattern-enable';
		}

		if($bg_buble) {
			$classes[] = 'bt-bg-buble-enable';
		}

		if($bg_scroll) {
			$classes[] = 'bt-bg-scroll-enable';
		}

		if($img_zoom) {
			$classes[] = 'bt-img-zoom-enable';
		}

		return $classes;
	}
	add_filter('body_class', 'bedemo_body_class');
}

/* query id elementor Search Blog*/
function bt_custom_search_blog_query($query)
{
    if (isset($query)) {
        $query->set('post_type', 'post');
        $query->set('s', get_search_query());
    }
}
add_action('elementor/query/bt_search_blog', 'bt_custom_search_blog_query');

/* Custom search posts */
function bt_custom_search_filter( $query ) {
    if ( $query->is_search() && !is_admin() ) {
        if ( !is_post_type_archive( 'product' ) && !is_tax( 'product_cat' ) && !is_singular( 'product' ) ) {
            $query->set( 'post_type', 'post' );
        }
    }
}
add_action( 'pre_get_posts', 'bt_custom_search_filter' );
