<?php
/*
 * Single Team
 */

get_header();
get_template_part( 'framework/templates/site', 'titlebar');

$gallery = get_field('gallery_image');
$avatar = get_field('avatar');
$job = get_field('job');
$prf_link = get_field('profile_link');
$socials = get_field('socials');
$pkg_heading = get_field('package_heading');
$pkg_list = get_field('package_list');
$cnt_text = get_field('contact_text');

?>
<main id="bt_main" class="bt-site-main">
	<div class="bt-main-content-ss">
    <div class="bt-container">
	    <?php while ( have_posts() ) : the_post(); ?>
	      <div class="bt-post">
	        <?php if(!empty($gallery)) { ?>
	          <div class="bt-post--gallery">
	            <?php foreach ($gallery as $key => $item){ ?>
	              <div class="bt-image <?php echo 'bt-index-' . $key; ?>">
	                <div class="bt-cover-image">
	                  <img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" />
	                </div>
	              </div>
	            <?php } ?>
	          </div>
	        <?php } else { ?>
	          <?php if (has_post_thumbnail()){ ?>
	            <div class="bt-post--thumbnail">
	              <?php the_post_thumbnail('full'); ?>
	            </div>
	          <?php } ?>
	        <?php } ?>

	        <div class="bt-post--infor">
	          <?php if(!empty($avatar)) { ?>
	          <div class="bt-post--avatar">
	            <div class="bt-cover-image">
	              <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr($avatar['title']); ?>" />
	            </div>
	          </div>
	          <?php } ?>

	          <?php the_terms( get_the_ID(), 'team_categories', '<div class="bt-post--cat">', ', ', '</div>' ); ?>

	          <h3 class="bt-post--title">
	            <a href="<?php the_permalink(); ?>">
	              <?php the_title(); ?>
	            </a>
	            <?php
	              if(!empty($job)) {
	                echo '<span>' . $job . '</span>';
	              }
	            ?>
	          </h3>

	          <?php
	            if(!empty($prf_link)) {
	              echo '<a class="bt-post--prf-link" href="' . esc_url($prf_link['url']) . '" target="' . esc_attr($prf_link['target']) . '">' . $prf_link['title'] . '</a>';
	            }
	          ?>

	          <?php if(!empty($socials)) { ?>
	            <div class="bt-post--social">
	              <?php
	                foreach ($socials as $item) {
	                  if(!empty($item['icon'])) {
	                  ?>
	                    <a class="bt-social" href="<?php echo esc_url($item['link']); ?>" target="_blank">
	                      <img src="<?php echo esc_url($item['icon']) ?>" alt="" />
	                    </a>
	                  <?php
	                  }
	                }
	              ?>
	            </div>
	          <?php } ?>

	          <div class="bt-post--content">
	            <?php the_content(); ?>
	          </div>

	          <div class="bt-post--package">
	            <?php
								if(!empty($pkg_heading)) {
									echo '<h3 class="bt-package--head">' . $pkg_heading . '</h3>';
								}
							?>

	            <?php if(!empty($pkg_list)) { ?>
	              <div class="bt-package--list">
	                <?php foreach ($pkg_list as $item) { ?>
	                  <div class="bt-package--item">
	                    <div class="bt-package--inner">
	                      <?php
	                        if(!empty($item['name'])) {
	                          echo '<h3 class="bt-package--name">' . $item['name'] . '</h3>';
	                        }
	                        if(!empty($item['text'])) {
	                          echo '<div class="bt-package--text">' . $item['text'] . '</div>';
	                        }
	                      ?>

	                      <?php if(!empty($item['name']) || !empty($item['icon']) || !empty($item['link'])) { ?>
	                        <div class="bt-package--meta">
	                          <?php
	                            if(!empty($item['name'])) {
	                              echo '<span>' . $item['price'] . '</span>';
	                            }
	                            if(!empty($item['icon'])) {
	                              echo '<img src="' . esc_url($item['icon']) . '" alt="" />';
	                            }
	                            if(!empty($item['link'])) {
	                              echo '<a href="' . esc_url($item['link']['url']) . '" target="' . esc_attr($item['link']['target']) . '">' . $item['link']['title'] . '</a>';
	                            }
	                          ?>
	                        </div>
	                      <?php } ?>
	                    </div>
	                  </div>
	                <?php } ?>
	              </div>
	            <?php } ?>
	          </div>

						<?php
							if(!empty($cnt_text)) {
								echo '<div class="bt-post--contact">' . $cnt_text . '</div>';
							}
						?>
	        </div>
	      </div>
	    <?php endwhile; ?>
    </div>
	</div>

	<?php get_template_part( 'framework/templates/team', 'related-posts'); ?>
	<?php get_template_part( 'framework/templates/social', 'media-channels'); ?>
</main><!-- #main -->

<?php get_footer(); ?>
