<?php
/**
 * Tradies landing page (v2.5.0-trades, 16 Nov 2026): /tradies/
 * Rob's brief: carpenters, plumbers, sparkies and builders; sole traders and small crews buried in paperwork
 * who can't afford (or can't see the value in) an admin hire. Casual tone. No tradie case studies yet, so no proof claims.
 * Offer: everything on the home page plus "AI admin and follow-up" for a small monthly fee (Customize > Better Yet settings > Tradie AI admin price).
 */
get_header();
$book   = by_book_url();
$audit  = $book . '?call=audit';
$price  = by_price( 'audit_price', 'Priced on the call' );
$guar   = trim( (string) by_opt( 'guarantee_text' ) );
$admin  = by_price( 'tradie_admin_price', 'Low monthly fee' );
$admin_inline = by_has( 'tradie_admin_price' ) ? $admin : 'a low monthly fee';
?>
  <main id="main">

    <!-- HERO -->
    <section class="hero3 hero3--trades">
      <div class="wrap">
        <p class="eyebrow3">For carpenters, plumbers, sparkies and builders.</p>
        <h1 class="hero3__h1">On the tools.<br>Not on the <span class="hero3__yet u">paperwork<?php echo by_scribble( 'underline' ); ?></span>.</h1>
        <div class="hero3__row">
          <p class="hero3__lead">Quotes, invoices, missed calls and follow-ups, sorted by systems that run while you work. No admin to hire, no new software to learn, and no more Sunday nights at the kitchen table.</p>
          <div class="hero3__cta">
            <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
            <a href="#ai-admin" class="link-ink">See the AI admin</a>
          </div>
        </div>
        <?php if ( $guar ) : ?><p class="hero3__guarantee"><span class="hand"><?php echo esc_html( $guar ); ?></span></p><?php endif; ?>
      </div>
    </section>

    <!-- TICKER -->
    <div class="ticker" aria-label="The jobs we take off your plate">
      <div class="ticker__track" id="ticker">
        <span class="ticker__item"><s>Quotes at 9pm</s></span>
        <span class="ticker__item"><s>Missed calls up a ladder</s></span>
        <span class="ticker__item"><s>Chasing invoices</s></span>
        <span class="ticker__item"><s>Receipts in the ute</s></span>
        <span class="ticker__item"><s>"Just following up on that quote"</s></span>
        <span class="ticker__item"><s>Job notes on scraps of paper</s></span>
        <span class="ticker__item"><s>Booking by text</s></span>
        <span class="ticker__item"><s>Sunday paperwork</s></span>
      </div>
    </div>

    <!-- SOUND FAMILIAR: per trade -->
    <section class="section3" id="trades">
      <div class="wrap">
        <div class="split split--tight">
          <h2 class="h3x">Sound familiar?</h2>
          <p class="split__aside">You got into the trade to build things and fix things, not to do data entry. Here's where the paperwork usually bites, and what we do about it.</p>
        </div>
        <ol class="fixes">
          <li class="fix">
            <span class="row__num">01</span>
            <h3>Carpenters</h3>
            <p class="fix__ba"><s>Measuring up on Tuesday, typing the quote on Friday, and the customer's gone with someone else</s><span class="fix__after"><span aria-hidden="true">→</span> Quote templates you fill in on your phone on site, sent before you've packed up, with an automatic nudge if they go quiet</span></p>
          </li>
          <li class="fix">
            <span class="row__num">02</span>
            <h3>Plumbers</h3>
            <p class="fix__ba"><s>Phone ringing under a sink, and that missed call was a burst pipe job</s><span class="fix__after"><span aria-hidden="true">→</span> Every missed call gets a text back in seconds, asks what the job is, and books it in or flags it as urgent</span></p>
          </li>
          <li class="fix">
            <span class="row__num">03</span>
            <h3>Sparkies</h3>
            <p class="fix__ba"><s>Certificates, compliance paperwork and photos scattered across your phone</s><span class="fix__after"><span aria-hidden="true">→</span> Job photos, notes and paperwork filed against the job automatically, ready when the customer or inspector asks</span></p>
          </li>
          <li class="fix">
            <span class="row__num">04</span>
            <h3>Builders</h3>
            <p class="fix__ba"><s>Variations on a text thread, subbies to chase and progress claims done by hand</s><span class="fix__after"><span aria-hidden="true">→</span> Variations captured and signed off in writing, subbies reminded automatically, progress claims drafted from the job itself</span></p>
          </li>
        </ol>
      </div>
    </section>

    <!-- AI ADMIN: black block -->
    <section class="section3 section3--black" id="ai-admin">
      <div class="wrap auditb">
        <div class="auditb__left">
          <p class="eyebrow3 eyebrow3--light">AI admin and follow-up</p>
          <h2 class="auditb__h2">The admin person you didn't have to hire.</h2>
          <p class="auditb__price"><?php echo esc_html( $admin ); ?></p>
          <p class="auditb__credit">We set it up on the tools you already use, then keep it running. A real person (us) checks in every month.</p>
          <p class="auditb__label">What it handles</p>
          <ul class="auditb__gets">
            <li>Texts back every missed call and books the job in</li>
            <li>Follows up quotes that haven't been answered</li>
            <li>Sends invoice reminders, so you're not the one chasing</li>
            <li>Confirms bookings and reminds customers the day before</li>
            <li>Asks happy customers for a Google review after the job</li>
            <li>Sends you a short weekly summary: jobs won, money owed, who to call</li>
          </ul>
          <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
        </div>
        <div class="auditb__right">
          <p class="auditb__hand"><span class="hand">Hire an admin, or don't.</span></p>
          <ol class="rows rows--light">
            <li class="row"><span class="row__num">A</span><div><strong>A part-time admin</strong><p>Wages, super, a desk, sick days and training. Worth it for some, but a big jump for a one-person outfit or a small crew.</p></div></li>
            <li class="row"><span class="row__num">B</span><div><strong>Doing it yourself</strong><p>Free on paper. Costs you nights, weekends, and the jobs that slip through while you're on the tools.</p></div></li>
            <li class="row"><span class="row__num">C</span><div><strong>AI admin from Better Yet</strong><p>The repetitive stuff runs itself for <?php echo esc_html( $admin_inline ); ?>. You stay in charge of the bits that need a human.</p></div></li>
          </ol>
        </div>
      </div>
    </section>

    <!-- CALCULATOR: blue block, tradie defaults -->
    <section class="section3 section3--blue" id="calculator">
      <div class="wrap calcb">
        <div>
          <h2 class="calcb__h2">What's your Sunday worth?</h2>
          <form class="calcb__form" id="calcForm" onsubmit="return false">
            <label for="people"><span>People in the business doing paperwork</span><output id="peopleOut" for="people">1</output>
              <input type="range" id="people" name="people" min="1" max="20" value="1" aria-describedby="peopleOut"></label>
            <label for="hours"><span>Hours a week each on quotes, invoices and admin</span><output id="hoursOut" for="hours">8</output>
              <input type="range" id="hours" name="hours" min="1" max="30" value="8" aria-describedby="hoursOut"></label>
            <label for="rate"><span>Your hourly rate on the tools</span><output id="rateOut" for="rate">$90</output>
              <input type="range" id="rate" name="rate" min="40" max="200" step="5" value="90" aria-describedby="rateOut"></label>
            <label for="share"><span>Share that could run itself</span><output id="shareOut" for="share">40%</output>
              <input type="range" id="share" name="share" min="10" max="60" step="5" value="40" aria-describedby="shareOut"></label>
          </form>
        </div>
        <div class="calcb__result" aria-live="polite">
          <p class="calcb__big"><span id="resHours">154</span><small>estimated hours back a year</small></p>
          <p class="calcb__big"><span id="resDollars">$13,824</span><small>estimated value of that time a year</small></p>
          <div class="calcb__actions">
            <a href="<?php echo esc_url( $audit ); ?>" class="btn btn--light js-book">Book the audit <span aria-hidden="true">→</span></a>
            <button type="button" class="link-light calcb__toggle" id="estimateToggle" aria-expanded="false" aria-controls="reportForm">Email me this estimate</button>
          </div>
          <form class="calcb__capture" id="reportForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate hidden>
            <input type="hidden" name="action" value="by_enquiry">
            <input type="hidden" name="kind" value="report">
            <input type="hidden" name="calc_estimate" id="calcEstimateReport" value="">
            <input type="hidden" name="by_nonce" value="<?php echo esc_attr( wp_create_nonce( 'by_enquiry' ) ); ?>">
            <input type="text" name="website" tabindex="-1" autocomplete="off" class="hp" aria-hidden="true">
            <div class="calcb__capture-row">
              <label class="sr" for="reportEmail">Your email</label>
              <input type="email" id="reportEmail" name="email" placeholder="you@yourbusiness.com.au" required>
              <button type="submit" class="btn btn--light">Send</button>
            </div>
            <label class="calcb__consent"><input type="checkbox" name="consent" value="yes" required> <span>Send me my estimate and the occasional useful email. No spam, unsubscribe any time.</span></label>
            <p class="form__status form__status--dark" id="reportStatus" aria-live="polite"></p>
          </form>
          <p class="calcb__note">An estimate, not a quote: people × hours a week × the share that could run itself × 48 working weeks, valued at your hourly rate. Every hour off the paperwork is an hour you can bill, or an hour at home.</p>
        </div>
      </div>
    </section>

    <!-- EVERYTHING ELSE -->
    <section class="section3" id="pricing">
      <div class="wrap">
        <div class="split split--tight">
          <h2 class="h3x">Need more than admin?</h2>
          <p class="split__aside">Everything we do for other businesses, we do for tradies too. Prices up front.</p>
        </div>
        <ol class="fixes">
          <li class="fix">
            <span class="row__num">01</span>
            <h3><?php echo esc_html( by_opt( 'audit_name' ) ); ?></h3>
            <p class="fix__ba"><s>A gut feeling that the paperwork's eating your week</s><span class="fix__after"><span aria-hidden="true">→</span> A 90-minute chat, then a written report showing where your hours go and what to fix first, with prices</span></p>
            <span class="fix__price"><?php echo esc_html( $price ); ?></span>
          </li>
          <li class="fix">
            <span class="row__num">02</span>
            <h3>Concierge Essentials</h3>
            <p class="fix__ba"><s>A website nobody looks after</s><span class="fix__after"><span aria-hidden="true">→</span> Hosting, updates, backups and security, plus up to 2 hours of changes a month</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'essentials_price', 'Priced on the call' ) ); ?></span>
          </li>
          <li class="fix">
            <span class="row__num">03</span>
            <h3>Concierge Growth</h3>
            <p class="fix__ba"><s>Systems that drift out of date as the crew grows</s><span class="fix__after"><span aria-hidden="true">→</span> Everything in Essentials, plus about 10 hours a month improving your systems and a monthly check-in</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'growth_price', 'Priced on the call' ) ); ?></span>
          </li>
          <li class="fix">
            <span class="row__num">04</span>
            <h3>Custom apps and integrations</h3>
            <p class="fix__ba"><s>Typing the same job into three different apps</s><span class="fix__after"><span aria-hidden="true">→</span> Your job app, Xero, calendar and website talking to each other, or a custom tool built for how you work</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'app_price', 'Priced on the call' ) ); ?></span>
          </li>
        </ol>
        <p class="fixes__foot">Every build is scoped and priced in writing before it starts.</p>
      </div>
    </section>

    <!-- FAQ -->
    <section class="section3 section3--stone" id="faq">
      <div class="wrap forwho">
        <div>
          <h2 class="h3x">Straight answers.</h2>
          <p class="forwho__label">Not this</p>
          <p class="forwho__not"><s>"Digitally transforming your trade business with AI-powered workflows."</s></p>
          <p class="forwho__label">More this</p>
          <p class="forwho__more"><span class="hand hand--line">Less paperwork. More knock-off time.</span></p>
        </div>
        <div class="aboutb__faq">
          <details class="faqb" open>
            <summary>I'm not great with computers. Is that a problem?</summary>
            <p>Not at all. We set it all up and look after it. If you can send a text, you can use it.</p>
          </details>
          <details class="faqb">
            <summary>Do I have to change my job app or accounting software?</summary>
            <p>Usually not. We work with what you've already got, whether that's ServiceM8, Tradify, Fergus, simPRO, Xero, MYOB, or a notebook and a phone.</p>
          </details>
          <details class="faqb">
            <summary>Will my customers be talking to a robot?</summary>
            <p>Only for the boring bits, like "got your message, when suits?" or "reminder: we're there at 8am tomorrow". Anything that needs you comes straight to you.</p>
          </details>
          <details class="faqb">
            <summary>I'm a one-person business. Is this for me?</summary>
            <p>That's exactly who it's for. When you're the only one on the tools, every hour on paperwork is an hour you're not earning.</p>
          </details>
          <details class="faqb">
            <summary>What does it cost?</summary>
            <p>AI admin and follow-up is <?php echo esc_html( $admin_inline ); ?>. If you want us to dig into the whole business first, the audit is <?php echo esc_html( $price ); ?>.<?php if ( $guar ) echo ' ' . esc_html( $guar ); ?></p>
          </details>
        </div>
      </div>
    </section>

    <!-- CLOSING CTA -->
    <section class="close3">
      <div class="close3__grid">
        <div class="close3__text">
          <h2 class="close3__h2">Less time on the paperwork. More time on the <span class="u">tools<?php echo by_scribble( 'circle' ); ?></span>. Or the couch.</h2>
          <div class="close3__cta">
            <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
            <a href="<?php echo esc_url( $book ); ?>" class="link-light">Or a free 20-minute call</a>
          </div>
        </div>
        <figure class="close3__photo">
          <?php echo by_asset_img( 'ref-scribble-banner.jpg', 'Hand-drawn electric blue scribble', 'close3__img' ); ?>
        </figure>
      </div>
    </section>
  </main>
<?php get_footer();
