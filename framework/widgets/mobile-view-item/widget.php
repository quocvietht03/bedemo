<?php
namespace BeDemoElementorWidgets\Widgets\MobileViewItem;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_MobileViewItem extends Widget_Base {

	public function get_name() {
		return 'bt-demo-item';
	}

	public function get_title() {
		return __( 'Mobile View Item', 'bedemo' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'bedemo' ];
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'bedemo' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Video Poster', 'bedemo' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
            'video_type',
            [
                'label' => __('Video Type', 'bedemo'),
                'type' => Controls_Manager::SELECT,
                'default' => 'url',
                'options' => [
                    'url' => __('URL (Mp4)', 'bedemo'),
                    'file' => __('Media File', 'bedemo'),
                ],
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => __('Video URL', 'bedemo'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Enter video URL', 'bedemo'),
                'description' => __('Enter video URL (YouTube or Vimeo)', 'bedemo'),
                'condition' => [
                    'video_type' => ['url'],
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_file',
            [
                'label' => __('Choose Video File', 'bedemo'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'file',
                ],
            ]
        );

		$this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'bedemo'),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is heading', 'bedemo' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'label' => __( 'Image Size', 'bedemo' ),
				'show_label' => true,
				'default' => 'medium',
				'exclude' => [ 'custom' ],
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
					'{{WRAPPER}} .bt-demo-view--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-demo-view--title',
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_style_section_controls();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$attachment = wp_get_attachment_image_src($settings['image']['id'], $settings['thumbnail_size']);
		if (!empty($attachment)) {
			$image = '<img src="' . esc_url($attachment[0]) . '" alt="">';
		} else {
			$image = '<img src="' . esc_url($settings['image']['url']) . '" alt="">';
		}

		if ($settings['video_type'] === 'url') {
			$video_url = $settings['video_url'];
		} else {
			$video_url = $settings['video_file']['url'];
		}

		?>
			<div class="bt-elwg-demo-view-item--default">
				<div class="bt-demo-view--item">
					<div class="bt-demo-view--mobile-wrap">
						<img class="bt-mobile-view-bg" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mobile-view.png" alt="">
						<div class="bt-demo-view--video-wrap">
							<?php echo '<div class="bt-demo-view--poster">' . $image . '</div>'; ?>

							<div class="bt-demo-view--video">
								<video class="bt-video-cover" autoplay muted loop>
									<source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
								</video>
							</div>
						</div>
					</div>
					<?php 
						if(!empty($settings['title'])) {
							echo '<h3 class="bt-demo-view--title">' . $settings['title'] . '</h3>';
						}
					?>
				</div>
	    	</div>
		<?php
	}

	protected function content_template() {

	}
}
