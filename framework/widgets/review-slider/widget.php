<?php

namespace BeDemoElementorWidgets\Widgets\ReviewSlider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ReviewSlider extends Widget_Base
{

    public function get_name()
    {
        return 'bt-review-slider';
    }

    public function get_title()
    {
        return __('Review Slider', 'bedemo');
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
            'name',
            [
                'label' => esc_html__('Name', 'bedemo'),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Name <span> - Job</span>', 'bedemo' ),
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'bedemo'),
                'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => __( 'This is a customer text review.', 'bedemo' ),
            ]
        );

        $repeater->add_control(
			'rating',
			[
				'label' => esc_html__( 'Rating', 'bedemo' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5,
				'step' => 1,
				'default' => 5,
			]
		);



        $this->add_control(
            'list',
            [
                'label' => __('List Review', 'bedemo'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'name' => 'Name <span> - Job</span>',
                        'text' => 'The theme is incredibly well-designed, modern, and fully responsive, which is exactly what I was looking for.',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Name <span> - Job</span>',
                        'text' => 'It’s rare to find such excellent customer service, which really sets this theme apart from others on ThemeForest.',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Name <span> - Job</span>',
                        'text' => 'This theme is very easy to customize everything, even for someone with little technical knowledge.',
                        'rating' => 5
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
        <div class="bt-elwg-review-slider--default swiper" data-direction="<?php echo esc_attr($slider_direction) ?>" data-speed="<?php echo esc_attr($slider_speed) ?>" data-spacebetween="<?php echo esc_attr($slider_space_between) ?>">
            <ul class="bt-review-slider swiper-wrapper">
                <?php foreach ($settings['list'] as $index => $item) {
                    
                ?>
                    <li class="bt-review--item swiper-slide">
                        <?php
                            if(!empty($item['name'])) {
                                echo '<h3 class="bt-review--name">' . $item['name'] . '</h3>';
                            }
                            if(!empty($item['rating'])) {
                                $stars = '';
                                for( $i = 1; $i <= 5; $i++ ) {
                                    if($i <= $item['rating']) {
                                        $stars .= '<span class="bt-filled"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                                        <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                                    </svg></span>';
                                    } else {
                                        $stars .= '<span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                                        <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                                    </svg></span>';
                                    }
                                }

                                echo '<div class="bt-review--rating">' . $stars . '</div>';
                            }
                            if(!empty($item['text'])) {
                                echo '<div class="bt-review--text">' . $item['text'] . '</div>';
                            }
                         
                        ?>
                        
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }

    protected function content_template() {}
}
