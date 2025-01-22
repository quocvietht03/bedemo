<?php
namespace BeDemoElementorWidgets\Widgets\StepList;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_StepList extends Widget_Base {

	public function get_name() {
		return 'bt-step-list';
	}

	public function get_title() {
		return __( 'Step List', 'bedemo' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'bedemo' ];
	}

	public function get_script_depends() {
		return [ 'elementor-widgets' ];
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'bedemo' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'step_image', [
				'label' => __( 'Image', 'bedemo' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'step_subtitle', [
				'label' => __( 'Sub Title', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$repeater->add_control(
			'step_title', [
				'label' => __( 'Title', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$repeater->add_control(
			'step_desc', [
				'label' => __( 'Description', 'bedemo' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => '',
			]
		);

		$repeater->add_control(
			'step_btn_text', [
				'label' => __( 'Button Text', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$repeater->add_control(
			'step_btn_link', [
				'label' => __( 'Button Link', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'List Step', 'bedemo' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'step_image' => Utils::get_placeholder_image_src(),
						'step_subtitle' => __( 'Sub title', 'bedemo' ),
						'step_title' => __( 'This is step title 01', 'bedemo' ),
						'step_desc' => __( 'This is description', 'bedemo' ),
						'step_btn_text' => __( 'Read More', 'bedemo' ),
						'step_btn_link' => '#'
					],
					[
						'step_image' => Utils::get_placeholder_image_src(),
						'step_subtitle' => __( 'Sub title', 'bedemo' ),
						'step_title' => __( 'This is step title 02', 'bedemo' ),
						'step_desc' => __( 'This is description', 'bedemo' ),
						'step_btn_text' => __( 'Read More', 'bedemo' ),
						'step_btn_link' => '#'
					],
					[
						'step_image' => Utils::get_placeholder_image_src(),
						'step_subtitle' => __( 'Sub title', 'bedemo' ),
						'step_title' => __( 'This is step title 03', 'bedemo' ),
						'step_desc' => __( 'This is description', 'bedemo' ),
						'step_btn_text' => __( 'Read More', 'bedemo' ),
						'step_btn_link' => '#'
					],
					[
						'step_image' => Utils::get_placeholder_image_src(),
						'step_subtitle' => __( 'Sub title', 'bedemo' ),
						'step_title' => __( 'This is step title 04', 'bedemo' ),
						'step_desc' => __( 'This is description', 'bedemo' ),
						'step_btn_text' => __( 'Read More', 'bedemo' ),
						'step_btn_link' => '#'
					],
					[
						'step_image' => Utils::get_placeholder_image_src(),
						'step_subtitle' => __( 'Sub title', 'bedemo' ),
						'step_title' => __( 'This is step title 05', 'bedemo' ),
						'step_desc' => __( 'This is description', 'bedemo' ),
						'step_btn_text' => __( 'Read More', 'bedemo' ),
						'step_btn_link' => '#'
					],
				],
				'title_field' => '{{{ step_title }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'label' => __( 'Image Size', 'bedemo' ),
				'show_label' => true,
				'default' => 'medium_large',
				'exclude' => [ 'custom' ],
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label' => __( 'Image Ratio', 'bedemo' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.58,
				],
				'range' => [
					'px' => [
						'min' => 0.3,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--image .bt-cover-image' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				],
			]
		);

		$this->add_control(
			'show_more_button',
			[
				'label' => __( 'Show More Button', 'bedemo' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'bedemo' ),
				'label_off' => __( 'Hide', 'bedemo' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_more_button_text',
			[
				'label' => __( 'Show More Text', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'show_label' => true,
				'default' => __( 'More Steps', 'bedemo' ),
				'condition' => [
					'show_more_button!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_section_controls() {

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_border_width',
			[
				'label' => __( 'Border Width', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--image .bt-cover-image' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--image .bt-cover-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .bt-step-item--image .bt-cover-image',
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--image .bt-cover-image' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'thumbnail_tab_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .bt-step-item--image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'thumbnail_tab_hover',
			[
				'label' => __( 'Hover', 'bedemo' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .bt-step-item:hover .bt-step-item--image img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtitle_style',
			[
				'label' => __( 'Sub Title', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-step-item--subtitle',
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
					'{{WRAPPER}} .bt-step-item--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-step-item--title',
			]
		);

		$this->add_control(
			'desc_style',
			[
				'label' => __( 'Description', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-step-item--desc',
			]
		);

		$this->add_control(
			'button_style',
			[
				'label' => __( 'Button', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-step-item--button',
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

    $this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

    $this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bt-step-item--button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'bedemo' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label' => __( 'Text Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-step-item--button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .bt-step-item--button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_show_more_btn',
			[
				'label' => esc_html__( 'Show More Button', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_more_button!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'show_more_btn_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-step-show-more--button',
			]
		);

		$this->add_control(
			'show_more_btn_border_width',
			[
				'label' => __( 'Border Width', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'show_more_btn_border_radius',
			[
				'label' => __( 'Border Radius', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'show_more_btn_padding',
			[
				'label' => __( 'Padding', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

    $this->start_controls_tabs( 'tabs_show_more_btn_style' );

		$this->start_controls_tab(
			'tab_show_more_btn_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

    $this->add_control(
			'show_more_btn_text_color',
			[
				'label' => __( 'Text Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_icon_color',
			[
				'label' => __( 'Icon Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'show_more_btn_box_shadow',
				'selector' => '{{WRAPPER}} .bt-step-show-more--button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_show_more_btn_hover',
			[
				'label' => __( 'Hover', 'bedemo' ),
			]
		);

		$this->add_control(
			'show_more_btn_text_color_hover',
			[
				'label' => __( 'Text Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_icon_color_hover',
			[
				'label' => __( 'Icon Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_bg_color_hover',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_more_btn_border_color_hover',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-step-show-more--button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'show_more_btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .bt-step-show-more--button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_style_section_controls();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['list'] ) ) {
			return;
		}
		?>
			<div class="bt-elwg-step-list--default <?php if(count($settings['list']) > 4 && $settings['show_more_button'] === 'yes') echo 'bt-has-show-more'; ?>">
				<div class="bt-step-list bt-step-list-js">
					<span class="bt-line-progress bt-line-progress-js"></span>
					<?php foreach ( $settings['list'] as $index => $item ) { $number = $index + 1; ?>
						<div class="bt-step-item <?php if($number > 4 && $settings['show_more_button'] === 'yes') echo 'bt-hide-item'; ?>">
							<div class="bt-step-item--left">
								<div class="bt-step-item--image">
									<div class="bt-cover-image">
										<?php
											$attachment = wp_get_attachment_image_src( $item['step_image']['id'], $settings['thumbnail_size'] );
											if( !empty( $attachment ) ) {
												echo '<img src=" ' . esc_url( $attachment[0] ) . ' " alt="">';
											} else {
												echo '<img src=" ' . esc_url( $item['step_image']['url'] ) . ' " alt="">';
											}
										?>
									</div>
								</div>
							</div>
							<div class="bt-step-item--right">
								<div class="bt-step-item--infor">
									<div class="bt-step-item--number">
										<svg width="101" height="94" viewBox="0 0 101 94" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M97.1536 32.4054C107.733 59.3372 95.4894 89.1091 72.6331 93.3805C49.9639 97.2874 21.1967 82.161 6.33199 63.5936C-8.37288 44.7144 3.7421 15.1965 30.2067 3.87891C36.4513 1.28686 43.1403 -0.0311592 49.8896 0.000559151C56.6388 0.0322775 63.3155 1.41303 69.536 4.06366C75.7566 6.71428 81.3985 10.5825 86.138 15.4462C90.8774 20.3099 94.6209 26.0733 97.1536 32.4054Z"/>
										</svg>
										<?php
											if($number < 10) {
												echo '<span>0' . $number . '</span>';
											} else {
												echo '<span>' . $number . '</span>';
											}
										?>
									</div>
									<?php
										if(!empty($item['step_subtitle'])) {
											echo '<h5 class="bt-step-item--subtitle">' . $item['step_subtitle'] . '</h5>';
										}

										if(!empty($item['step_title'])) {
											echo '<h3 class="bt-step-item--title">' . $item['step_title'] . '</h3>';
										}

										if(!empty($item['step_desc'])) {
											echo '<div class="bt-step-item--desc">' . $item['step_desc'] . '</div>';
										}

										if(!empty($item['step_btn_text'])) {
											echo '<a class="bt-step-item--button" href="' . esc_url($item['step_btn_link']) . '" target="_blank">' . $item['step_btn_text'] . '</a>';
										}
									?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<?php if(count($settings['list']) > 4 && $settings['show_more_button'] === 'yes' && !empty($settings['show_more_button_text'])) { ?>
					<div class="bt-step-show-more">
						<a class="bt-step-show-more--button bt-show-more-btn-js" href="#">
							<?php echo '<span>' . $settings['show_more_button_text'] . '</span>'; ?>
							<svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C8.268 30 2 23.73 2 16C2 8.27 8.268 2 16 2C23.732 2 30 8.27 30 16C30 23.73 23.732 30 16 30ZM16 0C7.163 0 0 7.16 0 16C0 24.84 7.163 32 16 32C24.837 32 32 24.84 32 16C32 7.16 24.837 0 16 0ZM21.121 15.46L17 19.59V9C17 8.45 16.553 8 16 8C15.448 8 15 8.45 15 9V19.59L10.879 15.46C10.488 15.07 9.855 15.07 9.465 15.46C9.074 15.86 9.074 16.49 9.465 16.88L15.121 22.54C15.361 22.78 15.689 22.85 16 22.79C16.311 22.85 16.639 22.78 16.879 22.54L22.535 16.88C22.926 16.49 22.926 15.86 22.535 15.46C22.146 15.07 21.512 15.07 21.121 15.46Z"/>
							</svg>
						</a>
					</div>
				<?php } ?>
	    </div>
		<?php
	}

	protected function content_template() {

	}
}
