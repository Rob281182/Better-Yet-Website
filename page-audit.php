<?php
/**
 * Template Name: The audit
 * /audit/ (v2.5.0): the landing page ads point to. One offer, one price, the guarantee, one CTA: Book the audit.
 */
get_header();
$book  = by_book_url();
$audit = $book . '?call=audit';
$price = by_price( 'audit_price', 'Priced on the call' );
$guar  = trim( (string) by_opt( 'guarantee_text' ) );
$work  = by_work_url();
?>
<main id="main">
  <section class="hero3 hero3--audit">
    <div class="wrap">
      <p class="eyebrow3"><?php echo esc_html( by_opt( 'audit_name' ) ); ?></p>
      <h1 class="hero3__h1 hero3__h1--page">Find out where your week <span class="u">goes.<?php echo by_scribble( 'underline' ); ?></span></h1>
      <div class="hero3__row">
        <p class="hero3__lead">One 90-minute session. A written report in five business days. Your biggest time drains costed in hours and dollars, and a fix plan with a price on every fix. For one-person studios through to national companies.</p>
        <div class="hero3__cta">
          <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
          <a href="#how" class="link-ink">How it works</a>
        </div>
      </div>
      <div class="auditp__price">
        <span class="auditp__amount"><?php echo esc_html( $price ); ?></span>
        <?php if ( $guar ) : ?><span class="auditp__guar hand"><?php echo esc_html( $guar ); ?></span><?php endif; ?>
      </div>
    </div>
  </section>

  <div class="ticker" aria-label="What the audit usually finds">
    <div class="ticker__track" id="ticker">
      <span class="ticker__item"><s>Chasing invoices</s></span>
      <span class="ticker__item"><s>Missed calls</s></span>
      <span class="ticker__item"><s>Quotes typed twice</s></span>
      <span class="ticker__item"><s>Booking by text</s></span>
      <span class="ticker__item"><s>Software nobody uses</s></span>
      <span class="ticker__item"><s>Friday admin</s></span>
    </div>
  </div>

  <!-- WHAT YOU GET + HOW IT WORKS (black) -->
  <section class="section3 section3--black" id="how">
    <div class="wrap auditb">
      <div class="auditb__left">
        <h2 class="auditb__h2">One conversation.<br>One report.<br>Your week back.</h2>
        <p class="auditb__price"><?php echo esc_html( $price ); ?></p>
        <?php if ( $guar ) : ?><p class="auditb__guarantee"><?php echo esc_html( $guar ); ?></p><?php endif; ?>
        <p class="auditb__label">What you get</p>
        <ul class="auditb__gets">
          <li>Your top five time drains, costed in hours and dollars</li>
          <li>A fix plan ranked by payback, with a price for each fix</li>
          <li>Quick wins you can make yourself, no build needed</li>
          <li>The written report, yours to keep whatever you decide</li>
        </ul>
        <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
      </div>
      <div class="auditb__right">
        <p class="auditb__hand"><span class="hand">About a week, start to finish.</span></p>
        <ol class="rows rows--light">
          <li class="row"><span class="row__num">01</span><div><strong>Book a time</strong><p>Pick a slot for your session. We send a short list of what to have handy, usually logins to look at and a rough picture of your week.</p></div></li>
          <li class="row"><span class="row__num">02</span><div><strong>A 90-minute session</strong><p>Online or on site. We walk through how work really moves: enquiries, quotes, bookings, invoices, follow-ups.</p></div></li>
          <li class="row"><span class="row__num">03</span><div><strong>Your report in 5 business days</strong><p>The time drains costed, the fixes ranked by payback, each one priced.</p></div></li>
          <li class="row"><span class="row__num">04</span><div><strong>A 30-minute walkthrough</strong><p>We go through it together. You decide what happens next, with us or without us.</p></div></li>
        </ol>
      </div>
    </div>
  </section>

  <?php if ( $guar ) : ?>
  <!-- THE GUARANTEE -->
  <section class="section3" id="guarantee">
    <div class="wrap teams">
      <h2 class="h3x"><?php echo esc_html( $guar ); ?></h2>
      <div>
        <p class="split__aside"><?php echo esc_html( by_guarantee_terms() ); ?></p>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- WHAT WE USUALLY FIX -->
  <?php $grid = by_jobs_grid( $audit ); if ( $grid ) : ?>
  <section class="section3 section3--stone" id="fixes">
    <div class="wrap">
      <div class="split split--tight">
        <h2 class="h3x">What we usually fix after an audit.</h2>
        <p class="split__aside">The report prices each fix. Build it with us, do it yourself, or leave it. These are typical starting prices.</p>
      </div>
      <?php echo $grid; // escaped in by_jobs_grid() ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- PROOF -->
  <section class="section3 section3--tight">
    <div class="wrap">
      <div class="split split--tight">
        <h2 class="h3x">Built, live, and still running.</h2>
        <a class="link-ink" href="<?php echo esc_url( $work ); ?>">See our work <span aria-hidden="true">→</span></a>
      </div>
      <p class="split__aside">An automated custom bike builder that feeds the CRM, one front door for a clinic's referrals, an artist's shop that sells while she paints, online enrolments across a national franchise.</p>
    </div>
  </section>

  <!-- FAQ -->
  <section class="section3 section3--tight" id="faq">
    <div class="wrap wrap--narrow">
      <p class="eyebrow3">Good questions</p>
      <details class="faqb" open>
        <summary>Who is the audit for?</summary>
        <p>Any business where admin is eating the week: sole traders, clinics, trades, shops, studios, and teams of 20 or more. For larger teams and multi-site businesses we scope a deeper review on the call.</p>
      </details>
      <details class="faqb">
        <summary>Do I need to understand AI?</summary>
        <p>Not at all. Plain English, and only tools that solve a clear problem. Most fixes connect and improve what you already use.</p>
      </details>
      <details class="faqb">
        <summary>Do I have to buy a build afterwards?</summary>
        <p>No. You keep the report and the quick wins either way. If you want us to build a fix, it's scoped and priced in writing first.</p>
      </details>
      <details class="faqb">
        <summary>What happens to my data?</summary>
        <p>It stays yours, in your own accounts. We only access what the job needs and never use it to train AI. <a href="<?php echo esc_url( by_privacy_url() ); ?>">Data and privacy</a>.</p>
      </details>
    </div>
  </section>

  <section class="close3">
    <div class="close3__grid close3__grid--solo">
      <div class="close3__text">
        <h2 class="close3__h2">Less time doing what you have to. More time doing what you <span class="u">love<?php echo by_scribble( 'circle' ); ?></span>.</h2>
        <div class="close3__cta">
          <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
          <a href="<?php echo esc_url( $book ); ?>" class="link-light">Or a free 20-minute call</a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer();
