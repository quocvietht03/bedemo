<?php
namespace BeDemoElementorWidgets\Widgets\ContactInformation;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_ContactInformation extends Widget_Base {

	public function get_name() {
		return 'bt-contact-information';
	}

	public function get_title() {
		return __( 'Contact Infomation', 'bedemo' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'bedemo' ];
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'bedemo' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'bedemo' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => '',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'button_url',
			[
				'label' => esc_html__( 'Button Url', 'bedemo' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
					'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon', [
				'label' => esc_html__( 'Icon', 'bedemo' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
			]
		);

		$repeater->add_control(
			'url', [
				'label' => __( 'Url', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'socials',
			[
				'label' => __( 'Socials', 'bedemo' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'icon' =>Utils::get_placeholder_image_src(),
						'url' => '#facebook'
					],
					[
						'icon' =>Utils::get_placeholder_image_src(),
						'url' => '#youtube'
					],
					[
						'icon' =>Utils::get_placeholder_image_src(),
						'url' => '#tiktok'
					],
					[
						'icon' =>Utils::get_placeholder_image_src(),
						'url' => '#instagram'
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_box_section_controls() {
		$this->start_controls_section(
			'section_style_box',
			[
				'label' => esc_html__( 'Box', 'bedemo' ),
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
					'{{WRAPPER}} .bt-contact-information' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __( 'Border Radius', 'bedemo' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bt-contact-information' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
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
					'{{WRAPPER}} .bt-contact-information' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .bt-contact-information',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-contact-information' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-contact-information' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_content_section_controls() {

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-contact-information--head' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => __( 'Heading Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-contact-information--head',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Description Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-contact-information--desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => __( 'Description Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-contact-information--desc',
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab( 'style_normal',
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
					'{{WRAPPER}} .bt-contact-information--button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bt-contact-information--button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'style_hover',
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
					'{{WRAPPER}} .bt-contact-information--button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bt-contact-information--button:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Button Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-contact-information--button',
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_content_section_controls();
		$this->register_style_box_section_controls();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="bt-elwg-contact-information">
			<div class="bt-contact-information">
		    <?php
		      if(!empty($settings['heading'])) {
		        echo '<h3 class="bt-contact-information--head">' . $settings['heading'] . '</h3>';
		      }

		      if(!empty($settings['description'])) {
		        echo '<div class="bt-contact-information--desc">' . $settings['description'] . '</div>';
		      }

					if ( ! empty( $settings['button_url']['url'] ) ) {
						$this->add_link_attributes( 'button_url', $settings['button_url'] );
					}

		      if(!empty($settings['button_text'])) {
		        echo '<a class="bt-contact-information--button" ' . $this->get_render_attribute_string( 'button_url' ) . '>' . $settings['button_text'] . '</a>';
		      }

		      if(!empty($settings['socials'])) {
		      ?>
		        <div class="bt-contact-information--social">
		          <?php foreach ($settings['socials'] as $item) { ?>
                <a class="bt-social" href="<?php echo esc_url($item['url']); ?>" target="_blank">
                  <img src="<?php echo esc_url($item['icon']['url']) ?>" alt="" />
                </a>
              <?php } ?>
		        </div>
		      <?php
		      }
		    ?>
		  </div>
		</div>
		<?php
	}

	protected function content_template() {

	}
}
