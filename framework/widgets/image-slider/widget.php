<?php

namespace BeDemoElementorWidgets\Widgets\ImageSlider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ImageSlider extends Widget_Base
{

    public function get_name()
    {
        return 'bt-image-slider';
    }

    public function get_title()
    {
        return __('Image Slider', 'bedemo');
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
            'image_url',
            [
                'label' => esc_html__('Image Url', 'bedemo'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'bedemo'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'top' => esc_html__('Top', 'bedemo'),
                    'bottom' => esc_html__('Bottom', 'bedemo'),
                    'center' => esc_html__('Center', 'bedemo'),
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __('List Brands', 'bedemo'),
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
        $this->add_control(
            'img_border_radius',
            [
                'label' => __('Border Radius', 'bedemo'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .bt-image--item .bt-cover-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->register_layout_section_controls();
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

        $slider_item_desktop = $settings['slider_item']['size'] ?? $settings['slider_item'];
        $slider_item_tablet = $settings['slider_item_tablet'] ?? 2;
        $slider_item_mobile = $settings['slider_item_mobile'] ?? 1;
        $slider_speed = $settings['slider_speed'];
        $slider_space_between = $settings['slider_spacebetween'];


?>
        <div class="bt-elwg-image-slider--default swiper" data-direction="<?php echo esc_attr($slider_direction) ?>" data-item="<?php echo esc_attr($slider_item_desktop) ?>" data-item-tablet="<?php echo !empty($slider_item_tablet) ? $slider_item_tablet : 2; ?>" data-item-mobile="<?php echo !empty($slider_item_mobile) ? $slider_item_mobile : 1; ?>" data-speed="<?php echo esc_attr($slider_speed) ?>" data-spacebetween="<?php echo esc_attr($slider_space_between) ?>">
            <ul class="bt-image-slider swiper-wrapper">
                <?php foreach ($settings['list'] as $index => $item) {
                    $image_position = $item['image_position'] ?? 'center';
                    $position_class = '';
                    if ($image_position === 'top') {
                        $position_class = 'image-top';
                    } elseif ($image_position === 'bottom') {
                        $position_class = 'image-bottom';
                    } else {
                        $position_class = 'image-center';
                    }
                    $attachment = wp_get_attachment_image_src($item['image_item']['id'], $settings['thumbnail_size']);
                    if (!empty($attachment)) {
                        $image = '<img src="' . esc_url($attachment[0]) . '" alt="">';
                    } else {
                        $image = '<img src="' . esc_url($item['image_item']['url']) . '" alt="">';
                    }
                ?>
                    <li class="bt-image--item swiper-slide">
                        <?php if (!empty($item['image_url'])) { ?>
                            <a class="bt-image--link" href="<?php echo esc_url($item['image_url']); ?>" target="_blank">
                                <?php echo '<div class="bt-cover-image ' . esc_attr($position_class) . '">' . $image . '</div>'; ?>
                            </a>
                        <?php } else { ?>
                            <?php echo '<div class="bt-cover-image">' . $image . '</div>'; ?>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
<?php
    }

    protected function content_template() {}
}
