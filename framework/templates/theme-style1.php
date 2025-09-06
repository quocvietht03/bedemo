<?php
$link_theme = get_field('link_theme');
$thumb_preview = get_field('thumb_preview');
$sub_title = get_field('sub_title');
$price = get_field('price');

?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--inner">
    <div class="bt-post--featured">
      <a href="<?php echo !empty($link_theme) ? esc_url($link_theme) : '#' ?>" <?php echo !empty($link_theme) ? 'target="_blank"' : ''; ?>>
        <?php echo '<div class="bt-cover-image ">' . wp_get_attachment_image ($thumb_preview['id'], $args['image-size']) . '</div>'; ?>
      </a>
    </div>
    <div class="bt-post--infor">
      <div class="bt-post--info">
        <h2 class="bt-post--subtitle"><a href="<?php echo esc_url($link_theme ? $link_theme : '#'); ?>" <?php echo $link_theme ? 'target="_blank"' : ''; ?>><?php echo esc_html($sub_title); ?></a></h2>
        <?php
        $terms = get_the_terms(get_the_ID(), 'betheme_categories');
        if (!empty($terms) && !is_wp_error($terms)) {
          $first_category = reset($terms);
          echo '<div class="bt-first-category">' . esc_html($first_category->name) . '</div>';
        }
        ?>
      </div>
      <div class="bt-post--price">
        <?php if (!empty($price)) {
          echo '<span class="bt-price">' . $price . '</span>';
        } ?>
      </div>
    </div>
  </div>
</article>