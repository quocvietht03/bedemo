<?php
$related_posts = get_field('team_related_posts', 'options');

$post_id = get_the_ID();
$cat_ids = array();
$categories = get_the_category( $post_id );

if(!empty($categories) && !is_wp_error($categories)) {
  foreach ($categories as $category) {
    array_push($cat_ids, $category->term_id);
  }
}

$current_post_type = get_post_type($post_id);

$query_args = array(
    'category__in'   => $cat_ids,
    'post_type'      => $current_post_type,
    'post__not_in'    => array($post_id),
    'posts_per_page'  => !empty($related_posts['number_posts']) ? $related_posts['number_posts'] : 3,
 );

$list_posts = new WP_Query( $query_args );

if($list_posts->have_posts()) {
?>
  <div class="bt-related-posts-ss">
    <div class="bt-container">
      <div class="bt-related-posts-ss--content">
        <?php if(!($related_posts['sub_heading']) || !empty($related_posts['heading'])) {  ?>
          <div class="bt-related-posts-ss--heading">
            <?php
              if(!empty($related_posts['sub_heading'])) {
                echo '<div class="bt-sub-text">' . $related_posts['sub_heading'] . '</div>';
              }

              if(!empty($related_posts['heading'])) {
                echo '<h2 class="bt-main-text">' . $related_posts['heading'] . '</h2>';
              }

              if(!empty($related_posts['text_heading'])) {
                echo '<div class="bt-head-text">' . $related_posts['text_heading'] . '</div>';
              }
            ?>
          </div>
        <?php } ?>

        <div class="bt-related-posts-ss--list bt-image-effect">
          <?php
            while($list_posts->have_posts()): $list_posts->the_post();
              get_template_part( 'framework/templates/team', 'style', array('image-size' => 'medium_large') );
            endwhile; wp_reset_postdata();
          ?>
        </div>

        <?php
          if(!empty($related_posts['bottom_text'])) {
            echo '<div class="bt-related-posts-ss--bottom-text">' . $related_posts['bottom_text'] . '</div>';
          }
        ?>
      </div>
    </div>
  </div>
<?php
}
