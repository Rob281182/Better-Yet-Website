  <footer class="footer">
    <div class="wrap footer__inner">
      <div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo logo--sm"><span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span><span class="mark">.</span></a>
        <p class="footer__tag" data-tagline><?php echo esc_html( by_opt( 'tagline' ) ); ?></p>
      </div>
      <div class="footer__links">
        <a href="#" data-instagram hidden>Instagram</a>
        <a href="#" data-linkedin hidden>LinkedIn</a>
        <a href="<?php echo esc_url( by_privacy_url() ); ?>">Privacy</a>
      </div>
      <p class="footer__small">© <span id="year"><?php echo esc_html( gmdate( 'Y' ) ); ?></span> <span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span>. <span data-abn><?php echo esc_html( by_opt( 'abn' ) ); ?></span></p>
    </div>
  </footer>
<?php wp_footer(); ?>
</body>
</html>
