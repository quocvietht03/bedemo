<?php

namespace BeDemoElementorWidgets\Widgets\ImageFeature;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ImageFeature extends Widget_Base
{

	public function get_name()
	{
		return 'bt-image-feature';
	}

	public function get_title()
	{
		return __('Image Feature', 'bedemo');
	}

	public function get_icon()
	{
		return 'eicon-posts-ticker';
	}

	public function get_categories()
	{
		return ['bedemo'];
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'bedemo'),
			]
		);
		$this->add_control(
			'select_theme',
			[
				'label' => esc_html__('Select Themes', 'bedemo'),
				'type' => Controls_Manager::SELECT,
				'default' => 'cleanira',
				'options' => [
					'bearsthemes' => esc_html__('Bearsthemes', 'bedemo'),
					'cleanira' => esc_html__('Cleanira', 'bedemo'),
					'awakenur' => esc_html__('Awakenur', 'bedemo'),
					'autoart' => esc_html__('Autoart', 'bedemo'),
					'utenzo' => esc_html__('Utenzo', 'bedemo'),
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label' => esc_html__('Choose Image', 'bedemo'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'bedemo'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __('Title', 'bedemo'),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'bedemo'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '#',
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'label' => __('Image Size', 'bedemo'),
				'show_label' => true,
				'default' => 'medium_large',
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
					'{{WRAPPER}} .bt-cover-image' => 'padding-bottom: calc( {{SIZE}} * 100% );',
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
					'{{WRAPPER}} .bt-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bt-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Typography', 'bedemo'),
				'selector' => '{{WRAPPER}} .bt-title',
			]
		);
		$this->end_controls_section();
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_style_section_controls();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$attachment = wp_get_attachment_image_src($settings['image']['id'], $settings['thumbnail_size']);
		if (!empty($attachment)) {
			$image = '<img src="' . esc_url($attachment[0]) . '" alt="">';
		} else {
			$image = '<img src="' . esc_url($settings['image']['url']) . '" alt="">';
		}
		$theme_class = $settings['select_theme'] ?? 'cleanira';
?>
		<div class="bt-elwg-image-feature--<?php echo esc_attr($theme_class) ?>">
			<div class="bt-image-feature-item">
				<?php echo '<div class="bt-cover-image">' . $image . '</div>'; ?>
				<?php
				if (!empty($settings['link'])) {
					echo '<div class="bt-button-image bt-button-hover-'.$theme_class.'"><a href="' . esc_url($settings['link']) . '" class="bt-button" target="_blank"><span class="bt-heading">' . esc_html__('View Page', 'bedemo') . '</span></a></div>';
				}
				?>
			</div>
			<?php
			if (!empty($settings['title'])) {
				if (!empty($settings['link'])) {
					echo '<div class="bt-title"><a href="' . esc_url($settings['link']) . '" target="_blank">' . $settings['title'] . '</a></div>';
				} else {
					echo '<div class="bt-title">' . $settings['title'] . '</div>';
				}
			}
			?>
		</div>
<?php
	}

	protected function content_template() {}
}
