<?php
/* Count post view. */
if (! function_exists('bedemo_set_count_view')) {
  function bedemo_set_count_view()
  {
    $post_id = get_the_ID();

    if (is_single() && !empty($post_id) && !isset($_COOKIE['bedemo_post_view_' . $post_id])) {
      $views = get_post_meta($post_id, '_post_count_views', true);
      $views = $views ? $views : 0;
      $views++;

      update_post_meta($post_id, '_post_count_views', $views);

      /* set cookie. */
      setcookie('bedemo_post_view_' . $post_id, $post_id, time() * 20, '/');
    }
  }
}
add_action('wp', 'bedemo_set_count_view');

/* Post count view */
if (! function_exists('bedemo_get_count_view')) {
  function bedemo_get_count_view()
  {
    $post_id = get_the_ID();
    $views = get_post_meta($post_id, '_post_count_views', true);

    $views = $views ? $views : 0;
    $label = $views > 1 ? esc_html__('Views', 'bedemo') : esc_html__('View', 'bedemo');
    return $views . ' ' . $label;
  }
}

/* Post Reading */
if (! function_exists('bedemo_reading_time_render')) {
  function bedemo_reading_time_render()
  {
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $readingtime = ceil($word_count / 200);

    return '<div class="bt-reading-time">' . $readingtime . ' min read' . '</div>';
  }
}

/* Single Post Title */
if (! function_exists('bedemo_single_post_title_render')) {
  function bedemo_single_post_title_render()
  {
    ob_start();
?>
    <h3 class="bt-post--title">
      <?php the_title(); ?>
    </h3>
  <?php

    return ob_get_clean();
  }
}

/* Post Title */
if (! function_exists('bedemo_post_title_render')) {
  function bedemo_post_title_render($link = '')
  {
    ob_start();
  ?>
    <h3 class="bt-post--title">
      <a href="<?php echo !empty($link) ? esc_url($link) : the_permalink(); ?>" <?php echo !empty($link) ? 'target="_blank"' : ''; ?>>
        <?php the_title(); ?>
      </a>
    </h3>
    <?php

    return ob_get_clean();
  }
}

/* Post Featured */
if (! function_exists('bedemo_post_featured_render')) {
  function bedemo_post_featured_render($image_size = 'full')
  {
    ob_start();

    if (is_single()) {
      if (has_post_thumbnail()) {
    ?>
        <div class="bt-post--featured">
          <?php the_post_thumbnail($image_size); ?>
        </div>
      <?php
      }
    } else {
      if (has_post_thumbnail()) {
      ?>
        <div class="bt-post--featured">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail($image_size); ?>
          </a>
        </div>
    <?php
      }
    }

    return ob_get_clean();
  }
}

/* Post Cover Featured */
if (! function_exists('bedemo_post_cover_featured_render')) {
  function bedemo_post_cover_featured_render($image_size = 'full', $link = '', $price = '')
  {
    ob_start();
    ?>
    <div class="bt-post--featured">
      <a href="<?php echo !empty($link) ? esc_url($link) : the_permalink(); ?>" <?php echo !empty($link) ? 'target="_blank"' : ''; ?>>
        <div class="bt-cover-image">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail($image_size);
          }
          ?>
          <?php if (!empty($price)) {
            echo '<span class="bt-price">' . $price . '</span>';
          }
          ?>
        </div>


      </a>
    </div>
  <?php

    return ob_get_clean();
  }
}

