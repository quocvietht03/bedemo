<?php
$request_box = get_field('service_request_box', 'options');

if(empty($request_box)) return;
?>
<div class="bt-srq-box">
  <?php if(!empty($request_box['icon'])) { ?>
    <div class="bt-srq-box--icon">
      <img src="<?php echo esc_url($request_box['icon']['url']); ?>" alt="<?php echo esc_attr($request_box['icon']['title']); ?>" />
    </div>
  <?php } ?>
  <div class="bt-srq-box--infor">
    <?php
      if(!empty($request_box['title'])) {
        echo '<h3 class="bt-srq-box--title">' . $request_box['title'] . '</h3>';
      }

      if(!empty($request_box['text'])) {
        echo '<div class="bt-srq-box--text">' . $request_box['text'] . '</div>';
      }
    ?>
  </div>
  <?php
    if(!empty($request_box['link'])) {
      echo '<a class="bt-srq-box--book-link" href="' . esc_url($request_box['link']['url']) . '" target="' . esc_attr($request_box['link']['target']) . '">' . $request_box['link']['title'] . '</a>';
    }
  ?>
</div>
