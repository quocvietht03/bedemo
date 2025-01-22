<?php
get_header();
get_template_part( 'framework/templates/site', 'titlebar');

?>
<main id="bt_main" class="bt-site-main">
	<div class="bt-main-content-ss">
		<div class="bt-container">
			<?php
				if( have_posts() ) {
					?>
						<div class="<?php if($team_sft) { echo 'bt-grid-post bt-image-effect'; } else { echo 'bt-list-post'; } ?>">
							<?php
								while ( have_posts() ) : the_post();
									if($team_sft) {
										get_template_part( 'framework/templates/team', 'style', array('image-size' => 'medium_large'));
									} else {
										get_template_part( 'framework/templates/post');
									}
								endwhile;
							?>
						</div>
					<?php
					bedemo_paging_nav();
				} else {
					get_template_part( 'framework/templates/post', 'none');
				}
			?>
		</div>
	</div>

	<?php get_template_part( 'framework/templates/social', 'media-channels'); ?>
</main><!-- #main -->

<?php get_footer(); ?>