/* Post Publish */
if (! function_exists('bedemo_post_publish_render')) {
  function bedemo_post_publish_render()
  {
    ob_start();

  ?>
    <div class="bt-post--publish">
      <svg width="23" height="23" viewBox="0 0 23 23" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M14.352 22.9922C14.3232 22.9962 14.2941 22.9981 14.265 22.998H3.43701C2.52552 22.9967 1.65175 22.634 1.00742 21.9893C0.363083 21.3445 0.000793481 20.4706 0 19.5591V6.15283C0.000794397 5.24153 0.363147 4.36802 1.00754 3.72363C1.65193 3.07924 2.52571 2.71661 3.43701 2.71582H4.51099V1.85596C4.50705 1.74062 4.52639 1.62578 4.56781 1.51807C4.60923 1.41035 4.67191 1.31199 4.75211 1.229C4.83231 1.14602 4.9284 1.08023 5.03464 1.03516C5.14088 0.990085 5.25511 0.966797 5.37051 0.966797C5.48592 0.966797 5.60012 0.990085 5.70636 1.03516C5.8126 1.08023 5.90869 1.14602 5.98889 1.229C6.06909 1.31199 6.13176 1.41035 6.17319 1.51807C6.21461 1.62578 6.23395 1.74062 6.23001 1.85596V2.71582H10.1V1.85596C10.0961 1.74062 10.1154 1.62578 10.1568 1.51807C10.1982 1.41035 10.2609 1.31199 10.3411 1.229C10.4213 1.14602 10.5174 1.08023 10.6236 1.03516C10.7299 0.990085 10.8441 0.966797 10.9595 0.966797C11.0749 0.966797 11.1891 0.990085 11.2954 1.03516C11.4016 1.08023 11.4977 1.14602 11.5779 1.229C11.6581 1.31199 11.7208 1.41035 11.7622 1.51807C11.8036 1.62578 11.8229 1.74062 11.819 1.85596V2.71582H15.729V1.85596C15.7251 1.74075 15.7444 1.62615 15.7857 1.51855C15.8271 1.41096 15.8897 1.31287 15.9698 1.22998C16.0499 1.14709 16.1459 1.08115 16.252 1.03613C16.3581 0.991113 16.4722 0.967773 16.5875 0.967773C16.7028 0.967773 16.8169 0.991113 16.923 1.03613C17.0291 1.08115 17.1251 1.14709 17.2052 1.22998C17.2853 1.31287 17.3479 1.41096 17.3893 1.51855C17.4306 1.62615 17.4499 1.74075 17.446 1.85596V2.71582H18.563C19.4745 2.71661 20.3485 3.0793 20.9932 3.72363C21.6379 4.36797 22.0007 5.24134 22.002 6.15283V10.8799C21.9944 11.1028 21.9005 11.3143 21.7401 11.4692C21.5798 11.6242 21.3655 11.7104 21.1425 11.7104C20.9195 11.7104 20.7052 11.6242 20.5448 11.4692C20.3845 11.3143 20.2906 11.1028 20.283 10.8799V6.15283C20.2822 5.69717 20.1008 5.26068 19.7786 4.93848C19.4564 4.61627 19.0197 4.43488 18.564 4.43408H17.447V5.29395C17.4509 5.40915 17.4316 5.52424 17.3903 5.63184C17.3489 5.73943 17.2863 5.83752 17.2062 5.92041C17.1261 6.0033 17.0301 6.06924 16.924 6.11426C16.8179 6.15928 16.7038 6.18213 16.5885 6.18213C16.4732 6.18213 16.3591 6.15928 16.253 6.11426C16.1469 6.06924 16.0509 6.0033 15.9708 5.92041C15.8907 5.83752 15.8281 5.73943 15.7867 5.63184C15.7454 5.52424 15.7261 5.40915 15.73 5.29395V4.43408H11.82V5.29395C11.8124 5.51682 11.7185 5.72832 11.5582 5.8833C11.3978 6.03828 11.1835 6.12451 10.9605 6.12451C10.7375 6.12451 10.5232 6.03828 10.3629 5.8833C10.2025 5.72832 10.1086 5.51682 10.101 5.29395V4.43408H6.23001V5.29395C6.22241 5.51682 6.12853 5.72832 5.96817 5.8833C5.80781 6.03828 5.59352 6.12451 5.37051 6.12451C5.1475 6.12451 4.93321 6.03828 4.77286 5.8833C4.6125 5.72832 4.51859 5.51682 4.51099 5.29395V4.43408H3.43701C2.98143 4.43514 2.5448 4.61633 2.22266 4.93848C1.90051 5.26062 1.71904 5.69725 1.71799 6.15283V19.5591C1.71878 20.0147 1.90015 20.4512 2.22235 20.7734C2.54455 21.0956 2.98135 21.277 3.43701 21.2778H13.577V17.7549C13.5783 16.8432 13.9411 15.9694 14.5857 15.3247C15.2304 14.6801 16.1043 14.3172 17.016 14.3159H21.14C21.3086 14.3161 21.4734 14.3659 21.6139 14.459C21.7544 14.5521 21.8645 14.6842 21.9305 14.8394C21.9964 14.9945 22.0153 15.1658 21.9848 15.3315C21.9543 15.4973 21.8758 15.6505 21.759 15.772L15.059 22.7349C14.9787 22.8179 14.8825 22.884 14.7762 22.9292C14.6699 22.9744 14.5555 22.9979 14.44 22.998C14.4106 22.9981 14.3811 22.9963 14.352 22.9922ZM15.297 17.7549V20.0059L19.12 16.0352H17.02C16.5642 16.0357 16.1271 16.2168 15.8047 16.5391C15.4823 16.8613 15.3008 17.2981 15.3 17.7539L15.297 17.7549ZM8.25101 17.501C8.25081 17.3308 8.30107 17.1645 8.39545 17.0229C8.48982 16.8814 8.62406 16.7708 8.78119 16.7056C8.93832 16.6403 9.11128 16.6232 9.27817 16.6562C9.44506 16.6893 9.59838 16.7714 9.71875 16.8916C9.83912 17.0118 9.92114 17.1652 9.95441 17.332C9.98767 17.4989 9.9707 17.6719 9.90564 17.8291C9.84058 17.9863 9.73035 18.1203 9.5889 18.2148C9.44745 18.3094 9.28113 18.3599 9.11099 18.3599C8.99802 18.36 8.88614 18.3381 8.78174 18.2949C8.67734 18.2517 8.58248 18.1883 8.50259 18.1084C8.42271 18.0285 8.35937 17.9335 8.31619 17.8291C8.27302 17.7247 8.25088 17.614 8.25101 17.501ZM4.51099 17.501C4.51079 17.3308 4.56108 17.1645 4.65546 17.0229C4.74983 16.8814 4.88407 16.7708 5.0412 16.7056C5.19833 16.6403 5.37129 16.6232 5.53818 16.6562C5.70507 16.6893 5.85839 16.7714 5.97876 16.8916C6.09913 17.0118 6.18115 17.1652 6.21442 17.332C6.24768 17.4989 6.23068 17.6719 6.16562 17.8291C6.10056 17.9863 5.99036 18.1203 5.84891 18.2148C5.70746 18.3094 5.54114 18.3599 5.371 18.3599C5.25803 18.36 5.14615 18.3381 5.04175 18.2949C4.93735 18.2517 4.84249 18.1883 4.7626 18.1084C4.68272 18.0285 4.61937 17.9335 4.5762 17.8291C4.53303 17.7247 4.51085 17.614 4.51099 17.501ZM11.99 13.7612C11.9898 13.5911 12.0401 13.4243 12.1345 13.2827C12.2288 13.1412 12.3631 13.0311 12.5202 12.9658C12.6773 12.9006 12.8503 12.8834 13.0172 12.9165C13.184 12.9496 13.3374 13.0311 13.4578 13.1514C13.5781 13.2716 13.6601 13.4249 13.6934 13.5918C13.7267 13.7586 13.7097 13.9317 13.6446 14.0889C13.5796 14.2461 13.4693 14.3806 13.3279 14.4751C13.1864 14.5696 13.0201 14.6201 12.85 14.6201C12.6222 14.6199 12.4037 14.5292 12.2425 14.3682C12.0813 14.2072 11.9905 13.9891 11.99 13.7612ZM8.25 13.7612C8.2498 13.5911 8.30006 13.4243 8.39444 13.2827C8.48882 13.1412 8.62309 13.0311 8.78021 12.9658C8.93734 12.9006 9.11027 12.8834 9.27716 12.9165C9.44405 12.9496 9.59737 13.0311 9.71774 13.1514C9.83812 13.2716 9.92014 13.4249 9.9534 13.5918C9.98666 13.7586 9.96969 13.9317 9.90463 14.0889C9.83957 14.2461 9.72934 14.3806 9.58789 14.4751C9.44644 14.5696 9.28012 14.6201 9.10999 14.6201C8.88233 14.6196 8.66415 14.5287 8.50317 14.3677C8.34219 14.2067 8.25154 13.9889 8.25101 13.7612H8.25ZM4.51001 13.7612C4.50981 13.5911 4.56007 13.4243 4.65445 13.2827C4.74883 13.1412 4.88306 13.0311 5.04019 12.9658C5.19732 12.9006 5.37028 12.8834 5.53717 12.9165C5.70406 12.9496 5.85738 13.0311 5.97775 13.1514C6.09813 13.2716 6.18014 13.4249 6.21341 13.5918C6.24667 13.7586 6.2297 13.9317 6.16464 14.0889C6.09958 14.2461 5.98935 14.3806 5.8479 14.4751C5.70645 14.5696 5.54013 14.6201 5.37 14.6201C5.14234 14.6196 4.92416 14.5287 4.76318 14.3677C4.6022 14.2067 4.51054 13.9889 4.51001 13.7612ZM15.729 10.021C15.7288 9.85086 15.7791 9.68453 15.8734 9.54297C15.9678 9.40141 16.1021 9.29083 16.2592 9.22559C16.4163 9.16034 16.5893 9.1432 16.7562 9.17627C16.9231 9.20934 17.0764 9.29139 17.1967 9.41162C17.3171 9.53185 17.3991 9.6852 17.4324 9.85205C17.4657 10.0189 17.4487 10.1914 17.3836 10.3486C17.3186 10.5058 17.2083 10.6403 17.0669 10.7349C16.9254 10.8294 16.7591 10.8799 16.589 10.8799C16.3613 10.8794 16.1432 10.7889 15.9822 10.6279C15.8212 10.467 15.7305 10.2487 15.73 10.021H15.729ZM11.989 10.021C11.9888 9.85086 12.0391 9.68453 12.1335 9.54297C12.2278 9.40141 12.3621 9.29083 12.5192 9.22559C12.6763 9.16034 12.8493 9.1432 13.0162 9.17627C13.1831 9.20934 13.3364 9.29139 13.4568 9.41162C13.5771 9.53185 13.6591 9.6852 13.6924 9.85205C13.7257 10.0189 13.7087 10.1914 13.6436 10.3486C13.5786 10.5058 13.4684 10.6403 13.3269 10.7349C13.1855 10.8294 13.0191 10.8799 12.849 10.8799C12.6213 10.8794 12.4032 10.7889 12.2422 10.6279C12.0812 10.467 11.9895 10.2487 11.989 10.021ZM8.24899 10.021C8.2488 9.85086 8.29909 9.68453 8.39346 9.54297C8.48784 9.40141 8.62208 9.29083 8.77921 9.22559C8.93633 9.16034 9.10926 9.1432 9.27615 9.17627C9.44304 9.20934 9.59639 9.29139 9.71677 9.41162C9.83714 9.53185 9.91913 9.6852 9.95239 9.85205C9.98566 10.0189 9.96869 10.1914 9.90363 10.3486C9.83856 10.5058 9.72833 10.6403 9.58688 10.7349C9.44544 10.8294 9.27914 10.8799 9.10901 10.8799C8.88152 10.8791 8.6636 10.7884 8.50284 10.6274C8.34207 10.4665 8.25153 10.2485 8.25101 10.021H8.24899ZM4.509 10.021C4.5088 9.85086 4.55906 9.68453 4.65344 9.54297C4.74782 9.40141 4.88206 9.29083 5.03918 9.22559C5.19631 9.16034 5.36927 9.1432 5.53616 9.17627C5.70305 9.20934 5.85637 9.29139 5.97675 9.41162C6.09712 9.53185 6.17914 9.6852 6.2124 9.85205C6.24567 10.0189 6.2287 10.1914 6.16364 10.3486C6.09857 10.5058 5.98834 10.6403 5.84689 10.7349C5.70545 10.8294 5.53912 10.8799 5.36899 10.8799C5.1415 10.8791 4.92358 10.7884 4.76282 10.6274C4.60205 10.4665 4.51151 10.2485 4.51099 10.021H4.509Z" />
      </svg>
      <?php echo get_the_date(get_option('date_format')); ?>
    </div>
  <?php

    return ob_get_clean();
  }
}

