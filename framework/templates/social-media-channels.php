<?php
if(function_exists('get_field')){
  $social_mcn = get_field('social_media_channels', 'options');
} else {
  return;
}

if(empty($social_mcn) || empty($social_mcn['enable'])) return;
$number_items = $social_mcn['style'] == 1 ? 4 : 5;
$number_items = !empty($social_mcn['number_items']) ? $social_mcn['number_items'] : $number_items;

?>
<div class="bt-social-mcn-ss <?php echo 'bt-style-' . esc_attr($social_mcn['style']); ?>">
  <div class="bt-container">
    <div class="bt-social-mcn-ss--content">
      <?php if(!($social_mcn['sub_heading']) || !empty($social_mcn['heading'])) {  ?>
        <div class="bt-social-mcn-ss--heading">
          <?php
            if(!empty($social_mcn['sub_heading'])) {
              echo '<div class="bt-sub-text">' . $social_mcn['sub_heading'] . '</div>';
            }

            if(!empty($social_mcn['heading'])) {
              echo '<h2 class="bt-main-text">' . $social_mcn['heading'] . '</h2>';
            }

            if(!empty($social_mcn['text_heading'])) {
    					echo '<div class="bt-head-text">' . $social_mcn['text_heading'] . '</div>';
    				}
          ?>
        </div>
      <?php } ?>

      <?php if(!empty($social_mcn['social_list'])) { ?>
        <div class="bt-social-mcn--list">
          <?php foreach ($social_mcn['social_list'] as $key => $item) {
                if($key == $number_items) break; ?>
            <div class="bt-social">
              <div class="bt-social--inner">

                <?php if(!empty($item['icon'])) { ?>
                  <div class="bt-social--icon">
                    <img src="<?php echo esc_url($item['icon']['url']); ?>" alt="<?php echo esc_attr($item['icon']['title']); ?>" />
                  </div>
                <?php } ?>
                <div class="bt-social--infor">
                  <?php
                    if(!empty($item['count'])) {
                      echo '<div class="bt-social--count">' . $item['count'] . '</div>';
                    }

                    if(!empty($item['title'])) {
                      echo '<div class="bt-social--title">' . $item['title'] . '</div>';
                    }

                    if(!empty($item['link'])) {
                      echo '<a class="bt-social--link" href="' . esc_url($item['link']['url']) . '" target="' . esc_attr($item['link']['target']) . '">' . $item['link']['title'] . '</a>';
                    }
                  ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
