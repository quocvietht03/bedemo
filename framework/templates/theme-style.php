<?php
$link_theme = get_field('link_theme');
$price = get_field('price');
?>
<article <?php post_class('bt-post'); ?>>
  <div class="bt-post--wrap">
    <div class="bt-post--inner">
      <?php echo bedemo_post_cover_featured_render($args['image-size'],$link_theme,$price); ?>
      <div class="bt-post--infor">
        <?php
        $terms = get_the_terms(get_the_ID(), 'betheme_categories');
        if (!empty($terms) && !is_wp_error($terms)) {
          $first_category = reset($terms);
          echo '<div class="bt-first-category">' . esc_html($first_category->name) . '</div>';
        }
        echo bedemo_post_title_render($link_theme);
        if (have_rows('list_features')) {
          echo '<ul class="list-features">';
          while (have_rows('list_features')) {
            the_row();
            $item = get_sub_field('item');
            echo '<li>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M20.7243 7.06052C21.1051 7.46054 21.0895 8.09352 20.6895 8.47431L9.13394 19.4743C8.9366 19.6622 8.67116 19.7614 8.399 19.749C8.12683 19.7366 7.8715 19.6137 7.69204 19.4087L3.24759 14.3318C2.88381 13.9162 2.92578 13.2844 3.34133 12.9207C3.75688 12.5569 4.38865 12.5988 4.75243 13.0144L8.51013 17.3068L19.3105 7.0257C19.7106 6.64491 20.3435 6.6605 20.7243 7.06052Z" fill="currentColor"/>
                      </svg>' . esc_html($item) . '
                  </li>';
          }
          echo '</ul>';
        }
        ?>
        <div class="bt-post--button">
          <a href="<?php echo !empty($link_theme) ? esc_url($link_theme) : the_permalink(); ?>" <?php echo !empty($link_theme) ? 'target="_blank"' : ''; ?> class="btn btn-primary"><?php echo esc_html__('View demos', 'bedemo') ?><svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
              <path d="M15.938 5.75V13.875C15.938 14.1236 15.8392 14.3621 15.6634 14.5379C15.4876 14.7137 15.2491 14.8125 15.0005 14.8125C14.7518 14.8125 14.5134 14.7137 14.3375 14.5379C14.1617 14.3621 14.063 14.1236 14.063 13.875V8.01563L5.66374 16.4133C5.48762 16.5894 5.24875 16.6883 4.99967 16.6883C4.7506 16.6883 4.51173 16.5894 4.33561 16.4133C4.15949 16.2372 4.06055 15.9983 4.06055 15.7492C4.06055 15.5001 4.15949 15.2613 4.33561 15.0852L12.7348 6.6875H6.87545C6.62681 6.6875 6.38836 6.58873 6.21254 6.41291C6.03673 6.2371 5.93795 5.99864 5.93795 5.75C5.93795 5.50136 6.03673 5.2629 6.21254 5.08709C6.38836 4.91127 6.62681 4.8125 6.87545 4.8125H15.0005C15.2491 4.8125 15.4876 4.91127 15.6634 5.08709C15.8392 5.2629 15.938 5.50136 15.938 5.75Z" fill="currentColor" />
            </svg></a>
        </div>
      </div>
    </div>
  </div>
</article>