/* Post Short Meta */
if (! function_exists('bedemo_post_short_meta_render')) {
  function bedemo_post_short_meta_render()
  {
    ob_start();

  ?>
    <div class="bt-post--meta">
      <?php
      the_terms(get_the_ID(), 'category', '<div class="bt-post-cat">', ', ', '</div>');
      echo bedemo_reading_time_render();
      ?>
    </div>
  <?php

    return ob_get_clean();
  }
}

/* Post Meta */
if (! function_exists('bedemo_post_meta_render')) {
  function bedemo_post_meta_render()
  {
    ob_start();

  ?>
    <ul class="bt-post--meta">
      <li class="bt-meta bt-meta--category">
        <?php
        the_terms(get_the_ID(), 'category', '<div class="bt-post-cat">', ', ', '</div>');
        echo bedemo_reading_time_render();
        ?>
      </li>
      <li class="bt-meta bt-meta--view">
        <a href="<?php echo get_the_permalink(); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
          </svg>
          <?php echo bedemo_get_count_view(); ?>
        </a>
      </li>
      <li class="bt-meta bt-meta--author">
        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
          </svg>
          <?php echo get_the_author(); ?>
        </a>
      </li>
      <li class="bt-meta bt-meta--comment">
        <a href="<?php comments_link(); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
            <path d="M160 368c26.5 0 48 21.5 48 48v16l72.5-54.4c8.3-6.2 18.4-9.6 28.8-9.6H448c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64c-8.8 0-16 7.2-16 16V352c0 8.8 7.2 16 16 16h96zm48 124l-.2 .2-5.1 3.8-17.1 12.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3V474.7v-6.4V468v-4V416H112 64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H448c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H309.3L208 492z" />
          </svg>
          <?php comments_number(esc_html__('0 Comments', 'bedemo'), esc_html__('1 Comment', 'bedemo'), esc_html__('% Comments', 'bedemo')); ?>
        </a>
      </li>
    </ul>
    <?php

    return ob_get_clean();
  }
}

