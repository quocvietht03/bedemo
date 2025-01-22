<?php
/**
 * Block Name: Widget - Contact Info
**/

$heading = get_field('heading');
$description = get_field('description');
$button = get_field('button');
$socials = get_field('socials');

?>
<div id="<?php echo 'bt_block--' . $block['id']; ?>" class="widget widget-block bt-block-contact-information">
  <div class="bt-contact-information">
    <?php
      if(!empty($heading)) {
        echo '<h3 class="bt-contact-information--head">' . $heading . '</h3>';
      }

      if(!empty($description)) {
        echo '<div class="bt-contact-information--desc">' . $description . '</div>';
      }

      if(!empty($button)) {
        echo '<a class="bt-contact-information--button" href="' . esc_url($button['url']) . '" target="' . esc_attr($button['target']) . '">' . $button['title'] . '</a>';
      }

      if(!empty($socials)) {
      ?>
        <div class="bt-contact-information--social">
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
      <?php
      }
    ?>
  </div>
</div>
