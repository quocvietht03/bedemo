<?php
$job = get_field('job');
$prf_link = get_field('profile_link');
$socials = get_field('socials');

?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <?php if (has_post_thumbnail()){ ?>
      <div class="bt-post--thumbnail">
        <?php echo bedemo_post_cover_featured_render($args['image-size']); ?>
      </div>
    <?php } ?>

    <div class="bt-post--infor">
      <?php echo bedemo_post_title_render(); ?>

      <?php
        if(!empty($job)) {
          echo '<div class="bt-post--job">' . $job . '</div>';
        }
      ?>

      <?php if(!empty($prf_link)) { ?>
        <div class="bt-post--prf-link">
          <?php echo '<a href="' . esc_url($prf_link['url']) . '" target="' . esc_attr($prf_link['target']) . '">' . $prf_link['title'] . '</a>'; ?>
        </div>
      <?php } ?>

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
    </div>
  </div>
</article>
