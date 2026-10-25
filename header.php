<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if ( is_front_page() ) : ?>
  <meta name="description" content="<?php echo esc_attr( by_opt( 'brand' ) ); ?> helps Australian businesses find where time and money are being lost, then fixes it with AI, automation, better systems and digital marketing.">
  <meta property="og:title" content="<?php echo esc_attr( by_opt( 'brand' ) . ' | ' . by_opt( 'tagline' ) ); ?>">
  <meta property="og:description" content="Practical AI, automation and systems for Australian businesses. Start with a Business Efficiency Audit.">
  <meta property="og:type" content="website">
  <?php endif; ?>
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
        <a href="<?php echo esc_url( $h ); ?>#how">How it works</a>
        <a href="<?php echo esc_url( $h ); ?>#services">The difference</a>
        <a href="<?php echo esc_url( $h ); ?>#calculator">Time-back calculator</a>
        <a href="<?php echo esc_url( $h ); ?>#who">Who we help</a>
        <a href="<?php echo esc_url( by_work_url() ); ?>">Our work</a>
        <a href="<?php echo esc_url( $h ); ?>#about">About</a>
        <a href="<?php echo esc_url( $h ); ?>#faq">FAQ</a>
        <a href="<?php echo esc_url( $h ); ?>#contact" class="btn btn--sm js-book">Book a call</a>
      </nav>
      <button class="nav__toggle" id="navToggle" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks">
        <span></span><span></span>
      </button>
    </div>
  </header>
