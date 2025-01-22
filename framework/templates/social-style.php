<?php
$icon = get_field('icon');
$counter = get_field('counter');
$link = get_field('link');

?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <?php
      if(!empty($icon)) {
        echo '<div class="bt-post--icon">
                <img src="' . esc_url($icon['url']) . '" alt="' . esc_attr($icon['title']) . '" />
              </div>';
      }

      if(!empty($counter)) {
        echo '<div class="bt-post--count">' . $counter . '</div>';
      }

      echo '<h3 class="bt-post--title">' . get_the_title() . '</h3>';

      if(!empty($link)) {
        echo '<a class="bt-post--link" href="' . esc_url($link['url']) . '" target="' . esc_attr($link['target']) . '">' . $link['title'] . '</a>';
      };
    ?>
  </div>
</article>
