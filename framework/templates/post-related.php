<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <?php echo bedemo_post_cover_featured_render('medium_large'); ?>
    <div class="bt-post--infor">
      <?php echo bedemo_post_publish_render(); ?>
      <h3 class="bt-post--title">
        <a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a>
      </h3>
      <?php echo bedemo_post_short_meta_render(); ?>
    </div>
  </div>
</article>
