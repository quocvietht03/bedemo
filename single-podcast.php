<?php
/*
 * Single Showreel
 */

get_header();
get_template_part( 'framework/templates/site', 'titlebar');

$ex_content = get_field('extra_content');
$gallery = get_field('gallery_image');
$avatar = get_field('avatar');
$pod_link = get_field('podcast_link');
$tsc_link = get_field('transcript_link');
$fb_link = get_field('facebook_link');
$yt_link = get_field('youtube_link');
$tt_link = get_field('tiktok_link');
$ins_link = get_field('instagram_link');

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

	          <?php the_terms( get_the_ID(), 'podcast_categories', '<div class="bt-post--cat">', ', ', '</div>' ); ?>

	          <h3 class="bt-post--title">
	            <a href="<?php the_permalink(); ?>">
	              <?php the_title(); ?>
	            </a>
	          </h3>

	          <div class="bt-post--meta">
	            <?php if(!empty($pod_link)) { ?>
	              <div class="bt-meta-item">
	                <?php echo '<a class="bt-meta-item--pod-link"  href="' . esc_url($pod_link['url']) . '" target="' . esc_attr($pod_link['target']) . '"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
	                              <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/>
	                            </svg> ' . $pod_link['title'] . '</a>'; ?>
	              </div>
	            <?php } ?>

	            <?php if(!empty($tsc_link)) { ?>
	              <div class="bt-meta-item">
	                <?php echo '<a class="bt-meta-item--tsc-link" href="' . esc_url($tsc_link['url']) . '" target="' . esc_attr($tsc_link['target']) . '">' . $tsc_link['title'] . '</a>'; ?>
	              </div>
	            <?php } ?>
	            <?php if(!empty($fb_link) || !empty($yt_link) || !empty($tt_link) || !empty($ins_link)) { ?>
	              <div class="bt-meta-item bt-socials">
	                <?php
	                  echo '<span>' . esc_html__('Share Podcast:', 'bedemo') . '</span>';

	                  if(!empty($fb_link)) {
	                    echo '<a class="bt-meta-item--fb-link" href="' . esc_url($fb_link) . '" target="_blank"><svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <g clip-path="url(#clip0_242_2708)">
	                              <path d="M19.3375 0H3.4125C1.52783 0 0 1.45507 0 3.25V18.4167C0 20.2116 1.52783 21.6667 3.4125 21.6667H19.3375C21.2222 21.6667 22.75 20.2116 22.75 18.4167V3.25C22.75 1.45507 21.2222 0 19.3375 0Z" fill="#1877F2"/>
	                              <path d="M15.8021 13.9648L16.3086 10.8333H13.1538V8.802C13.1538 7.94718 13.5937 7.10929 15.0067 7.10929H16.4419V4.44328C16.4419 4.44328 15.14 4.23169 13.8959 4.23169C11.2965 4.23169 9.59912 5.72974 9.59912 8.44653V10.8333H6.71094V13.9648H9.59912V21.6666H13.1538V13.9648H15.8021Z" fill="white"/>
	                            </g>
	                            <defs>
	                              <clipPath id="clip0_242_2708">
	                                <rect width="22.75" height="21.6667" fill="white"/>
	                              </clipPath>
	                            </defs>
	                          </svg></a>';
	                  }

	                  if(!empty($yt_link)) {
	                    echo '<a class="bt-meta-item--yt-link" href="' . esc_url($yt_link) . '" target="_blank"><svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3549 14.8289L12.354 6.17356L20.257 10.5161L12.3549 14.8289ZM29.7075 4.67373C29.7075 4.67373 29.4214 2.55106 28.5448 1.61631C27.4324 0.388916 26.1856 0.38314 25.6143 0.311903C21.5212 3.82528e-08 15.3814 0 15.3814 0H15.3686C15.3686 0 9.22884 3.82528e-08 5.13567 0.311903C4.56347 0.38314 3.3176 0.388916 2.20427 1.61631C1.32769 2.55106 1.0425 4.67373 1.0425 4.67373C1.0425 4.67373 0.75 7.16703 0.75 9.65936V11.9967C0.75 14.49 1.0425 16.9823 1.0425 16.9823C1.0425 16.9823 1.32769 19.105 2.20427 20.0398C3.3176 21.2672 4.77919 21.2287 5.43 21.3567C7.77 21.5935 15.375 21.6667 15.375 21.6667C15.375 21.6667 21.5212 21.657 25.6143 21.3451C26.1856 21.2729 27.4324 21.2672 28.5448 20.0398C29.4214 19.105 29.7075 16.9823 29.7075 16.9823C29.7075 16.9823 30 14.49 30 11.9967V9.65936C30 7.16703 29.7075 4.67373 29.7075 4.67373Z" fill="#CD201F"/>
	                          </svg></a>';
	                  }

	                  if(!empty($tt_link)) {
	                    echo '<a class="bt-meta-item--tt-link" href="' . esc_url($tt_link) . '" target="_blank"><svg width="19" height="24" viewBox="0 0 19 24" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <path d="M10.5431 1V15.7746C10.5431 16.5572 10.2391 17.3077 9.69793 17.8611C9.15679 18.4145 8.42286 18.7254 7.65758 18.7254C6.8923 18.7254 6.15836 18.4145 5.61723 17.8611C5.07609 17.3077 4.77209 16.5572 4.77209 15.7746C4.77208 14.9911 5.07576 14.2395 5.61661 13.6844C6.15745 13.1294 6.89136 12.8162 7.65758 12.8134V8.88258C5.87012 8.88258 4.15588 9.6087 2.89195 10.9012C1.62803 12.1937 0.917969 13.9467 0.917969 15.7746C0.917969 17.6025 1.62803 19.3555 2.89195 20.648C4.15588 21.9405 5.87012 22.6667 7.65758 22.6667C9.44503 22.6667 11.1593 21.9405 12.4232 20.648C13.6871 19.3555 14.3972 17.6025 14.3972 15.7746V8.88258L14.6011 8.98685C15.7358 9.56181 16.9849 9.86152 18.2513 9.86269V5.9214H18.1391C17.07 5.64901 16.1207 5.01854 15.4425 4.13042C14.7644 3.24231 14.3964 2.14765 14.3972 1.02085H10.5431V1Z" stroke="#020202" stroke-miterlimit="10"/>
	                          </svg></a>';
	                  }

	                  if(!empty($ins_link)) {
	                    echo '<a class="bt-meta-item--ins-link" href="' . esc_url($ins_link) . '" target="_blank"><svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <g clip-path="url(#clip0_242_2699)">
	                              <path d="M18.125 0H5.125C2.43261 0 0.25 2.07868 0.25 4.64286V17.0238C0.25 19.588 2.43261 21.6667 5.125 21.6667H18.125C20.8174 21.6667 23 19.588 23 17.0238V4.64286C23 2.07868 20.8174 0 18.125 0Z" fill="url(#paint0_radial_242_2699)"/>
	                              <path d="M18.125 0H5.125C2.43261 0 0.25 2.07868 0.25 4.64286V17.0238C0.25 19.588 2.43261 21.6667 5.125 21.6667H18.125C20.8174 21.6667 23 19.588 23 17.0238V4.64286C23 2.07868 20.8174 0 18.125 0Z" fill="url(#paint1_radial_242_2699)"/>
	                              <path d="M18.125 0H5.125C2.43261 0 0.25 2.07868 0.25 4.64286V17.0238C0.25 19.588 2.43261 21.6667 5.125 21.6667H18.125C20.8174 21.6667 23 19.588 23 17.0238V4.64286C23 2.07868 20.8174 0 18.125 0Z" fill="url(#paint2_radial_242_2699)"/>
	                              <path d="M17.3125 6.66675C17.3125 7.35708 16.7248 7.91675 16 7.91675C15.2752 7.91675 14.6875 7.35708 14.6875 6.66675C14.6875 5.97639 15.2752 5.41675 16 5.41675C16.7248 5.41675 17.3125 5.97639 17.3125 6.66675Z" fill="white"/>
	                              <path fill-rule="evenodd" clip-rule="evenodd" d="M11.625 14.5833C13.7996 14.5833 15.5625 12.9043 15.5625 10.8333C15.5625 8.7622 13.7996 7.08325 11.625 7.08325C9.4504 7.08325 7.6875 8.7622 7.6875 10.8333C7.6875 12.9043 9.4504 14.5833 11.625 14.5833ZM11.625 13.0833C12.9298 13.0833 13.9875 12.0759 13.9875 10.8333C13.9875 9.59058 12.9298 8.58325 11.625 8.58325C10.3202 8.58325 9.2625 9.59058 9.2625 10.8333C9.2625 12.0759 10.3202 13.0833 11.625 13.0833Z" fill="white"/>
	                              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3125 10.5167C3.3125 7.85651 3.3125 6.52635 3.8561 5.5103C4.33427 4.61652 5.09726 3.88986 6.03573 3.43447C7.10258 2.91675 8.49925 2.91675 11.2925 2.91675H11.9575C14.7507 2.91675 16.1474 2.91675 17.2142 3.43447C18.1527 3.88986 18.9157 4.61652 19.3939 5.5103C19.9375 6.52635 19.9375 7.85651 19.9375 10.5167V11.1501C19.9375 13.8103 19.9375 15.1405 19.3939 16.1565C18.9157 17.0503 18.1527 17.777 17.2142 18.2323C16.1474 18.7501 14.7507 18.7501 11.9575 18.7501H11.2925C8.49925 18.7501 7.10258 18.7501 6.03573 18.2323C5.09726 17.777 4.33427 17.0503 3.8561 16.1565C3.3125 15.1405 3.3125 13.8103 3.3125 11.1501V10.5167ZM11.2925 4.50008H11.9575C13.3816 4.50008 14.3496 4.50132 15.0979 4.55954C15.8268 4.61625 16.1995 4.71905 16.4595 4.84522C17.0851 5.14883 17.5938 5.63327 17.9126 6.22908C18.0451 6.47671 18.1531 6.8317 18.2126 7.52591C18.2737 8.23857 18.275 9.16046 18.275 10.5167V11.1501C18.275 12.5064 18.2737 13.4283 18.2126 14.1409C18.1531 14.8351 18.0451 15.1901 17.9126 15.4377C17.5938 16.0336 17.0851 16.518 16.4595 16.8216C16.1995 16.9478 15.8268 17.0506 15.0979 17.1073C14.3496 17.1655 13.3816 17.1667 11.9575 17.1667H11.2925C9.8684 17.1667 8.90041 17.1655 8.15212 17.1073C7.4232 17.0506 7.05047 16.9478 6.79045 16.8216C6.16484 16.518 5.65618 16.0336 5.3374 15.4377C5.20492 15.1901 5.09698 14.8351 5.03743 14.1409C4.9763 13.4283 4.975 12.5064 4.975 11.1501V10.5167C4.975 9.16046 4.9763 8.23857 5.03743 7.52591C5.09698 6.8317 5.20492 6.47671 5.3374 6.22908C5.65618 5.63327 6.16484 5.14883 6.79045 4.84522C7.05047 4.71905 7.4232 4.61625 8.15212 4.55954C8.90041 4.50132 9.8684 4.50008 11.2925 4.50008Z" fill="white"/>
	                            </g>
	                            <defs>
	                              <radialGradient id="paint0_radial_242_2699" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(8.375 16.25) rotate(-54.0578) scale(20.0714 20.3999)">
	                                <stop stop-color="#B13589"/>
	                                <stop offset="0.79309" stop-color="#C62F94"/>
	                                <stop offset="1" stop-color="#8A3AC8"/>
	                              </radialGradient>
	                              <radialGradient id="paint1_radial_242_2699" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(7.5625 22.4405) rotate(-64.0531) scale(17.6413 18.1937)">
	                                <stop stop-color="#E0E8B7"/>
	                                <stop offset="0.444662" stop-color="#FB8A2E"/>
	                                <stop offset="0.71474" stop-color="#E2425C"/>
	                                <stop offset="1" stop-color="#E2425C" stop-opacity="0"/>
	                              </radialGradient>
	                              <radialGradient id="paint2_radial_242_2699" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(-0.96875 0.77381) rotate(-7.74777) scale(31.5695 6.44282)">
	                                <stop offset="0.156701" stop-color="#406ADC"/>
	                                <stop offset="0.467799" stop-color="#6A45BE"/>
	                                <stop offset="1" stop-color="#6A45BE" stop-opacity="0"/>
	                              </radialGradient>
	                              <clipPath id="clip0_242_2699">
	                                <rect width="22.75" height="21.6667" fill="white" transform="translate(0.25)"/>
	                              </clipPath>
	                            </defs>
	                          </svg></a>';
	                  }
	                ?>
	              </div>
	            <?php } ?>
	          </div>

	          <div class="bt-post--content">
	            <div class="bt-post--content-inner">
	              <?php the_content(); ?>
	            </div>
	            <div class="bt-post--request-box">
	              <?php get_template_part( 'framework/templates/request', 'box'); ?>
	            </div>
							<?php
								if(!empty($ex_content)) {
									echo '<div class="bt-post--extra-content">' . $ex_content . '</div>';
								}
							?>
	          </div>

	          <?php echo bedemo_author_render(); ?>

	        </div>
	      </div>
	    <?php endwhile; ?>
    </div>
	</div>

	<?php get_template_part( 'framework/templates/podcast', 'related-posts'); ?>
	<?php get_template_part( 'framework/templates/social', 'media-channels'); ?>
</main><!-- #main -->

<?php get_footer(); ?>
