<article <?php post_class('bt-post'); ?>>
	<?php
		echo bedemo_post_featured_render('full');
		echo bedemo_post_publish_render();
		if(is_single()){
      echo bedemo_single_post_title_render();
		}else{
      echo bedemo_post_title_render();
		}
		echo bedemo_post_meta_render();
		echo bedemo_post_content_render();
	?>
</article>
