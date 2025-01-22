<?php
/**
 * Site Footer
 *
 */

?>
<footer class="bt-site-footer">
  <div class="bt-container">
    <div class="bt-copyright">
      <?php
        printf(
          esc_html__( '© All right reserved by %s.', 'bedemo' ),
          '<a href="' . esc_url( __( 'https://themeforest.net/user/bearsthemes/', 'bedemo' ) ) . '" target="_blank">Bearstheme</a>'
        );
      ?>
    </div>
  </div>
</footer>