/* Post Content */
if (! function_exists('bedemo_post_content_render')) {
  function bedemo_post_content_render()
  {

    ob_start();

    if (is_single()) {
    ?>
      <div class="bt-post--content">
        <?php
        echo get_the_content();
        wp_link_pages(array(
          'before' => '<div class="page-links">' . esc_html__('Pages:', 'bedemo'),
          'after' => '</div>',
        ));
        ?>
      </div>
    <?php
    } else {
    ?>
      <div class="bt-post--excerpt">
        <?php echo get_the_excerpt(); ?>
      </div>
    <?php
    }

    return ob_get_clean();
  }
}

/* Post tag */
if (! function_exists('bedemo_tags_render')) {
  function bedemo_tags_render()
  {
    ob_start();
    if (has_tag()) {
    ?>
      <div class="bt-post-tags">
        <?php
        if (has_tag()) {
          the_tags('<span>' . esc_html__('Tags: ', 'bedemo') . '</span>', '', '');
        }
        ?>
      </div>
    <?php
    }
    return ob_get_clean();
  }
}

/* Post share */
if (! function_exists('bedemo_share_render')) {
  function bedemo_share_render()
  {

    $social_item = array();
    $social_item[] = '<li>
                        <a target="_blank" data-btIcon="fa fa-facebook" data-toggle="tooltip" title="' . esc_attr__('Facebook', 'bedemo') . '" href="https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '">
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
                          </svg>
                        </a>
                      </li>';
    $social_item[] = '<li>
                        <a target="_blank" data-btIcon="fa fa-twitter" data-toggle="tooltip" title="' . esc_attr__('Twitter', 'bedemo') . '" href="https://twitter.com/share?url=' . get_the_permalink() . '">
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                          </svg>
                        </a>
                      </li>';
    $social_item[] = '<li>
                        <a target="_blank" data-btIcon="fa fa-google-plus" data-toggle="tooltip" title="' . esc_attr__('Google Plus', 'bedemo') . '" href="https://plus.google.com/share?url=' . get_the_permalink() . '">
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512">
                            <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                          </svg>
                        </a>
                      </li>';
    $social_item[] = '<li>
                        <a target="_blank" data-btIcon="fa fa-linkedin" data-toggle="tooltip" title="' . esc_attr__('Linkedin', 'bedemo') . '" href="https://www.linkedin.com/shareArticle?url=' . get_the_permalink() . '">
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
                          </svg>
                        </a>
                      </li>';
    $social_item[] = '<li>
                        <a target="_blank" data-btIcon="fa fa-pinterest" data-toggle="tooltip" title="' . esc_attr__('Pinterest', 'bedemo') . '" href="https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '">
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 496 512">
                            <path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/>
                          </svg>
                        </a>
                      </li>';

    ob_start();
    if (has_tag()) {
    ?>
      <div class="bt-post-share">
        <?php
        if (!empty($social_item)) {
          echo '<span>' . esc_html__('Share: ', 'bedemo') . '</span><ul>' . implode(' ', $social_item) . '</ul>';
        }
        ?>
      </div>
    <?php
    }
    return ob_get_clean();
  }
}

