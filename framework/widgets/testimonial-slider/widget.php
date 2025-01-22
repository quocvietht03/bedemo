<?php
namespace BeDemoElementorWidgets\Widgets\TestimonialSlider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_TestimonialSlider extends Widget_Base {

	public function get_name() {
		return 'bt-testimonial-slider';
	}

	public function get_title() {
		return __( 'Testimonial Slider', 'bedemo' );
	}

  public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'bedemo' ];
	}

	public function get_script_depends() {
		return [ 'slick-slider', 'elementor-widgets' ];
	}

	protected function get_supported_ids() {
		$supported_ids = [];

		$wp_query = new \WP_Query( array(
									'post_type' => 'testimonial',
									'post_status' => 'publish'
								) );

		if ( $wp_query->have_posts() ) {
	    while ( $wp_query->have_posts() ) {
        $wp_query->the_post();
        $supported_ids[get_the_ID()] = get_the_title();
	    }
		}

		return $supported_ids;
	}

	public function get_supported_taxonomies() {
		$supported_taxonomies = [];

		$categories = get_terms( array(
			'taxonomy' => 'testimonial_categories',
	    'hide_empty' => false,
		) );
		if( ! empty( $categories )  && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
			    $supported_taxonomies[$category->term_id] = $category->name;
			}
		}

		return $supported_taxonomies;
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'bedemo' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'bedemo' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);

		$this->end_controls_section();
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'bedemo' ),
			]
		);

		$this->start_controls_tabs( 'tabs_query' );

		$this->start_controls_tab(
			'tab_query_include',
			[
				'label' => __( 'Include', 'bedemo' ),
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __( 'Ids', 'bedemo' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'bedemo' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_query_exnlude',
			[
				'label' => __( 'Exclude', 'bedemo' ),
			]
		);

		$this->add_control(
			'ids_exclude',
			[
				'label' => __( 'Ids', 'bedemo' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category_exclude',
			[
				'label' => __( 'Category', 'bedemo' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'bedemo' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'bedemo' ),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'bedemo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'bedemo' ),
					'post_title' => __( 'Title', 'bedemo' ),
					'menu_order' => __( 'Menu Order', 'bedemo' ),
					'rand' => __( 'Random', 'bedemo' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'bedemo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'bedemo' ),
					'desc' => __( 'DESC', 'bedemo' ),
				],
			]
		);

		$this->end_controls_section();
	}


	protected function register_style_section_controls() {
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
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--inner' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_icon_style',
			[
				'label' => __( 'Quote Icon', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'quote_icon_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--quote-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quote_icon_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--quote-icon' => 'background-color: {{VALUE}};',
				],
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
					'{{WRAPPER}} .bt-testimonial-slider--nav .bt-post--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_current',
			[
				'label' => __( 'Color Current', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-current .bt-post--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-testimonial-slider--nav .bt-post--title',
			]
		);

		$this->add_control(
			'job_style',
			[
				'label' => __( 'Job', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'job_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .bt-post--job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'job_color_current',
			[
				'label' => __( 'Color Current', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-current .bt-post--job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'job_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-testimonial-slider--nav .bt-post--job',
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
					'{{WRAPPER}} .bt-testimonial-slider--for .bt-post--desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-testimonial-slider--for .bt-post--desc',
			]
		);

		$this->add_control(
			'info_style',
			[
				'label' => __( 'Info Background', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'info_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_bg_color_hover',
			[
				'label' => __( 'Background Color Hover', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-current .bt-post--inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_arrows',
			[
				'label' => esc_html__( 'Arrows', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'arrows_effects_tabs' );

		$this->start_controls_tab( 'arrows_tab_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'arrows_tab_hover',
			[
				'label' => __( 'Hover', 'bedemo' ),
			]
		);

		$this->add_control(
			'arrows_color_hover',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_bg_color_hover',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-testimonial-slider--nav .slick-arrow:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_controls() {

		$this->register_layout_section_controls();
		$this->register_query_section_controls();

		$this->register_style_section_controls();

	}

	public function query_posts() {
		$settings = $this->get_settings_for_display();

		$args = [
			'post_type' => 'testimonial',
			'post_status' => 'publish',
			'posts_per_page' => $settings['posts_per_page'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		if( ! empty( $settings['ids'] ) ) {
			$args['post__in'] = $settings['ids'];
		}

		if( ! empty( $settings['ids_exclude'] ) ) {
			$args['post__not_in'] = $settings['ids_exclude'];
		}

		if( ! empty( $settings['category'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'testimonial_categories',
					'terms' 		=> $settings['category'],
					'field' 		=> 'term_id',
					'operator' 		=> 'IN'
				)
			);
		}

		if( ! empty( $settings['category_exclude'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'testimonial_categories',
					'terms' 		=> $settings['category_exclude'],
					'field' 		=> 'term_id',
					'operator' 		=> 'NOT IN'
				)
			);
		}

		if( 0 !== absint( $settings['offset'] ) ) {
			$args['offset'] = $settings['offset'];
		}

		return $query = new \WP_Query( $args );
	}

	protected function render() {
    $settings = $this->get_settings_for_display();
		$query = $this->query_posts();

    ?>
      <div class="bt-elwg-testimonial-slider--default">
        <?php
          if( $query->have_posts() ) {
            ?>
              <div class="bt-testimonial-slider">
								<div class="bt-testimonial-slider--for bt-slide-for-js">
									<?php while ( $query->have_posts() ) : $query->the_post(); ?>
										<article <?php post_class('bt-post'); ?>>
										  <div class="bt-post--quote-icon">
										    <svg width="31" height="21" viewBox="0 0 31 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										      <path d="M16.4691 13.981C16.4691 6.04241 19.7795 0.776007 19.9208 0.55537L20.2755 0H25.5787L25.1417 1.49712C24.7144 2.95852 24.0372 5.59889 24.0372 6.46325C24.0372 6.67462 24.0438 6.82874 24.0523 6.9403C25.9263 7.02384 27.6947 7.80248 28.9889 9.1141C30.2832 10.4257 31.0036 12.1691 31 13.981C31 15.8421 30.2345 17.6268 28.872 18.9428C27.5095 20.2588 25.6615 20.9983 23.7345 20.9983C21.8076 20.9983 19.9597 20.2588 18.5971 18.9428C17.2346 17.6268 16.4691 15.8421 16.4691 13.981ZM18.8908 13.981C18.895 14.9015 19.1802 15.8002 19.7107 16.5649C20.2413 17.3295 20.9936 17.9259 21.8734 18.2795C22.7533 18.6332 23.7216 18.7285 24.6572 18.5531C25.5927 18.3778 26.4539 17.9398 27.133 17.2939C27.8121 16.6481 28.2788 15.8232 28.4747 14.9224C28.6707 14.0216 28.5872 13.085 28.2346 12.2298C27.8821 11.3747 27.2762 10.639 26.4928 10.1148C25.7094 9.59069 24.7833 9.30134 23.8305 9.28309H23.7774C23.4077 9.30547 23.0391 9.22503 22.7153 9.05144C22.3914 8.87786 22.1258 8.61838 21.9498 8.30358C21.6826 7.72613 21.5676 7.09374 21.6151 6.4629C21.6151 5.52582 22.0506 3.67816 22.3986 2.35149H21.6631C19.8251 5.97044 18.8764 9.95016 18.8908 13.981ZM0 13.981C0 6.04241 3.31073 0.776007 3.45171 0.55537L3.80709 0H9.1103L8.67336 1.49712C8.246 2.95852 7.56878 5.59889 7.56878 6.46325C7.56878 6.67462 7.57506 6.82874 7.58392 6.9403C9.45811 7.02403 11.2266 7.80291 12.5209 9.11479C13.8152 10.4267 14.5354 12.1703 14.5316 13.9824C14.5316 15.8436 13.7661 17.6285 12.4035 18.9446C11.0409 20.2606 9.19281 21 7.2658 21C5.33879 21 3.49071 20.2606 2.1281 18.9446C0.765502 17.6285 0 15.8436 0 13.9824V13.981ZM2.42169 13.981C2.4258 14.9016 2.71098 15.8005 3.24153 16.5652C3.77209 17.33 4.52443 17.9265 5.40437 18.2802C6.28431 18.634 7.25275 18.7292 8.18842 18.5538C9.12409 18.3785 9.9854 17.9403 10.6645 17.2945C11.3437 16.6486 11.8104 15.8237 12.0064 14.9228C12.2023 14.0219 12.1188 13.085 11.7662 12.2298C11.4136 11.3746 10.8076 10.6388 10.024 10.1147C9.24053 9.5905 8.31433 9.30127 7.3614 9.28309H7.30862C6.93894 9.30555 6.57032 9.22521 6.24644 9.05162C5.92255 8.87802 5.65696 8.61844 5.48109 8.30358C5.21362 7.72621 5.09862 7.09375 5.14637 6.4629C5.14637 5.52582 5.58185 3.67816 5.92949 2.35149H5.19545C3.35695 5.97032 2.40775 9.95004 2.42169 13.981Z"/>
										    </svg>
										  </div>

										  <div class="bt-post--inner">
										    <?php
												$desc = get_field('description');
										     if(!empty($desc)) {
										       echo '<div class="bt-post--desc">' . $desc . '</div>';
										     }
										    ?>
										  </div>
										</article>
	                <?php endwhile; ?>
								</div>
								<div class="bt-testimonial-slider--nav bt-slide-nav-js">
									<?php while ( $query->have_posts() ) : $query->the_post(); ?>
										<article <?php post_class('bt-post'); ?>>
										  <div class="bt-post--inner">
										    <div class="bt-post--infor">
										      <div class="bt-post--avatar">
										        <?php
															$avatar = get_field('avatar');
											        if(!empty($avatar)) {
											        	echo '<img src="' . esc_url($avatar['url']) . '" alt="' . esc_attr($avatar['title']) . '" />';
											        }
										        ?>
										      </div>
										      <div class="bt-post--title-wrap">
										        <h3 class="bt-post--title">
										          <?php the_title(); ?>
										        </h3>
										        <?php
															$job = get_field('job');
										          if(!empty($job)) {
										            echo '<div class="bt-post--job">' . $job . '</div>';
										          }
										        ?>
										      </div>
										    </div>
										  </div>
										</article>
	                <?php endwhile; ?>
								</div>

              </div>
            <?php
          } else {
            get_template_part( 'framework/templates/post', 'none');
          }
        ?>
      </div>
    <?php
		wp_reset_postdata();
	}

	protected function content_template() {

	}

}
