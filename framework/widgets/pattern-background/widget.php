<?php
namespace BeDemoElementorWidgets\Widgets\PatternBackground;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_PatternBackground extends Widget_Base {

	public function get_name() {
		return 'bt-pattern-background';
	}

	public function get_title() {
		return __( 'Pattern Background', 'bedemo' );
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

		$this->add_responsive_control(
			'item_size',
			[
				'label' => __( 'Size', 'bedemo' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 100,
					'unit' => 'vw',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'&:root' => '--pattern-diameter: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_opacity',
			[
				'label' => __( 'Opacity', 'bedemo' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-bg-pattern-effect' => 'opacity: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_color',
				'label' => __( 'Overlay Color', 'bedemo' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .bt-bg-pattern-effect:before',
			]
		);

		$this->add_control(
			'pattern',
			[
				'label' => __( 'Pattern', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'pattern_size',
			[
				'label' => __( 'Size', 'bedemo' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bt-bg-pattern-effect' => 'background-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pattern_image', [
				'label' => __( 'Image Repeat', 'bedemo' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
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

		$attachment = wp_get_attachment_image_src( $settings['pattern_image']['id'], 'full' );

		?>
		<div class="bt-elwg-pattern-background">
			<?php
				if( !empty( $attachment ) ) {
					echo '<div class="bt-bg-pattern-effect" style="background-image: url(' . esc_url( $attachment[0] ) . ');"></div>';
				} else {
					echo '<div class="bt-bg-pattern-effect"></div>';
				}
			?>

		</div>
		<?php
	}

	protected function content_template() {

	}
}
