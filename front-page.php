<?php
/**
 * Front page (v2.2.0): rebuilt to Christianna's homepage mockup (27 Oct 2026).
 * "The auditor's pen, in blue": B&W photos = the business, blue hand-drawn marks = the intervention, big type = the verdict.
 * One CTA verb everywhere: Book the audit. Prices and the proof numbers live in Appearance > Customize > Better Yet settings.
 */
get_header();
$book   = by_book_url();
$audit  = $book . '?call=audit';
$work   = by_work_url();
$price  = by_has( 'audit_price' ) ? 'From ' . by_opt( 'audit_price' ) : 'Priced on the call';
$credit = by_has( 'credit_text' ) ? by_opt( 'credit_text' ) : 'Fixed fee, agreed before we start. You keep the report either way.';
$where  = trim( (string) by_opt( 'location' ) );
?>
  <main id="main">

    <!-- HERO: the verdict -->
    <section class="hero3">
      <div class="wrap">
        <p class="eyebrow3">For trades, clinics, studios and shops</p>
        <h1 class="hero3__h1">Same work.<br>Better <span class="hero3__yet u"><span class="hand hand--yet">yet.</span><?php echo by_scribble( 'underline' ); ?></span></h1>
        <div class="hero3__row">
          <p class="hero3__lead">AI, automation and smarter systems for small businesses. It starts with a one-week audit of where your time actually goes.</p>
          <div class="hero3__cta">
            <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
            <a href="<?php echo esc_url( $work ); ?>" class="link-ink">See what we've built</a>
          </div>
        </div>
        <figure class="hero3__photo">
          <?php echo by_asset_img( 'ref-hero.jpg', 'Black and white portrait with a hand-drawn electric blue scribble', 'hero3__img', 'eager' ); ?>
        </figure>
      </div>
    </section>

    <!-- TICKER: the chores, struck out -->
    <div class="ticker" aria-label="The jobs we take off your plate">
      <div class="ticker__track" id="ticker">
        <span class="ticker__item"><s>Chasing invoices</s></span>
        <span class="ticker__item"><s>Retyping quotes into Xero</s></span>
        <span class="ticker__item"><s>Missed calls</s></span>
        <span class="ticker__item"><s>Booking by text</s></span>
        <span class="ticker__item"><s>Friday admin</s></span>
        <span class="ticker__item"><s>Double entry</s></span>
        <span class="ticker__item"><s>"Did you get my email?"</s></span>
        <span class="ticker__item"><s>Reminders by hand</s></span>
      </div>
    </div>

    <!-- PROOF STRIP -->
    <div class="wrap">
      <div class="proof">
        <span class="proof__label">Built for</span>
        <a href="<?php echo esc_url( $work . '#heiden' ); ?>">Heiden Cycle Works</a>
        <a href="<?php echo esc_url( $work . '#roam' ); ?>">Roam Orthotics</a>
        <a href="<?php echo esc_url( $work . '#stephanie' ); ?>">Stephanie Anne Studio</a>
        <a href="<?php echo esc_url( $work . '#rsgk' ); ?>">Ready Steady Go Kids</a>
        <a href="<?php echo esc_url( $work . '#damselfly' ); ?>">Damselfly</a>
        <?php if ( by_has( 'hours_back' ) ) : ?><span class="proof__stat"><?php echo esc_html( by_opt( 'hours_back' ) ); ?> hours handed back so far</span><?php endif; ?>
      </div>
    </div>

    <!-- YOUR WEEK, MARKED UP -->
    <section class="section3" id="markup">
      <div class="wrap">
        <div class="split">
          <h2 class="h3x">You already know what's slowing you down. We put a number on it.</h2>
          <p class="split__aside">Most of it hides in plain sight: the invoice book on the dash, the call you couldn't take, the quote you typed twice.</p>
        </div>
        <figure class="markup">
          <?php echo by_asset_img( 'ref-desk.jpg', 'Someone working at a desk, with hand-written notes marking where the time goes', 'markup__img' ); ?>
          <span class="markup__note markup__note--a"><span class="hand hand--light">Invoice chasing, 3 hrs/wk</span></span>
          <span class="markup__note markup__note--b"><span class="hand hand--light">Quotes typed twice</span></span>
          <span class="markup__note markup__note--c"><span class="hand hand--light">Missed calls, 9 a week</span></span>
          <?php echo str_replace( 'class="scribble ', 'class="markup__circle scribble ', by_scribble( 'circle' ) ); ?>
          <?php echo str_replace( 'class="scribble ', 'class="markup__arrow scribble ', by_scribble( 'arrow' ) ); ?>
          <figcaption>Illustrative annotations. Your audit puts real numbers on your own week.</figcaption>
        </figure>
      </div>
    </section>

    <!-- THE AUDIT: black block -->
    <section class="section3 section3--black" id="audit">
      <div class="wrap auditb">
        <div class="auditb__left">
          <p class="eyebrow3 eyebrow3--light"><?php echo esc_html( by_opt( 'audit_name' ) ); ?></p>
          <h2 class="auditb__h2">One conversation.<br>One report.<br>Your week back.</h2>
          <p class="auditb__price"><?php echo esc_html( $price ); ?></p>
          <p class="auditb__credit"><?php echo esc_html( $credit ); ?></p>
          <?php if ( by_has( 'guarantee_text' ) ) : ?><p class="auditb__credit"><?php echo esc_html( by_opt( 'guarantee_text' ) ); ?></p><?php endif; ?>
          <a href="<?php echo esc_url( $audit ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
        </div>
        <div class="auditb__right">
          <p class="auditb__hand"><span class="hand">Find it. Fix it. Keep it working.</span></p>
          <ol class="rows rows--light">
            <li class="row"><span class="row__num">01</span><div><strong>A 90-minute session</strong><p>We walk through how work really moves: enquiries, quotes, bookings, invoices.</p></div></li>
            <li class="row"><span class="row__num">02</span><div><strong>Your report in 5 business days</strong><p>Top five time drains, costed in hours and dollars. Fixes ranked by payback.</p></div></li>
            <li class="row"><span class="row__num">03</span><div><strong>A 30-minute walkthrough</strong><p>You decide what happens next. You keep the report either way.</p></div></li>
          </ol>
        </div>
      </div>
    </section>

    <!-- FIXES, PRICED -->
    <section class="section3" id="pricing">
      <div class="wrap">
        <div class="split split--tight">
          <h2 class="h3x">Fixes, priced.</h2>
          <p class="split__aside">Small jobs that pay for themselves. Built on the tools you already use.</p>
        </div>
        <ol class="fixes">
          <li class="fix">
            <span class="row__num">01</span>
            <h3>The First Fix</h3>
            <p class="fix__ba"><s>One workflow eating your week</s><span class="fix__after"><span aria-hidden="true">→</span> Built and running in two to three weeks</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'fix_price', 'Priced on the call' ) ); ?></span>
          </li>
          <li class="fix">
            <span class="row__num">02</span>
            <h3>The Missed-Call Catcher</h3>
            <p class="fix__ba"><s>Calls go to voicemail while you're on the tools</s><span class="fix__after"><span aria-hidden="true">→</span> Every missed call gets a text back in seconds</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'call_price', 'Priced on the call' ) ); ?></span>
          </li>
          <li class="fix">
            <span class="row__num">03</span>
            <h3>Keep It Working</h3>
            <p class="fix__ba"><s>Automations that quietly break when an app updates</s><span class="fix__after"><span aria-hidden="true">→</span> We watch it, fix it, and tweak it. Cancel any month</span></p>
            <span class="fix__price"><?php echo esc_html( by_price( 'plan_price', 'Priced on the call' ) ); ?></span>
          </li>
        </ol>
        <p class="fixes__foot">Bigger projects (connected systems, CRM, booking, reporting) are quoted from your audit<?php if ( by_has( 'project_price' ) ) echo ', ' . esc_html( by_opt( 'project_price' ) ); ?>.</p>
      </div>
    </section>

    <!-- CALCULATOR: blue block -->
    <section class="section3 section3--blue" id="calculator">
      <div class="wrap calcb">
        <div>
          <h2 class="calcb__h2">What's your Friday worth?</h2>
          <form class="calcb__form" id="calcForm" onsubmit="return false">
            <label for="hours"><span>Hours a week on admin and busywork</span><output id="hoursOut" for="hours">15</output>
              <input type="range" id="hours" name="hours" min="1" max="80" value="15" aria-describedby="hoursOut"></label>
            <label for="rate"><span>What an hour of that time costs</span><output id="rateOut" for="rate">$50</output>
              <input type="range" id="rate" name="rate" min="25" max="200" step="5" value="50" aria-describedby="rateOut"></label>
            <label for="share"><span>Share that could run itself</span><output id="shareOut" for="share">30%</output>
              <input type="range" id="share" name="share" min="10" max="60" step="5" value="30" aria-describedby="shareOut"></label>
          </form>
        </div>
        <div class="calcb__result" aria-live="polite">
          <p class="calcb__big"><span id="resHours">216</span><small>hours back a year</small></p>
          <p class="calcb__big"><span id="resDollars">$10,800</span><small>in time value a year</small></p>
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
              <input type="email" id="reportEmail" name="email" placeholder="you@business.com.au" required>
              <button type="submit" class="btn btn--light">Send</button>
            </div>
            <label class="calcb__consent"><input type="checkbox" name="consent" value="yes" required> <span>Send me my estimate and the occasional useful email. No spam, unsubscribe any time.</span></label>
            <p class="form__status form__status--dark" id="reportStatus" aria-live="polite"></p>
          </form>
          <p class="calcb__note">A rough estimate over 48 working weeks. Your audit gives the real numbers.</p>
        </div>
      </div>
    </section>

    <!-- WORK -->
    <section class="section3" id="work">
      <div class="wrap">
        <div class="split split--tight">
          <h2 class="h3x">Built, live, and still running.</h2>
          <a class="link-ink" href="<?php echo esc_url( $work ); ?>">All work <span aria-hidden="true">→</span></a>
        </div>
        <div class="workrow">
          <a class="wcase" href="<?php echo esc_url( $work . '#heiden' ); ?>">
            <img class="wcase__img" src="https://heiden.bike/wp-content/uploads/2026/08/heiden-strip-road-1-768x372.jpg" alt="Heiden custom road frame" loading="lazy">
            <span class="wcase__kicker">Custom bikes</span>
            <span class="wcase__title">Quoting a custom bike, without the founder.</span>
            <span class="wcase__proof"><strong>0</strong> emails before a rider sees their frame.</span>
          </a>
          <a class="wcase" href="<?php echo esc_url( $work . '#roam' ); ?>">
            <img class="wcase__img" src="https://roamorthotics.com.au/wp-content/uploads/2026/10/roam-K2-digital-workflow-768x326.jpg" alt="Roam Orthotics digital workflow" loading="lazy">
            <span class="wcase__kicker">Healthcare</span>
            <span class="wcase__title">One front door for every referral.</span>
            <span class="wcase__proof"><?php echo esc_html( by_price( 'proof_roam', 'Enquiries, NDIS referrals and scans, in one place.' ) ); ?></span>
          </a>
          <a class="wcase" href="<?php echo esc_url( $work . '#stephanie' ); ?>">
            <img class="wcase__img" src="https://stephanieannestudio.com/wp-content/uploads/2026/10/BlueReverie_WebFile-600x849.jpg" alt="Blue Reverie by Stephanie Anne" loading="lazy">
            <span class="wcase__kicker">Artist</span>
            <span class="wcase__title">Sells prints while she paints.</span>
            <span class="wcase__proof"><?php echo esc_html( by_price( 'proof_steph', 'Originals and prints sold without a single invoice typed.' ) ); ?></span>
          </a>
        </div>
      </div>
    </section>

    <!-- AI FOR PEOPLE WHO DON'T LOVE AI: stone block -->
    <section class="section3 section3--stone" id="who">
      <div class="wrap forwho">
        <div>
          <h2 class="h3x">AI for people who don't love AI.</h2>
          <p class="forwho__label">Not this</p>
          <p class="forwho__not"><s>"Leveraging cutting-edge AI solutions to optimise operational efficiencies."</s></p>
          <p class="forwho__label">More this</p>
          <p class="forwho__more"><span class="hand hand--line">Your business, minus the busywork.</span></p>
        </div>
        <ul class="forwho__list">
          <li><a href="<?php echo esc_url( $audit ); ?>">Trades <span aria-hidden="true">→</span></a></li>
          <li><a href="<?php echo esc_url( $audit ); ?>">Clinics <span aria-hidden="true">→</span></a></li>
          <li><a href="<?php echo esc_url( $audit ); ?>">Creatives <span aria-hidden="true">→</span></a></li>
          <li><a href="<?php echo esc_url( $audit ); ?>">Shops <span aria-hidden="true">→</span></a></li>
        </ul>
      </div>
    </section>

    <!-- ABOUT + FAQ -->
    <section class="section3" id="about">
      <div class="wrap aboutb">
        <div class="aboutb__main">
          <h2 class="h3x">The robots aren't taking over the world. Just the work you don't want to do.</h2>
          <p class="aboutb__line"><?php echo $where ? esc_html( $where ) . '-based, working Australia-wide. ' : 'Working with businesses Australia-wide. '; ?>You deal with us, not a sales team.</p>
          <div class="founders">
            <div class="founder">
              <?php echo by_asset_img( 'founder-christianna.jpg', 'Christianna, co-founder of Better Yet', 'founder__img founder__img--head' ); ?>
              <strong>Christianna</strong>
              <span>Brand, marketing, ads and growth.</span>
            </div>
            <div class="founder">
              <?php echo by_asset_img( 'founder-rob.jpg', 'Robert, co-founder of Better Yet', 'founder__img founder__img--head' ); ?>
              <strong>Robert</strong>
              <span>AI tools, CRM, integrations and builds.</span>
            </div>
            <div class="founder">
              <?php echo by_asset_img( 'founders-together.jpg', 'Christianna and Robert working at a table', 'founder__img' ); ?>
              <strong>The studio</strong>
              <span><?php echo $where ? esc_html( $where ) . '-based, working' : 'Working'; ?> Australia-wide.</span>
            </div>
          </div>
        </div>
        <div class="aboutb__faq" id="faq">
          <p class="eyebrow3">Good questions</p>
          <details class="faqb" open>
            <summary>Do I need to understand AI?</summary>
            <p>Not at all. That's the point. Plain English, and only tools that solve a clear problem.</p>
          </details>
          <details class="faqb">
            <summary>Will I have to replace my software?</summary>
            <p>Usually not. We connect and improve what you already use.</p>
          </details>
          <details class="faqb">
            <summary>Is my data used to train AI?</summary>
            <p>No. A person checks anything uncertain, and you own everything we build, including the logins.</p>
          </details>
          <details class="faqb">
            <summary>What does the audit cost?</summary>
            <p><?php echo esc_html( $price ); ?>. <?php echo esc_html( $credit ); ?></p>
          </details>
          <details class="faqb">
            <summary>How long does it take?</summary>
            <p>About a week: a 90-minute session, your report within five business days, then a 30-minute walkthrough.</p>
          </details>
          <details class="faqb">
            <summary>Do you work outside <?php echo $where ? esc_html( $where ) : 'your city'; ?>?</summary>
            <p>Yes. Most of the work happens online, with on-site visits where they help.</p>
          </details>
        </div>
      </div>
    </section>

    <!-- CLOSING CTA: black block -->
    <section class="close3">
      <div class="close3__grid">
        <div class="close3__text">
          <h2 class="close3__h2">Less time doing what you have to. More time doing what you <span class="u">love<?php echo by_scribble( 'circle' ); ?></span>.</h2>
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
