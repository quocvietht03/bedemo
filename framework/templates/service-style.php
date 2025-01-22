<?php
$icon = get_field('icon');

?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <div class="bt-post--icon">
      <?php if(!empty($icon)) { ?>
        <svg width="122" height="113" viewBox="0 0 122 113" fill="#F5F5F5" xmlns="http://www.w3.org/2000/svg">
          <path d="M117.339 38.6685C130.117 70.8055 115.329 106.332 87.7236 111.429C60.3446 116.091 25.6005 98.0406 7.64754 75.8846C-10.1125 53.3566 4.51962 18.1336 36.4826 4.6286C44.0246 1.53558 52.1033 -0.0371815 60.2548 0.00066722C68.4064 0.0385159 76.4701 1.68613 83.9831 4.84906C91.4961 8.01198 98.3103 12.6278 104.034 18.4316C109.758 24.2353 114.28 31.1126 117.339 38.6685Z"/>
        </svg>
        <img class="bt-ab-center" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['title']); ?>" />
      <?php } ?>
    </div>

    <h3 class="bt-post--title">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h3>

    <div class="bt-post--excerpt">
      <?php echo get_the_excerpt(); ?>
    </div>

    <div class="bt-post--readmore">
      <a href="<?php the_permalink(); ?>">
        <?php echo esc_html__('Read More', 'bedemo'); ?>
      </a>
    </div>
  </div>
</article>
