<?php
namespace BeDemoElementorWidgets\Widgets\PricingTabs;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Widget_PricingTabs extends Widget_Base {

	public function get_name() {
		return 'bt-pricing-tabs';
	}

	public function get_title() {
		return __( 'Pricing Tabs', 'bedemo' );
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

	protected function get_supported_ids() {
		$supported_ids = [];

		$wp_query = new \WP_Query( array(
									'post_type' => 'pricing',
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
			'taxonomy' => 'pricing_categories',
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
				'default' => 3,
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
					'{{WRAPPER}} .bt-pricing-tabs' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .bt-pricing-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bt-pricing-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .bt-pricing-tabs',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-pricing-tabs' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-pricing-tabs' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_nav',
			[
				'label' => esc_html__( 'Navigation', 'bedemo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-pricing-tabs--nav' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_number_style',
			[
				'label' => __( 'Number', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_number_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-nav-item--count',
			]
		);

		$this->start_controls_tabs( 'nav_number_effects_tabs' );

		$this->start_controls_tab( 'nav_number_tab_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

		$this->add_control(
			'nav_number_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item--count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_number_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item--count' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_number_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item--count' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'nav_number_tab_active',
			[
				'label' => __( 'Active', 'bedemo' ),
			]
		);

		$this->add_control(
			'nav_number_color_active',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item.bt-is-active .bt-nav-item--count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_number_bg_color_active',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item.bt-is-active .bt-nav-item--count' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_number_border_color_active',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item.bt-is-active .bt-nav-item--count' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'nav_title_style',
			[
				'label' => __( 'Title', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-nav-item--title',
			]
		);

		$this->start_controls_tabs( 'nav_title_effects_tabs' );

		$this->start_controls_tab( 'nav_title_tab_normal',
			[
				'label' => __( 'Normal', 'bedemo' ),
			]
		);

		$this->add_control(
			'nav_title_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_title_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item:not(.bt-is-active)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'nav_title_tab_active',
			[
				'label' => __( 'Active', 'bedemo' ),
			]
		);

		$this->add_control(
			'nav_title_color_active',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item.bt-is-active .bt-nav-item--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_title_bg_color_active',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-nav-item.bt-is-active' => 'background-color: {{VALUE}};',
				],
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
					'{{WRAPPER}} .bt-panel-item--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-panel-item--title',
			]
		);

		$this->add_control(
			'price_style',
			[
				'label' => __( 'Price', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-panel-item--price',
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
					'{{WRAPPER}} .bt-panel-item--desc,
					{{WRAPPER}} .bt-panel-item--list' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-panel-item--desc,
											{{WRAPPER}} .bt-panel-item--list',
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
				'selector' => '{{WRAPPER}} .bt-panel-item--choose',
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
					'{{WRAPPER}} .bt-panel-item--choose' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .bt-panel-item--choose' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bt-panel-item--choose' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .bt-panel-item--choose' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bt-panel-item--choose' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--choose' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bt-panel-item--choose',
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
					'{{WRAPPER}} .bt-panel-item--choose:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bt-panel-item--choose:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label' => __( 'Border Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--choose:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .bt-panel-item--choose:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'link_style',
			[
				'label' => __( 'Link', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--more' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label' => __( 'Color Hover', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--more:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-panel-item--more',
			]
		);

		$this->add_control(
			'featured_style',
			[
				'label' => __( 'Featured', 'bedemo' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'featured_color',
			[
				'label' => __( 'Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--featured' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'featured_bg_color',
			[
				'label' => __( 'Background Color', 'bedemo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bt-panel-item--featured' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .bt-panel-item--featured:before' => 'border-color: {{VALUE}} transparent transparent {{VALUE}};',
					'{{WRAPPER}} .bt-panel-item--featured:after' => 'border-color: transparent transparent {{VALUE}} {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'featured_typography',
				'label' => __( 'Typography', 'bedemo' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .bt-panel-item--featured',
			]
		);

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
			'post_type' => 'pricing',
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
					'taxonomy' 		=> 'pricing_categories',
					'terms' 		=> $settings['category'],
					'field' 		=> 'term_id',
					'operator' 		=> 'IN'
				)
			);
		}

		if( ! empty( $settings['category_exclude'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'pricing_categories',
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
      <div class="bt-elwg-pricing-tabs--default">
        <?php
          if( $query->have_posts() ) {
						$counter = 0;
            ?>
              <div class="bt-pricing-tabs">
								<div class="bt-bg-pattern-effect"></div>
								<div class="bt-pricing-tabs--nav">
									<?php while ( $query->have_posts() ) : $query->the_post(); $counter++; ?>
										<a class="bt-nav-item<?php if($counter == 1) echo ' bt-is-active' ?>" href="<?php echo '#tab_' . get_the_ID(); ?>">
											<?php echo '<span class="bt-nav-item--count">0' . $counter . '</span>'; ?>
											<h3 class="bt-nav-item--title">
												<?php the_title(); ?>
											</h3>
										</a>
									<?php endwhile; ?>
								</div>

								<div class="bt-pricing-tabs--panels">
									<?php $counter = 0; while ( $query->have_posts() ) : $query->the_post(); $counter++;
												$featured = get_field('featured');
												$featured_text = get_field('featured_text') ? get_field('featured_text') : __( 'Featured', 'bedemo' );
												$price = get_field('price');
												$unit = get_field('unit');
												$desc = get_field('description');
												$features = get_field('features');
												$choose_btn = get_field('choose_button');
												$more_link = get_field('more_link');
											?>
										<div id="<?php echo 'tab_' . get_the_ID(); ?>" class="bt-panel-item<?php if($counter == 1) echo ' bt-is-active' ?>">
											<?php
												if($featured) {
													echo '<div class="bt-panel-item--featured">' . $featured_text . '</div>';
												}
											?>
											<div class="bt-panel-item--inner">
												<div class="bt-panel-item--left">
													<h3 class="bt-panel-item--title">
														<?php the_title(); ?>
													</h3>
													<?php if(!empty($price) || !empty($unit)) { ?>
														<div class="bt-panel-item--price">
															<?php
																if(!empty($price)) {
																	echo '<span>' . $price . '</span>';
																}
																if(!empty($unit)) {
																	echo '/' . $unit;
																}
															?>
														</div>
													<?php } ?>

													<?php if(!empty($choose_btn) || !empty($more_link)) { ?>
														<div class="bt-panel-item--actions">
															<?php
																if(!empty($choose_btn)) {
																	echo '<a class="bt-panel-item--choose" href="' . esc_url($choose_btn['url']) . '" target="' . esc_attr($choose_btn['target']) . '">' . $choose_btn['title'] . '</a>';
																}
																if(!empty($more_link)) {
																	echo '<a class="bt-panel-item--more" href="' . esc_url($more_link['url']) . '" target="' . esc_attr($more_link['target']) . '">' . $more_link['title'] . '</a>';
																}
															?>
														</div>
													<?php } ?>
												</div>
												<div class="bt-panel-item--right">
													<?php
														if(!empty($desc)) {
															echo '<div class="bt-panel-item--desc">' . $desc . '</div>';
														}
													?>

													<?php if(!empty($features)) { ?>
														<ul class="bt-panel-item--list">
															<?php
																foreach ($features as $item) {
																	echo '<li>' . $item['text'] . '</li>';
																}
															?>
														</ul>
													<?php } ?>
												</div>
											</div>
										</div>
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
