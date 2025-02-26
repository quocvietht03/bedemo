<?php

namespace BeDemoElementorWidgets\Widgets\ThemeFilter;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ThemeFilter extends Widget_Base
{

	public function get_name()
	{
		return 'bt-theme-filter';
	}

	public function get_title()
	{
		return __('Themes Filter', 'bedemo');
	}

	public function get_icon()
	{
		return 'eicon-posts-ticker';
	}

	public function get_categories()
	{
		return ['bedemo'];
	}

	protected function get_supported_ids()
	{
		$supported_ids = [];

		$wp_query = new \WP_Query(array(
			'post_type' => 'betheme',
			'post_status' => 'publish'
		));

		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				$supported_ids[get_the_ID()] = get_the_title();
			}
		}

		return $supported_ids;
	}

	public function get_supported_taxonomies()
	{
		$supported_taxonomies = [];

		$categories = get_terms(array(
			'taxonomy' => 'betheme_categories',
			'hide_empty' => false,
		));
		if (! empty($categories)  && ! is_wp_error($categories)) {
			foreach ($categories as $category) {
				$supported_taxonomies[$category->term_id] = $category->name;
			}
		}

		return $supported_taxonomies;
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Layout', 'bedemo'),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __('Posts Per Page', 'bedemo'),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'label' => __('Image Size', 'bedemo'),
				'show_label' => true,
				'default' => 'medium',
				'exclude' => ['custom'],
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label' => __('Image Ratio', 'bedemo'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.66,
				],
				'range' => [
					'px' => [
						'min' => 0.3,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-post--featured .bt-cover-image' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				],
			]
		);

		$this->add_control(
			'link_page_all',
			[
				'label' => __('Link Page All', 'bedemo'),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);
		$this->end_controls_section();
	}

	protected function register_query_section_controls()
	{
		$this->start_controls_section(
			'section_query',
			[
				'label' => __('Query', 'bedemo'),
			]
		);

		$this->start_controls_tabs('tabs_query');

		$this->start_controls_tab(
			'tab_query_include',
			[
				'label' => __('Include', 'bedemo'),
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __('Ids', 'bedemo'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __('Category', 'bedemo'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_query_exnlude',
			[
				'label' => __('Exclude', 'bedemo'),
			]
		);

		$this->add_control(
			'ids_exclude',
			[
				'label' => __('Ids', 'bedemo'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category_exclude',
			[
				'label' => __('Category', 'bedemo'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __('Offset', 'bedemo'),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'description' => __('Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'bedemo'),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'orderby',
			[
				'label' => __('Order By', 'bedemo'),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __('Date', 'bedemo'),
					'post_title' => __('Title', 'bedemo'),
					'menu_order' => __('Menu Order', 'bedemo'),
					'rand' => __('Random', 'bedemo'),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __('Order', 'bedemo'),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __('ASC', 'bedemo'),
					'desc' => __('DESC', 'bedemo'),
				],
			]
		);

		$this->end_controls_section();
	}


	protected function register_style_section_controls()
	{
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__('Image', 'bedemo'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __('Border Radius', 'bedemo'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .bt-post--featured .bt-cover-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('thumbnail_effects_tabs');

		$this->start_controls_tab(
			'thumbnail_tab_normal',
			[
				'label' => __('Normal', 'bedemo'),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .bt-post--featured img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'thumbnail_tab_hover',
			[
				'label' => __('Hover', 'bedemo'),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .bt-post:hover .bt-post--featured img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content', 'bedemo'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'category_style',
			[
				'label' => __('Category', 'bedemo'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __('Color', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--infor .bt-first-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __('Typography', 'bedemo'),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--infor .bt-first-category',
			]
		);

		$this->add_control(
			'title_style',
			[
				'label' => __('Title', 'bedemo'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => __('Color Hover', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Typography', 'bedemo'),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--title',
			]
		);

		$this->add_control(
			'meta_style',
			[
				'label' => __('Meta', 'bedemo'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __('Color', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--infor .list-filters li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'label' => __('Typography', 'bedemo'),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--infor .list-filters li',
			]
		);
		$this->add_control(
			'button_style',
			[
				'label' => __('Button', 'bedemo'),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'button_color',
			[
				'label' => __('Color', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--button a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_background_color',
			[
				'label' => __('Background', 'bedemo'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-post--button a' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __('Typography', 'bedemo'),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-post--button a',
			]
		);
		$this->end_controls_section();
	}

	protected function register_controls()
	{

		$this->register_layout_section_controls();
		$this->register_query_section_controls();

		$this->register_style_section_controls();
	}

	public function query_posts()
	{
		$settings = $this->get_settings_for_display();

		$args = [
			'post_type' => 'betheme',
			'post_status' => 'publish',
			'posts_per_page' => $settings['posts_per_page'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		if (! empty($settings['ids'])) {
			$args['post__in'] = $settings['ids'];
		}

		if (! empty($settings['ids_exclude'])) {
			$args['post__not_in'] = $settings['ids_exclude'];
		}



		return $query = new \WP_Query($args);
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$query = $this->query_posts();
		$json_data = json_encode([
			'posts_per_page' => $settings['posts_per_page'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'ids' => $settings['ids'],
			'ids_exclude' => $settings['ids_exclude'],
			'thumbnail_size' => $settings['thumbnail_size'],
		]);
?>
		<div class="bt-elwg-theme-filter--default">
			<?php
			$categories = get_terms(array(
				'taxonomy' => 'betheme_categories',
				'hide_empty' => false,
			));

			if (!empty($categories) && !is_wp_error($categories)) {
				echo '<ul class="bt-category-list" data-json="' . esc_attr($json_data) . '">';
				echo '<li data-id="0" class="active">' . esc_html__('All demos', 'bedemo') . '</li>';
				foreach ($categories as $category) {
					echo '<li data-id="' . esc_attr($category->term_id) . '" >' . esc_html($category->name) . '</li>';
				}
				echo '</ul>';
			}
			?>
			<div class="bt-content-theme">
				<div class="bt-loading-card">
					<div class="bt-card"></div>
					<div class="bt-card"><div class="bt-bg-logo"></div></div>
					<div class="bt-card"></div>
					<div class="bt-card"></div>
				</div>
				<?php
				if ($query->have_posts()) {
				?>
					<div class="bt-load-theme-list">
						<?php
						while ($query->have_posts()) : $query->the_post();
							get_template_part('framework/templates/theme', 'style1', array('image-size' => $settings['thumbnail_size'], 'layout' => 'default'));
						endwhile;
						?>
						<div class="bt-button-all">
							<a href="<?php echo esc_url($settings['link_page_all']['url']); ?>" <?php echo !empty($settings['link_page_all']['is_external']) ? 'target="_blank"' : ''; ?> class="btn btn-primary"><?php echo esc_attr__('See all Demos', 'bedemo'); ?><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path d="M15.938 5V13.125C15.938 13.3736 15.8392 13.6121 15.6634 13.7879C15.4876 13.9637 15.2491 14.0625 15.0005 14.0625C14.7518 14.0625 14.5134 13.9637 14.3375 13.7879C14.1617 13.6121 14.063 13.3736 14.063 13.125V7.26563L5.66374 15.6633C5.48762 15.8394 5.24875 15.9383 4.99967 15.9383C4.7506 15.9383 4.51173 15.8394 4.33561 15.6633C4.15949 15.4872 4.06055 15.2483 4.06055 14.9992C4.06055 14.7501 4.15949 14.5113 4.33561 14.3352L12.7348 5.9375H6.87545C6.62681 5.9375 6.38836 5.83873 6.21254 5.66291C6.03673 5.4871 5.93795 5.24864 5.93795 5C5.93795 4.75136 6.03673 4.5129 6.21254 4.33709C6.38836 4.16127 6.62681 4.0625 6.87545 4.0625H15.0005C15.2491 4.0625 15.4876 4.16127 15.6634 4.33709C15.8392 4.5129 15.938 4.75136 15.938 5Z" fill="#111111" />
								</svg></a>
						</div>
					</div>
				<?php
				} else {
					get_template_part('framework/templates/post', 'none');
				}
				?>
			</div>
		</div>
<?php
		wp_reset_postdata();
	}

	protected function content_template() {}
}
