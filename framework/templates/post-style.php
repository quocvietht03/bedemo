<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <?php echo bedemo_post_cover_featured_render($args['image-size']); ?>
    <div class="bt-post--infor">
      <?php
        echo bedemo_post_publish_render();
        echo bedemo_post_title_render();
        echo bedemo_post_short_meta_render();
      ?>
    </div>
  </div>
</article>