/* Author */
if (! function_exists('bedemo_author_render')) {
  function bedemo_author_render()
  {
    $author_id = get_the_author_meta('ID');
    $desc = get_the_author_meta('description');

    if (function_exists('get_field')) {
      $avatar = get_field('avatar', 'user_' . $author_id);
      $job = get_field('job', 'user_' . $author_id);
      $socials = get_field('socials', 'user_' . $author_id);
    } else {
      $avatar = array();
      $job = '';
      $socials = array();
    }

    ob_start();
    ?>
    <div class="bt-post-author">
      <div class="bt-post-author--avatar">
        <?php
        if (!empty($avatar)) {
          echo '<img src="' . esc_url($avatar['url']) . '" alt="' . esc_attr($avatar['title']) . '" />';
        } else {
          echo get_avatar($author_id, 150);
        }
        ?>
      </div>
      <div class="bt-post-author--info">
        <h4 class="bt-post-author--name">
          <span class="bt-name">
            <?php the_author(); ?>
          </span>
          <?php
          if (!empty($job)) {
            echo '<span class="bt-label">' . $job . '</span>';
          }
          ?>
        </h4>
        <?php
        if (!empty($desc)) {
          echo '<div class="bt-post-author--desc">' . $desc . '</div>';
        }

        if (!empty($socials)) {
        ?>
          <div class="bt-post-author--socials">
            <?php
            foreach ($socials as $item) {
              if ($item['social'] == 'facebook') {
                echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                          <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
                        </svg>
                      </a>';
              }

              if ($item['social'] == 'linkedin') {
                echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                          <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
                        </svg>
                      </a>';
              }

              if ($item['social'] == 'twitter') {
                echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                        </svg>
                      </a>';
              }

              if ($item['social'] == 'google') {
                echo '<a class="bt-' . esc_attr($item['social']) . '" href="' . esc_url($item['link']) . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                          <path d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"/>
                        </svg>
                      </a>';
              }
            }
            ?>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }
}


/* Related posts */
if (! function_exists('bedemo_related_posts')) {
  function bedemo_related_posts()
  {
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category($post_id);

    if (!empty($categories) && !is_wp_error($categories)) {
      foreach ($categories as $category) {
        array_push($cat_ids, $category->term_id);
      }
    }

    $current_post_type = get_post_type($post_id);

    $query_args = array(
      'category__in'   => $cat_ids,
      'post_type'      => $current_post_type,
      'post__not_in'    => array($post_id),
      'posts_per_page'  => 2,
    );

    $list_posts = new WP_Query($query_args);

    ob_start();

    if ($list_posts->have_posts()) {
    ?>
      <div class="bt-related-posts">
        <h2 class="bt-related-posts--heading">
          <?php esc_html_e('Related Posts', 'bedemo'); ?>
        </h2>
        <div class="bt-related-posts--list bt-image-effect">
          <?php
          while ($list_posts->have_posts()): $list_posts->the_post();
            get_template_part('framework/templates/post', 'related');
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
    <?php
    }
    return ob_get_clean();
  }
}

//Comment Field Order
function bedemo_comment_fields_custom_order($fields)
{
  $comment_field = $fields['comment'];
  $author_field = $fields['author'];
  $email_field = $fields['email'];
  $cookies_field = $fields['cookies'];
  unset($fields['comment']);
  unset($fields['author']);
  unset($fields['email']);
  unset($fields['url']);
  unset($fields['cookies']);
  // the order of fields is the order below, change it as needed:
  $fields['author'] = $author_field;
  $fields['email'] = $email_field;
  $fields['comment'] = $comment_field;
  // done ordering, now return the fields:
  return $fields;
}
add_filter('comment_form_fields', 'bedemo_comment_fields_custom_order');

/* Custom comment list */
if (! function_exists('bedemo_custom_comment')) {
  function bedemo_custom_comment($comment, $args, $depth)
  {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_html($tag); ?> <?php comment_class(empty($args['has_children']) ? 'bt-comment-item clearfix' : 'bt-comment-item parent clearfix') ?> id="comment-<?php comment_ID() ?>">
      <div class="bt-comment">
        <div class="bt-avatar">
          <?php
          if (function_exists('get_field')) {
            $avatar = get_field('avatar', 'user_' . $comment->user_id);
          } else {
            $avatar = array();
          }
          if (!empty($avatar)) {
            echo '<img src="' . esc_url($avatar['url']) . '" alt="' . esc_attr($avatar['title']) . '" />';
          } else {
            if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']);
          }


          ?>
        </div>
        <div class="bt-content">
          <h5 class="bt-name">
            <?php echo get_comment_author(get_comment_ID()); ?>
          </h5>
          <div class="bt-date">
            <?php echo get_comment_date(); ?>
          </div>
          <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'bedemo'); ?></em>
          <?php endif; ?>
          <div class="bt-text">
            <?php comment_text(); ?>
          </div>
          <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
        </div>
      </div>
  <?php
  }
}
