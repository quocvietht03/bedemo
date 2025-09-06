<?php

namespace BeDemoElementorWidgets\Widgets\FeaturesSliderVertical;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_FeaturesSliderVertical extends Widget_Base
{

    public function get_name()
    {
        return 'bt-features-slider-vertical';
    }

    public function get_title()
    {
        return __('Features Slider Vertical', 'bedemo');
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
            'features_item',
            [
                'label' => __('Features', 'bedemo'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'features_title',
            [
                'label' => __('Features Title', 'bedemo'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'features_description',
            [
                'label' => __('Features Description', 'bedemo'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'features_url',
            [
                'label' => esc_html__('Features Url', 'bedemo'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
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
                        'features_item' => Utils::get_placeholder_image_src(),
                        'features_url' => '#'
                    ],
                    [
                        'features_item' => Utils::get_placeholder_image_src(),
                        'features_url' => '#'
                    ],
                    [
                        'features_item' => Utils::get_placeholder_image_src(),
                        'features_url' => '#'
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'label' => __('Features Size', 'bedemo'),
                'show_label' => true,
                'default' => 'medium_large',
                'exclude' => ['custom'],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'features_border',
                'label' => __('Border', 'bedemo'),
                'selector' => '{{WRAPPER}} .bt-features--item img',
            ]
        );

        $this->add_responsive_control(
            'features_border_radius',
            [
                'label' => __('Border Radius', 'bedemo'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .bt-features--item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->end_controls_section();
    }
    protected function register_style_content_section_controls()
    {
        $this->start_controls_section(
            'section_style_box',
            [
                'label' => esc_html__('Box Settings', 'bedemo'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => __('Background Color', 'bedemo'),
                'type' => Controls_Manager::COLOR,
                'default' => '#F7F7F7',
                'selectors' => [
                    '{{WRAPPER}} .bt-features--item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Padding', 'bedemo'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .bt-features--item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'bedemo'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .bt-features--item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __('Border', 'bedemo'),
                'selector' => '{{WRAPPER}} .bt-features--item',
            ]
        );
        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__('Alignment', 'bedemo'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'bedemo'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'bedemo'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'bedemo'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .bt-features--item' => 'justify-content: {{VALUE}};text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => esc_html__('Heading', 'bedemo'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label' => __('Color', 'bedemo'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .bt-features--title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => __('Typography', 'bedemo'),
                'default'  => '',
                'selector' => '{{WRAPPER}} .bt-features--title',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'bedemo'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'bedemo'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .bt-features--description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => __('Description Typography', 'bedemo'),
                'default'  => '',
                'selector' => '{{WRAPPER}} .bt-features--description',
            ]
        );
        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->register_layout_section_controls();
        $this->register_style_content_section_controls();
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
        $slider_item_desktop = $settings['slider_item']['size'] ?? $settings['slider_item'];
        $slider_item_tablet = $settings['slider_item_tablet'] ?? 2;
        $slider_item_mobile = $settings['slider_item_mobile'] ?? 1;
        $slider_speed = $settings['slider_speed'];
        $slider_space_between = $settings['slider_spacebetween'];
?>
        <div class="bt-elwg-features-slider-vertical--default swiper" data-autoplay="<?php echo esc_attr($autoplay) ?>" data-direction="<?php echo esc_attr($slider_direction) ?>" data-item="<?php echo esc_attr($slider_item_desktop) ?>" data-item-tablet="<?php echo !empty($slider_item_tablet) ? $slider_item_tablet : 2; ?>" data-item-mobile="<?php echo !empty($slider_item_mobile) ? $slider_item_mobile : 1; ?>" data-speed="<?php echo esc_attr($slider_speed) ?>" data-spacebetween="<?php echo esc_attr($slider_space_between) ?>">
            <ul class="bt-features-slider swiper-wrapper">
                <?php foreach ($settings['list'] as $index => $item) {
                    $image = wp_get_attachment_image($item['features_item']['id'], $settings['thumbnail_size']);
                    ?>
                    <li class="bt-features--item swiper-slide">
                        <?php if (!empty($item['features_url'])) { ?>
                            <a class="bt-features--link" href="<?php echo esc_url($item['features_url']); ?>" target="_blank">
                                <div class="bt-features--title"><?php echo esc_html($item['features_title']); ?></div>
                                <div class="bt-features--description"><?php echo esc_html($item['features_description']); ?></div>
                                <?php echo '<div class="bt-cover-image">' . $image . '</div>'; ?>
                            </a>
                        <?php } else { ?>
                            <div class="bt-features--title"><?php echo esc_html($item['features_title']); ?></div>
                            <div class="bt-features--description"><?php echo esc_html($item['features_description']); ?></div>
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
