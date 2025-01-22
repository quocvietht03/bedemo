<?php
namespace BeDemoElementorWidgets\Widgets\SiteSocial;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Widget_SiteSocial extends Widget_Base {

	public function get_name() {
		return 'bt-site-social';
	}

	public function get_title() {
		return __( 'Site Social', 'bedemo' );
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
			'title',
			[
				'label' => esc_html__( 'Title', 'bedemo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'bedemo' ),
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'bedemo' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'bedemo' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bedemo' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'bedemo' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .bt-elwg-site-social' => 'justify-content: {{VALUE}};',
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
			'title_color',
			[
				'label' => __( 'Title Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-elwg-site-social span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-elwg-site-social span',
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_layout_section_controls();
		$this->register_style_content_section_controls();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if(function_exists('get_field')){
			$site_infor = get_field('site_information', 'options');
		} else {
			return;
		}

		if(empty($site_infor['site_socials'])) {
			return;
		}

		?>
			<div class="bt-elwg-site-social">
				<?php
					if(!empty($settings['title'])) {
						echo '<span class="bt-title">' . $settings['title'] . '</span>';
					}

					foreach ($site_infor['site_socials'] as $item) {
						if($item['social'] == 'facebook') {
							echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
											<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
												<path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
											</svg>
										</a>';
						}

						if($item['social'] == 'linkedin') {
							echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
											<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
												<path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
											</svg>
										</a>';
						}

						if($item['social'] == 'twitter') {
							echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
											<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
												<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
											</svg>
										</a>';
						}

						if($item['social'] == 'google') {
							echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
											<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
												<path d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"/>
											</svg>
										</a>';
						}
					}
				?>
			</div>
		<?php
	}

	protected function content_template() {

	}
}
