<?php
/*
 * Single Service
 */

get_header();
get_template_part( 'framework/templates/site', 'titlebar');

$icon = get_field('icon');
$book_link = get_field('book_link');

?>
<main id="bt_main" class="bt-site-main">
	<div class="bt-main-content-ss">
    <div class="bt-container">
	    <?php while ( have_posts() ) : the_post(); ?>
	      <article <?php post_class('bt-post'); ?>>
	        <div class="bt-post--thumbnail">
	          <div class="bt-cover-image">
	            <?php
	              if (has_post_thumbnail()){
	                the_post_thumbnail('full');
	              }
	            ?>
	          </div>
	        </div>

	        <div class="bt-post--infor">
	          <?php if(!empty($icon)) { ?>
	            <div class="bt-post--icon">
	              <svg width="122" height="113" viewBox="0 0 122 113" fill="none" xmlns="http://www.w3.org/2000/svg">
	                <path d="M117.339 38.6685C130.117 70.8055 115.329 106.332 87.7236 111.429C60.3446 116.091 25.6005 98.0406 7.64754 75.8846C-10.1125 53.3566 4.51962 18.1336 36.4826 4.6286C44.0246 1.53558 52.1033 -0.0371815 60.2548 0.00066722C68.4064 0.0385159 76.4701 1.68613 83.9831 4.84906C91.4961 8.01198 98.3103 12.6278 104.034 18.4316C109.758 24.2353 114.28 31.1126 117.339 38.6685Z" fill="#F5F5F5"/>
	              </svg>
	              <img class="bt-ab-center" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['title']); ?>" />
	            </div>
	          <?php } ?>

	          <div class="bt-post--inner">
	            <?php the_terms( get_the_ID(), 'service_categories', '<div class="bt-post--cat">', ', ', '</div>' ); ?>
							<div class="bt-post--title-wrap">
		            <h3 class="bt-post--title">
		              <?php the_title(); ?>
		            </h3>
								<?php
									$avg_rating = bedemo_comment_rating_get_average_ratings(get_the_ID());
									$res_rating = round($avg_rating * 2) / 2;

									?>
									<div class="bt-post--avg-rating">
										<?php
										for($i = 1; $i <= 5; $i++) {
											if($i <= floor($res_rating))  {
												?>
													<span class="bt-filled">
														<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
															<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
														</svg>
													</span>
												<?php
											} else {
												if($i == round($res_rating) && $res_rating - (int)$res_rating > 0)  {
													?>
														<span class="bt-filled-half">
															<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
																<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
															</svg>
															<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
																<path d="M288 0c-12.2 .1-23.3 7-28.6 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3L288 439.8V0zM429.9 512c1.1 .1 2.1 .1 3.2 0h-3.2z"/>
															</svg>
														</span>
													<?php
												} else {
													?>
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
															<path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
														</svg>
													</span>
													<?php
												}
											}
										}
									?>
								</div>
							</div>

	            <?php
	              if(!empty($book_link)) {
	                echo '<a class="bt-post--book-link" href="' . esc_url($book_link['url']) . '" target="' . esc_attr($book_link['target']) . '">' . $book_link['title'] . '</a>';
	              }
	            ?>
	          </div>
	        </div>

	        <div class="bt-post--tabs bt-tabs-js">
	          <div class="bt-post--tbnav">
	            <a href="#bt_panel_desc" class="bt-nav-item bt-is-active">
	              <?php echo esc_html__('Description', 'bedemo'); ?>
	            </a>
	            <a href="#bt_panel_time_sc" class="bt-nav-item">
	              <?php echo esc_html__('Time Schedule', 'bedemo'); ?>
	            </a>
	            <a href="#bt_panel_reviews" class="bt-nav-item">
	              <?php
									echo esc_html__('Reviews', 'bedemo');

									$cm_count = get_comments_number();
									if($cm_count > 999 ) {
										$cm_count = $cm_count / 1000 . 'K+';
									}
									echo '<span>' . $cm_count . '</span>';
								?>
	            </a>
	          </div>
	          <div class="bt-post--tbpanel">
	            <div id="bt_panel_desc" class="bt-panel-item bt-panel-desc bt-is-active">
	              <div class="bt-panel-item--inner">
	                <div class="bt-panel-item--content bt-fl-no-mg">
	                  <?php the_content(); ?>
	                </div>

	                <div class="bt-panel-item--request-box">
	                  <?php get_template_part( 'framework/templates/request', 'box'); ?>
	                </div>
	              </div>
	            </div>

	            <div id="bt_panel_time_sc" class="bt-panel-item bt-panel-time-sc">
	              <div class="bt-panel-item--inner">
	                <div class="bt-panel-item--content">
	                  <?php get_template_part( 'framework/templates/service', 'time-schedule'); ?>
	                </div>

	                <div class="bt-panel-item--request-box">
	                  <?php get_template_part( 'framework/templates/request', 'box'); ?>
	                </div>
	              </div>
	            </div>
	            <div id="bt_panel_reviews" class="bt-panel-item bt-panel-reviews">
	              <div class="bt-panel-item--inner">
	                <div class="bt-panel-item--content">
	                  <?php
	          					if(comments_open() || get_comments_number()) {
	                      comments_template();
	                    }
	                  ?>
	                </div>

	                <div class="bt-panel-item--request-box">
	                  <?php get_template_part( 'framework/templates/request', 'box'); ?>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </article>
	    <?php endwhile; ?>
    </div>
	</div>

	<?php get_template_part( 'framework/templates/service', 'related-posts'); ?>
	<?php get_template_part( 'framework/templates/social', 'media-channels'); ?>
</main><!-- #main -->

<?php get_footer(); ?>
