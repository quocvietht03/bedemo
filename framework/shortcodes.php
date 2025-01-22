<?php
// [quote author="author-value"]content[quote]
function bedemo_quote_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'author' => '',

	), $atts );

  ob_start()
  ?>
  <div class="bt-sc-quote">
    <div class="bt-sc-quote--icon">
      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
        <path d="M0 216C0 149.7 53.7 96 120 96h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V320 288 216zm256 0c0-66.3 53.7-120 120-120h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H320c-35.3 0-64-28.7-64-64V320 288 216z"/>
      </svg>
    </div>
    <div class="bt-sc-quote--infor">
      <?php
        if(!empty($content)) {
          echo '<div class="bt-sc-quote--content">' . $content . '</div>';
        }
        if(!empty($a['author'])) {
          echo '<div class="bt-sc-quote--author">' . $a['author'] . '</div>';
        }
      ?>
    </div>
  </div>
  <?php
	return ob_get_clean();
}
add_shortcode( 'quote', 'bedemo_quote_func' );
