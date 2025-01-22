<?php

namespace BeDemoElementorWidgets\Widgets\TextSlider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_TextSlider extends Widget_Base
{

    public function get_name()
    {
        return 'bt-text-slider';
    }

    public function get_title()
    {
        return __('Text Slider', 'bedemo');
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
            'text_item',
            [
                'label' => esc_html__('Text Item', 'bedemo'),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is text', 'bedemo' ),
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
                        'text_item' => __('Lifetime Updated', 'bedemo'),
                    ],
                    [
                        'text_item' => __('Free Support', 'bedemo'),
                    ],
                    [
                        'text_item' => __('Premium Plugins', 'bedemo'),
                    ],
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
        
        $slider_speed = $settings['slider_speed'];
        $slider_space_between = $settings['slider_spacebetween'];
        ?>
        <div class="bt-elwg-text-slider--default swiper" data-direction="<?php echo esc_attr($slider_direction) ?>" data-speed="<?php echo esc_attr($slider_speed) ?>" data-spacebetween="<?php echo esc_attr($slider_space_between) ?>">
            <ul class="bt-text-slider swiper-wrapper">
                <?php foreach ($settings['list'] as $index => $item) { ?>
                    <li class="bt-text--item swiper-slide">
                        <?php echo '<span>' . $item['text_item'] . '</span>'; ?>
                <?php } ?>
            </ul>
        </div>
    <?php
    }

    protected function content_template() {}
}
