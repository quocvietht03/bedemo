<?php
namespace BeDemoElementorWidgets\Widgets\BubleBackground;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_BubleBackground extends Widget_Base {

	public function get_name() {
		return 'bt-buble-background';
	}

	public function get_title() {
		return __( 'Buble Background', 'bedemo' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'bedemo' ];
	}

	protected function register_content_section_controls() {

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
			'background_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-bg-buble-effect' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'buble',
			[
				'label' => __( 'Buble', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'buble_color',
				'label' => __( 'Color', 'bedemo' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .bt-bg-buble-effect .buble',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'buble_box_shadow',
				'selector' => '{{WRAPPER}} .bt-bg-buble-effect .buble',
			]
		);

		$this->add_responsive_control(
			'buble_opacity',
			[
				'label' => __( 'Opacity', 'bedemo' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-bg-buble-effect .bt-bubles-beblow,
					{{WRAPPER}} .bt-bg-buble-effect .bt-bubles-above' => 'opacity: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_content_section_controls();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="bt-elwg-buble-background">
			<div class="bt-bg-buble-effect">
			  <div class="bt-bubles-beblow">
					<?php
						 for($i = 1; $i < 40; $i++) {
							 echo '<span class="buble"></span>';
						 }
					?>
			  </div>
			  <div class="bt-bubles-above">
					<?php
						 for($i = 1; $i < 40; $i++) {
							 echo '<span class="buble"></span>';
						 }
					?>
			  </div>
			</div>
		</div>
		<?php
	}

	protected function content_template() {

	}
}
