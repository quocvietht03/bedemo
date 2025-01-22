<?php
$pod_link = get_field('podcast_link');
$prf_link = get_field('profile_link');

?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <?php if (has_post_thumbnail()){ ?>
      <div class="bt-post--thumbnail">
        <?php echo bedemo_post_cover_featured_render($args['image-size']); ?>
        <?php if(!empty($pod_link) && $args['layout'] == 'style-2') { ?>
          <div class="bt-post--pod-link">
            <?php echo '<a href="' . esc_url($pod_link['url']) . '" target="' . esc_attr($pod_link['target']) . '"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                          <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/>
                        </svg> ' . $pod_link['title'] . '</a>'; ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>

    <div class="bt-post--infor">
      <?php if(!empty($pod_link) && ($args['layout'] == 'default' || $args['layout'] == 'style-1')) { ?>
        <div class="bt-post--pod-link">
          <?php echo '<a href="' . esc_url($pod_link['url']) . '" target="' . esc_attr($pod_link['target']) . '"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/>
                      </svg></a>'; ?>
        </div>
      <?php } ?>

      <div class="bt-post--infor-inner">
        <?php if($args['layout'] == 'style-2') { ?>
          <?php the_terms( get_the_ID(), 'podcast_categories', '<div class="bt-post--category">', ' - ', '</div>' ); ?>
        <?php } ?>

        <?php echo bedemo_post_title_render(); ?>

        <?php if(!empty($prf_link) && ($args['layout'] == 'default' || $args['layout'] == 'style-1')) { ?>
          <div class="bt-post--prf-link">
            <?php
            echo '<a href="' . esc_url($prf_link['link']['url']) . '" target="' . esc_attr($prf_link['link']['target']) . '">
                  <img src="' . esc_url($prf_link['icon']['url']) . '" alt="' . esc_attr($prf_link['icon']['title']) . '" />' . $prf_link['link']['title'] . '</a>';
            ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</article>
