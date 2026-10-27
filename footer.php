  <footer class="footer">
    <div class="wrap footer__inner footer__inner--v3">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo logo--sm"><span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span><span class="mark">.</span></a>
      <p class="footer__mid"><a href="#" data-email></a><?php if ( by_has( 'location' ) ) echo ' &middot; ' . esc_html( by_opt( 'location' ) ); ?> &middot; <a href="<?php echo esc_url( by_contact_url() ); ?>">Contact</a><a href="#" data-instagram hidden> &middot; Instagram</a><a href="#" data-linkedin hidden> &middot; LinkedIn</a></p>
      <p class="footer__small">© <span id="year"><?php echo esc_html( gmdate( 'Y' ) ); ?></span> <span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span><?php if ( by_has( 'abn' ) ) echo ' &middot; <span data-abn>' . esc_html( by_opt( 'abn' ) ) . '</span>'; ?> &middot; <a href="<?php echo esc_url( by_privacy_url() ); ?>">Privacy</a></p>
    </div>
  </footer>
<?php wp_footer(); ?>
</body>
</html>
