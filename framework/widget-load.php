<?php
namespace BeDemoElementorWidgets;

/**
 * Class ElementorWidgets
 *
 * Main ElementorWidgets class
 * @since 1.0.0
 */
class ElementorWidgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var ElementorWidgets The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return ElementorWidgets An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public $widgets = array();

	public function widgets_list() {

		$this->widgets = array(
			'site-information',
			'site-social',
			'site-copyright',
			'instagram-posts',
			'contact-information',
			'page-breadcrumb',
			'step-list',
			'post-grid',
			'post-grid-style-1',
			'post-grid-style-2',
			'post-loop-item',
			'post-loop-item-style-1',
			'post-loop-item-style-2',
			'orbit-circle',
			'pattern-background',
			'buble-background',
			'highlighted-heading',
			'image-slider',
			'review-slider',
			'text-slider',
			'demo-item',
			'feature-item',
			'image-slider-vertical',
			'heading-animation',
			'image-feature',
			'image-feature-slider',
			'theme-feature',
			'theme-filter',
			'features-slider-vertical',
		);

		return $this->widgets;
	}

	/**
	 * widget_styles
	 *
	 * Load required core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_styles() {
		wp_enqueue_style('slick-slider', get_template_directory_uri(). '/assets/libs/slick/slick.css',array(), false);
		wp_enqueue_style('swiper-slider', get_template_directory_uri() . '/assets/libs/swiper/swiper.min.css', array(), false);

	}

	/**
	 * widget_scripts
	 *
	 * Load required core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script('slick-slider', get_template_directory_uri().'/assets/libs/slick/slick.min.js', array('jquery'), '', true);
		wp_register_script('swiper-slider', get_template_directory_uri() . '/assets/libs/swiper/swiper.min.js', array('jquery'), '', true);

    	wp_register_script( 'elementor-widgets',  get_stylesheet_directory_uri() . '/framework/widgets/frontend.js', [ 'jquery' ], '', true );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {

		foreach( $this->widgets_list() as $widget ) {
			require_once( get_stylesheet_directory() . '/framework/widgets/'. $widget .'/widget.php' );

			foreach( glob( get_stylesheet_directory() . '/framework/widgets/'. $widget .'/skins/*.php') as $filepath ) {
				include $filepath;
			}
		}

	}

	/**
	 * Register categories
	 *
	 * Register new Elementor category.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_categories( $elements_manager ) {

		$elements_manager->add_category(
			'bedemo',
			[
				'title' => esc_html__( 'BeDemo', 'bedemo' )
			]
		);

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SiteInformation\Widget_SiteInformation());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SiteSocial\Widget_SiteSocial());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SiteCopyright\Widget_SiteCopyright());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\InstagramPosts\Widget_InstagramPosts());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ContactInformation\Widget_ContactInformation());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PageBreadcrumb\Widget_PageBreadcrumb());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\StepList\Widget_StepList());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostGrid\Widget_PostGrid());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostGridStyle1\Widget_PostGridStyle1());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostGridStyle2\Widget_PostGridStyle2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostLoopItem\Widget_PostLoopItem());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostLoopItemStyle1\Widget_PostLoopItemStyle1());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PostLoopItemStyle2\Widget_PostLoopItemStyle2());

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\OrbitCircle\Widget_OrbitCircle());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\PatternBackground\Widget_PatternBackground());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\BubleBackground\Widget_BubleBackground());

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ImageSlider\Widget_ImageSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ImageSliderVertical\Widget_ImageSliderVertical());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ReviewSlider\Widget_ReviewSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TextSlider\Widget_TextSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\DemoItem\Widget_DemoItem());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\FeatureItem\Widget_FeatureItem());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\HeadingAnimation\Widget_HeadingAnimation());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ImageFeature\Widget_ImageFeature());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\HighlightedHeading\Widget_HighlightedHeading());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ImageFeatureSlider\Widget_ImageFeatureSlider());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ThemeFeature\Widget_ThemeFeature());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ThemeFilter\Widget_ThemeFilter());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\FeaturesSliderVertical\Widget_FeaturesSliderVertical());
	}

	/**
	 *  ElementorWidgets class constructor
	 *
	 * Register action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Register widget styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register categories
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

	}
}

// Instantiate ElementorWidgets Class
ElementorWidgets::instance();
