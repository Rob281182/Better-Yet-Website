<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
  <a class="skip" href="#main">Skip to content</a>
  <?php $h = is_front_page() ? '' : home_url( '/' ); ?>
  <header class="nav" id="top">
    <div class="wrap nav__inner">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="Home"><span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span><span class="mark">.</span></a>
      <nav class="nav__links" id="navLinks" aria-label="Main">
        <a href="<?php echo esc_url( by_work_url() ); ?>">Work</a>
        <a href="<?php echo esc_url( $h ); ?>#audit">How it works</a>
        <a href="<?php echo esc_url( $h ); ?>#pricing">Pricing</a>
        <a href="<?php echo esc_url( $h ); ?>#about">About</a>
        <a href="<?php echo esc_url( $h ); ?>#faq">FAQ</a>
        <a href="<?php echo esc_url( by_book_url() . '?call=audit' ); ?>" class="btn btn--sm js-book">Book the audit <span aria-hidden="true">→</span></a>
      </nav>
      <button class="nav__toggle" id="navToggle" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks">
        <span></span><span></span>
      </button>
    </div>
  </header>
