<?php

namespace BeDemoElementorWidgets\Widgets\ImageFeatureSlider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ImageFeatureSlider extends Widget_Base
{

    public function get_name()
    {
        return 'bt-image-feature-slider';
    }

    public function get_title()
    {
        return __('Image Feature Slider', 'bedemo');
    }

    public function get_icon()
    {
        return 'eicon-posts-ticker';
    }

    public function get_categories()
    {
        return ['bedemo'];
    }

    public function get_script_depends()
    {
        return ['swiper-slider', 'elementor-widgets'];
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
            'style_theme',
            [
                'label' => __('Style Theme', 'bedemo'),
                'type' => Controls_Manager::SELECT, 
                'default' => 'default',
                'options' => [
                    'default' => __('Cleanira', 'bedemo'),
                    'awakenur' => __('Awakenur', 'bedemo'),
                ],
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'image_item',
            [
                'label' => __('Image', 'bedemo'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'bedemo'),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is heading', 'bedemo' ),
            ]
        );
        $repeater->add_control(
            'image_url',
            [
                'label' => esc_html__('Image Url', 'bedemo'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );


        $this->add_control(
            'list',
            [
                'label' => __('List Feature', 'bedemo'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'image_item' => Utils::get_placeholder_image_src(),
                        'image_url' => '#'
                    ],
                    [
                        'image_item' => Utils::get_placeholder_image_src(),
                        'image_url' => '#'
                    ],
                    [
                        'image_item' => Utils::get_placeholder_image_src(),
                        'image_url' => '#'
                    ],
                ],
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
                    '{{WRAPPER}} .bt-image--item .bt-cover-image' => 'padding-bottom: calc( {{SIZE}} * 100% );',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider', 'bedemo'),
            ]
        );
        $this->add_control(
            'slider_autoplay',
            [
                'label' => __('Enable Autoplay', 'bedemo'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'bedemo'),
                'label_off' => __('No', 'bedemo'),
                'default' => 'no',
            ]
        );
        $this->add_control(
            'slider_direction_rlt',
            [
                'label' => __('Slider Direction RTL', 'bedemo'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'bedemo'),
                'label_off' => __('No', 'bedemo'),
                'default' => 'no',
            ]
        );
        $this->add_responsive_control(
            'slider_item',
            [
                'label' => __('Slider Item', 'bedemo'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->add_control(
            'slider_speed',
            [
                'label' => __('Slider Speed', 'bedemo'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10000,
            ]
        );
        $this->add_control(
            'slider_spacebetween',
            [
                'label' => __('Slider SpaceBetween', 'bedemo'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
            ]
        );
        $this->add_control(
            'slider_dots',
            [
                'label' => __('Enable Dots', 'bedemo'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'bedemo'),
                'label_off' => __('No', 'bedemo'),
                'default' => 'no',
            ]
        );
        $this->end_controls_section();
    }
    protected function register_style_section_controls() {

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_style',
			[
				'label' => __( 'Title', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-image-feature-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Color Hover', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-image-feature-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-image-feature-title',
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
        if (empty($settings['list'])) {
            return;
        }

        if ($settings['slider_direction_rlt'] === 'yes') {
            $slider_direction = 'rtl';
        } else {
            $slider_direction = 'ltr';
        }
        if ($settings['slider_autoplay'] === 'yes') {
            $autoplay = true;
        } else {
            $autoplay = false;
        }
        if ($settings['slider_dots'] === 'yes') {
            $slider_dots = true;
        } else {
            $slider_dots = false;
        }
        $slider_item_desktop = $settings['slider_item']['size'] ?? $settings['slider_item'];
        $slider_item_tablet = $settings['slider_item_tablet'] ?? 2;
        $slider_item_mobile = $settings['slider_item_mobile'] ?? 1;
        $slider_speed = $settings['slider_speed'];
        $slider_space_between = $settings['slider_spacebetween'];
        $theme_style = $settings['style_theme'];
?>
        <div class="bt-feature-slider-js bt-elwg-image-feature-slider--<?php echo esc_attr($theme_style); ?> swiper" data-dots="<?php echo esc_attr($slider_dots) ?>" data-autoplay="<?php echo esc_attr($autoplay) ?>" data-direction="<?php echo esc_attr($slider_direction) ?>" data-item="<?php echo esc_attr($slider_item_desktop) ?>" data-item-tablet="<?php echo !empty($slider_item_tablet) ? $slider_item_tablet : 2; ?>" data-item-mobile="<?php echo !empty($slider_item_mobile) ? $slider_item_mobile : 1; ?>" data-speed="<?php echo esc_attr($slider_speed) ?>" data-spacebetween="<?php echo esc_attr($slider_space_between) ?>">
            <ul class="bt-image-feature-slider swiper-wrapper">
                <?php foreach ($settings['list'] as $index => $item) {
                    $attachment = wp_get_attachment_image_src($item['image_item']['id'], $settings['thumbnail_size']);
                    if (!empty($attachment)) {
                        $image = '<img src="' . esc_url($attachment[0]) . '" alt="">';
                    } else {
                        $image = '<img src="' . esc_url($item['image_item']['url']) . '" alt="">';
                    }
                ?>
                    <li class="bt-image--item swiper-slide">
                        <div class="bt-image-feature-item">
                            <?php echo '<div class="bt-cover-image">' . $image . '</div>'; 
                            if (!empty($item['image_url'])) {
                                echo '<div class="bt-button-image"><a href="' . esc_url($item['image_url']) . '" class="button" target="_blank">' . esc_html__('View Page', 'bedemo') . '</a></div>';
                            }
                            ?>
                        </div>
                        <?php 
						if(!empty($item['title'])) {
							if(!empty($item['image_url'])) {
								echo '<h3 class="bt-image-feature-title">
										<a href="' . esc_url($item['image_url']) . '">' . $item['title'] . '</a>
									</h3>';
							} else {
								echo '<h3 class="bt-image-feature-title">' . $item['title'] . '</h3>';
							}
						}
					?>
                    </li>
                <?php } ?>
            </ul>
            <div class="swiper-pagination"></div>
        </div>
<?php
    }

    protected function content_template() {}
}
