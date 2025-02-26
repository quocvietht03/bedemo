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
						<div class="bt-list-post">
							<?php
								while ( have_posts() ) : the_post();
						
										get_template_part( 'framework/templates/post');
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
