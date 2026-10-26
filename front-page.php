<?php
/* Front page: the one-page Better Yet site. Copy follows the brand deck (October 2026). Settings are in Appearance > Customize > Better Yet settings. */
get_header(); ?>
  <main id="main">
    <!-- HERO -->
    <section class="hero">
      <div class="wrap">
        <?php echo str_replace( 'class="scribble ', 'class="hero__loop scribble ', by_scribble( 'loop' ) ); ?>
        <div class="hero__grid">
          <div>
            <p class="eyebrow">The human-first AI agency</p>
            <h1>Same work.<br><span class="u">A better<?php echo by_scribble( 'underline' ); ?></span> way.</h1>
            <p class="lead">We find where your business is losing time and money, then put practical, smarter systems in place to fix it. Not AI for the sake of AI. Time back for the people doing the work.</p>
            <div class="hero__cta">
              <a href="#audit" class="btn">Start with the audit <span aria-hidden="true">→</span></a>
              <a href="#calculator" class="btn btn--ghost">Buy back your time</a>
            </div>
            <p class="note hero__note"><span class="hand">Fix what slows you down.</span><?php echo by_scribble( 'arrow' ); ?></p>
          </div>
          <div class="hero__card" aria-hidden="true">
            <p class="hero__card-label">A Friday, after</p>
            <p class="hero__card-head">Make work <span class="u">work<?php echo by_scribble( 'circle' ); ?></span> better.</p>
            <div class="flow">
              <div class="flow__row"><span class="dot"></span>Invoices sent and chased</div>
              <div class="flow__line"></div>
              <div class="flow__row"><span class="dot"></span>Every enquiry answered</div>
              <div class="flow__line"></div>
              <div class="flow__row"><span class="dot"></span>Next week's jobs booked</div>
              <div class="flow__line"></div>
              <div class="flow__row"><span class="dot"></span>You, finishing early</div>
            </div>
            <div class="hero__stat"><span class="hero__stat-num">0</span> hours of busywork</div>
          </div>
        </div>
        <?php if ( by_img( 'hf-01' ) ) : ?>
        <div class="hero__strip hero__strip--home" aria-hidden="true">
          <?php echo by_photo( 'hf-01', '', '', 'eager' ); echo by_photo( 'hf-02', '', '', 'eager' ); echo by_photo( 'hf-03', '', '', 'eager' ); ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- THE IDEA -->
    <section class="section section--tight">
      <div class="wrap">
        <p class="eyebrow">The idea</p>
        <h2 class="h2">Less manual. <span class="u">More meaningful.<?php echo by_scribble( 'underline' ); ?></span></h2>
        <div class="problems">
          <article class="problem">
            <p class="problem__kicker">The commercial value</p>
            <p class="problem__num">Save time. Reduce costs. Grow.</p>
            <p>Less time on admin, invoicing, follow-up and double entry means lower costs and more capacity to take on the work that pays.</p>
          </article>
          <article class="problem">
            <p class="problem__kicker">The human value</p>
            <p class="problem__num">More time for work and life you love.</p>
            <p>Less time doing what you have to. More time doing what you love. That's the whole point.</p>
          </article>
        </div>
        <p class="statement">Still spending Fridays chasing invoices? <em>There's a better way.</em></p>
        <p class="note"><span class="hand hand--sm">Technology should give you more time to be human.</span></p>
      </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="section section--alt" id="how">
      <div class="wrap">
        <p class="eyebrow">How it works</p>
        <h2 class="h2">Find it. Fix it. <span class="u">Keep it working.<?php echo by_scribble( 'underline' ); ?></span></h2>
        <ol class="steps">
          <li class="step">
            <span class="step__num">01</span>
            <h3>Audit</h3>
            <p>We find the wasted time, costs and missed opportunities in how your business runs today.</p>
            <span class="tag">One-off fee</span>
          </li>
          <li class="step">
            <span class="step__num">02</span>
            <h3>Prescribe</h3>
            <p>A plain-English plan: what to fix first, what it costs, what it gives back, and what to leave alone.</p>
            <span class="tag">In the report</span>
          </li>
          <li class="step">
            <span class="step__num">03</span>
            <h3>Implement</h3>
            <p>We put smarter systems in place: connected apps, automatic follow-up, booking, quoting and the reporting you actually need.</p>
            <span class="tag">Fixed price</span>
          </li>
          <li class="step">
            <span class="step__num">04</span>
            <h3>Manage</h3>
            <p>We keep it working, improve it and support you over time, so you get on with the business.</p>
            <span class="tag">Monthly plan</span>
          </li>
        </ol>
        <p class="complementary"><strong>Complementary services:</strong> digital ads &middot; CRM &middot; lead generation &middot; websites &middot; SEO</p>
      </div>
    </section>

    <!-- THE AUDIT (productised, v1.5.0) -->
    <section class="section" id="audit">
      <div class="wrap">
        <p class="eyebrow">Start here</p>
        <h2 class="h2"><?php echo esc_html( by_opt( 'audit_name' ) ); ?></h2>
        <p class="lead">One conversation, one report, one clear next step. You find out exactly where your week goes and what it would take to get it back, in plain English, with numbers.</p>
        <div class="audit">
          <div class="audit__main">
            <ol class="audit__timeline">
              <li><span class="audit__when">Day 1</span><strong>A 60 to 90-minute session.</strong> We walk through how work actually moves through your business: enquiries, quotes, bookings, invoices, the follow-ups that slip.</li>
              <li><span class="audit__when">Within 5 business days</span><strong>Your Time-Back Report.</strong> Short, specific and written for you, not for a software vendor.</li>
              <li><span class="audit__when">Then</span><strong>A 30-minute walkthrough.</strong> We go through it together and you decide what, if anything, happens next.</li>
            </ol>
            <h3 class="audit__h3">What's in the report</h3>
            <ul class="audit__list">
              <li>Your top five time drains, each costed in hours and dollars a year</li>
              <li>The fixes, ranked by payback, including the ones not worth doing</li>
              <li>The tools involved and what they cost to run, with no surprises</li>
              <li>A fixed price and timeline for the first fix</li>
            </ul>
            <p class="audit__keep">You keep the report either way. Plenty of owners use it to fix things themselves, and that's fine by us.</p>
          </div>
          <aside class="audit__card">
            <p class="audit__price-label">Investment</p>
            <p class="audit__price"><?php echo esc_html( by_price( 'audit_price' ) ); ?></p>
            <?php if ( by_has( 'audit_founding' ) ) : ?><p class="audit__founding"><?php echo esc_html( by_opt( 'audit_founding' ) ); ?></p><?php endif; ?>
            <?php if ( by_has( 'credit_text' ) || by_has( 'guarantee_text' ) ) : ?>
            <ul class="audit__promises">
              <?php if ( by_has( 'credit_text' ) ) : ?><li><?php echo esc_html( by_opt( 'credit_text' ) ); ?></li><?php endif; ?>
              <?php if ( by_has( 'guarantee_text' ) ) : ?><li><?php echo esc_html( by_opt( 'guarantee_text' ) ); ?></li><?php endif; ?>
            </ul>
            <?php endif; ?>
            <a href="#contact" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
            <p class="audit__small">Not sure yet? Start with a free 20-minute discovery call.</p>
          </aside>
        </div>
      </div>
    </section>

    <!-- READY-MADE FIXES (v1.5.0) -->
    <section class="section section--alt" id="fixes">
      <div class="wrap">
        <p class="eyebrow">Ready-made fixes</p>
        <h2 class="h2">Smart systems. <span class="u">Real results.<?php echo by_scribble( 'underline' ); ?></span></h2>
        <p class="note"><span class="hand hand--sm">Small, fixed-price jobs that pay for themselves.</span></p>
        <p class="lead">You don't have to start with a big project. These are the fixes we're asked for most, scoped and priced up front.</p>
        <div class="packages">
          <article class="package">
            <p class="package__kicker">Most popular first step</p>
            <h3>The First Fix</h3>
            <p>One workflow, built and running in two to three weeks. Invoice chasing, enquiry follow-up, quote-to-job handover, appointment reminders: pick the one that hurts most.</p>
            <p class="package__price"><?php echo esc_html( by_price( 'fix_price' ) ); ?></p>
            <ul class="package__list"><li>Scoped from your audit or a short call</li><li>Built on the tools you already use</li><li>Handover and a written how-it-works</li></ul>
          </article>
          <article class="package">
            <p class="package__kicker">Trades and clinics</p>
            <h3>The Missed-Call Catcher</h3>
            <p>Every call you can't answer gets a text back within seconds, the caller can book or leave their details, and the lead lands in your CRM with a reminder to follow up.</p>
            <p class="package__price"><?php echo esc_html( by_price( 'call_price' ) ); ?></p>
            <ul class="package__list"><li>Works with your existing number</li><li>Optional AI receptionist that answers and books</li><li>Every call logged, nothing lost</li></ul>
          </article>
          <article class="package">
            <p class="package__kicker">After the build</p>
            <h3>Keep It Working</h3>
            <p>A small monthly plan for one or two automations: monitoring, fixes when a tool changes, and the small tweaks you think of once it's live. For businesses that don't need a full retainer.</p>
            <p class="package__price"><?php echo esc_html( by_price( 'plan_price' ) ); ?></p>
            <ul class="package__list"><li>We watch it so you don't have to</li><li>Changes turned around in days</li><li>Cancel any month</li></ul>
          </article>
        </div>
        <p class="complementary"><strong>Bigger projects</strong> (connected systems, CRM, booking, quoting, reporting) are quoted from your audit, <?php echo esc_html( by_price( 'project_price', 'typically from a few thousand dollars' ) ); ?>. Ongoing management is available on a monthly retainer.</p>
      </div>
    </section>

    <!-- THE DIFFERENCE -->
    <section class="section" id="services">
      <div class="wrap difference">
        <div>
          <p class="eyebrow">The difference</p>
          <h2 class="h2">AI for people who don't love AI.</h2>
          <p class="lead">No tech jargon. No unnecessary tools. No pressure to become an expert. We lead with the problem, not the technology, and you stay in control.</p>
        </div>
        <ul class="nots">
          <li><strong>Not this:</strong> "Leveraging cutting-edge AI solutions to optimise operational efficiencies."</li>
          <li><strong>More this:</strong> "Your business, minus the busywork."</li>
        </ul>
      </div>
    </section>

    <!-- CALCULATOR -->
    <section class="section section--dark" id="calculator">
      <div class="wrap calc">
        <div>
          <p class="eyebrow eyebrow--light">Time-back calculator</p>
          <h2 class="h2">Buy back <span class="u">your time.<?php echo by_scribble( 'underline' ); ?></span></h2>
          <p class="note"><span class="hand hand--light">Do the maths →</span></p>
          <p class="muted-light">A rough estimate based on handing over part of your repetitive admin. Your audit gives you the real numbers.</p>
          <form class="calc__form" id="calcForm" onsubmit="return false">
            <label>Hours a week spent on admin and busywork
              <output id="hoursOut">15</output>
              <input type="range" id="hours" min="1" max="80" value="15">
            </label>
            <label>What an hour of that time costs ($)
              <output id="rateOut">$50</output>
              <input type="range" id="rate" min="25" max="200" step="5" value="50">
            </label>
            <label>Share that could realistically run itself
              <output id="shareOut">30%</output>
              <input type="range" id="share" min="10" max="60" step="5" value="30">
            </label>
          </form>
        </div>
        <div class="calc__result" aria-live="polite">
          <div class="calc__big"><span id="resHours">216</span><small>hours back a year</small></div>
          <div class="calc__big"><span id="resDollars">$10,800</span><small>in time value a year</small></div>
          <form class="calc__capture" id="reportForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
            <input type="hidden" name="action" value="by_enquiry">
            <input type="hidden" name="kind" value="report">
            <input type="hidden" name="calc_estimate" id="calcEstimateReport" value="">
            <input type="hidden" name="by_nonce" value="<?php echo esc_attr( wp_create_nonce( 'by_enquiry' ) ); ?>">
            <input type="text" name="website" tabindex="-1" autocomplete="off" class="hp" aria-hidden="true">
            <label class="calc__capture-label" for="reportEmail">Want this as a personalised time-back report?</label>
            <div class="calc__capture-row">
              <input type="email" id="reportEmail" name="email" placeholder="you@business.com.au" required>
              <button type="submit" class="btn btn--light">Email it to me</button>
            </div>
            <label class="calc__consent"><input type="checkbox" name="consent" value="yes" required> <span>Send me my estimate and the occasional useful email. No spam, unsubscribe any time.</span></label>
            <p class="form__status form__status--dark" id="reportStatus" aria-live="polite"></p>
          </form>
          <a href="#contact" class="link-light" id="calcCta">Or talk to us about it <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </section>

    <!-- THE CUSTOMERS -->
    <section class="section" id="who">
      <div class="wrap">
        <p class="eyebrow">Who we help</p>
        <h2 class="h2">Different businesses. <span class="u">Same feeling.<?php echo by_scribble( 'underline' ); ?></span></h2>
        <div class="customers">
          <article class="customer"><?php echo by_photo( 'hf-05', 'An artist checking orders on a laptop in her studio', 'customer__img customer__img--sq' ); ?><p class="customer__kicker">Artists</p><p class="customer__line">More creating.<br>Less invoicing.</p></article>
          <article class="customer"><?php echo by_photo( 'hf-06', 'A cafe owner reading a tablet at the coffee machine', 'customer__img customer__img--sq' ); ?><p class="customer__kicker">Small business</p><p class="customer__line">Less admin.<br>More growing.</p></article>
          <article class="customer"><?php echo by_photo( 'hf-07', 'A physio writing notes between patients', 'customer__img customer__img--sq' ); ?><p class="customer__kicker">Healthcare</p><p class="customer__line">More patients.<br>Less paperwork.</p></article>
          <article class="customer"><?php echo by_photo( 'hf-08', 'An electrician on a ladder with an apprentice below', 'customer__img customer__img--sq' ); ?><p class="customer__kicker">Trades</p><p class="customer__line">More tools.<br>Less chasing invoices.</p></article>
        </div>
        <p class="tools"><span class="tools__label">Works with the tools you already use:</span> Xero &middot; MYOB &middot; ServiceM8 &middot; Tradify &middot; Cliniko &middot; Halaxy &middot; Shopify &middot; WooCommerce &middot; HubSpot &middot; Google Workspace &middot; Microsoft 365 &middot; and most things with an app</p>
      </div>
    </section>

    <!-- RECENT WORK -->
    <section class="section section--tight work-teaser">
      <div class="wrap">
        <p class="eyebrow">Recent work</p>
        <h2 class="h2">Set up, streamlined, and running themselves.</h2>
        <div class="customers">
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#heiden' ); ?>"><img class="customer__img" src="https://heiden.bike/wp-content/uploads/2026/08/heiden-strip-road-1-768x372.jpg" alt="Heiden custom road frame" loading="lazy"><p class="customer__kicker">Custom bikes</p><p class="customer__line">Heiden Cycle Works</p><p class="customer__meta">An automated bike builder: geometry, 3D render and deposit, all before the first email.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#roam' ); ?>"><img class="customer__img" src="https://roamorthotics.com.au/wp-content/uploads/2026/10/roam-K2-digital-workflow-768x326.jpg" alt="Roam Orthotics digital workflow" loading="lazy"><p class="customer__kicker">Healthcare</p><p class="customer__line">Roam Orthotics</p><p class="customer__meta">One front door for enquiries, NDIS referrals and a scan-to-print workflow.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#stephanie' ); ?>"><img class="customer__img" src="https://stephanieannestudio.com/wp-content/uploads/2026/10/BlueReverie_WebFile-600x849.jpg" alt="Blue Reverie by Stephanie Anne" loading="lazy"><p class="customer__kicker">Artist</p><p class="customer__line">Stephanie Anne Studio</p><p class="customer__meta">An online studio that sells originals and prints while she paints.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#rsgk' ); ?>"><img class="customer__img" src="https://www.readysteadygokids.com.au/img/children.png" alt="Ready Steady Go Kids class" loading="lazy"><p class="customer__kicker">Kids' sport</p><p class="customer__line">Ready Steady Go Kids</p><p class="customer__meta">Enrolments, free trials and franchise enquiries for 190+ locations, running from one system.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#damselfly' ); ?>"><img class="customer__img" src="https://www.damselfly.com.au/cdn/shop/files/1_2ca14e82-2b74-47b3-850e-7ed88e0cf25a_x800.png?v=1776925121" alt="Damselfly custom candles" loading="lazy"><p class="customer__kicker">Lifestyle brand</p><p class="customer__line">Damselfly</p><p class="customer__meta">A store that builds custom candles and sells in three currencies while the founder makes the next batch.</p></a>
        </div>
        <p class="work-teaser__more"><a href="<?php echo esc_url( by_work_url() ); ?>">See the full case studies <span aria-hidden="true">→</span></a></p>
      </div>
    </section>

    <!-- ABOUT -->
    <section class="section section--alt" id="about">
      <div class="wrap about">
        <div>
          <p class="eyebrow">About</p>
          <h2 class="h2">The robots aren't taking over the world. Just the work you don't want to do.</h2>
          <p>We're Christianna and Robert. Between us we cover the two halves most businesses need: understanding the customer and the market, and building the systems that make the work easier. We've spent years in lead generation, CRM, automation and digital marketing, and we started <span data-brand><?php echo esc_html( by_opt( 'brand' ) ); ?></span> to make that practical for everyday businesses.</p>
          <p>Our test for every recommendation is simple: does it save you time, save you money, or give you more of your life back? If not, we won't suggest it.</p>
        </div>
        <div class="people">
          <?php echo by_photo( 'hf-09', 'Two business partners working through a plan at a kitchen table', 'about__img' ); ?>
          <div class="person">
            <h3>Christianna</h3>
            <p>Brand, positioning, marketing, digital ads and growth strategy.</p>
          </div>
          <div class="person">
            <h3>Robert</h3>
            <p>Technical discovery, AI tools, CRM, integrations, websites and automation delivery.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="section" id="faq">
      <div class="wrap wrap--narrow">
        <p class="eyebrow">FAQ</p>
        <h2 class="h2">Good questions</h2>
        <details>
          <summary>Do I need to understand AI to work with you?</summary>
          <p>Not at all. That's rather the point. We explain everything in plain English and only recommend tools that solve a clear problem in your business.</p>
        </details>
        <details>
          <summary>Will I have to replace the software I already use?</summary>
          <p>Usually not. We'd rather connect and improve the tools you already have than make you start again.</p>
        </details>
        <details>
          <summary>What happens after the audit?</summary>
          <p>You keep the plan either way. If you want help putting it in place, we quote the implementation based on the priorities you choose.</p>
        </details>
        <details>
          <summary>How long does an audit take?</summary>
          <p>One 60 to 90-minute session, your report within five business days, then a 30-minute walkthrough. About a week from start to finish for most businesses.</p>
        </details>
        <details>
          <summary>What does the audit cost?</summary>
          <p><?php echo esc_html( by_opt( 'audit_name' ) ); ?> is <?php echo esc_html( by_price( 'audit_price', 'a fixed fee we confirm on the discovery call' ) ); ?>.<?php if ( by_has( 'credit_text' ) ) echo ' ' . esc_html( by_opt( 'credit_text' ) ); ?><?php if ( by_has( 'guarantee_text' ) ) echo ' ' . esc_html( by_opt( 'guarantee_text' ) ); ?> Ready-made fixes and bigger projects are priced up front before any work starts.</p>
        </details>
        <details>
          <summary>What happens to my data? Is it used to train AI?</summary>
          <p>No. Your business data is never used to train AI models, ours or anyone else's. Every automated step we build is logged, a person checks anything uncertain before it goes out, and you own everything we build, including the logins.</p>
        </details>
        <details>
          <summary>Do you work with businesses outside my city?</summary>
          <p>Yes. We work with businesses across Australia, mostly online with on-site visits where it helps.</p>
        </details>
      </div>
    </section>

    <!-- OUR PROMISE (v1.5.0) -->
    <section class="section section--tight">
      <div class="wrap">
        <ul class="promise">
          <li><strong>Your data stays yours.</strong> It is never used to train AI, and we only connect what the job needs.</li>
          <li><strong>A person checks the uncertain bits.</strong> Automations handle the routine; humans handle the judgement calls.</li>
          <li><strong>You own everything we build.</strong> The accounts, the logins and the documentation, from day one.</li>
        </ul>
      </div>
    </section>

    <!-- CONTACT -->
    <section class="section section--alt" id="contact">
      <div class="wrap contact">
        <div>
          <p class="eyebrow">Get started</p>
          <h2 class="h2">Less time doing what you have to. <span class="u">More time doing what you love.<?php echo by_scribble( 'underline' ); ?></span></h2>
          <p>Tell us a little about your business and where the time goes. We'll get back to you within one business day to set up a free 20-minute discovery call.</p>
          <div class="contact__alt">
            <a href="#" class="btn js-book js-book-direct" hidden>Book a discovery call now <span aria-hidden="true">→</span></a>
            <p class="contact__line">Email <a href="#" data-email></a></p>
            <p class="contact__line" data-phone-wrap hidden>Phone <a href="#" data-phone></a></p>
          </div>
        </div>
        <form class="form" id="enquiryForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
          <div class="form__row">
            <label>Name<input name="name" required autocomplete="name"></label>
            <label>Business name<input name="business" autocomplete="organization"></label>
          </div>
          <div class="form__row">
            <label>Email<input name="email" type="email" required autocomplete="email"></label>
            <label>Phone<input name="phone" type="tel" autocomplete="tel"></label>
          </div>
          <label>What would you most like help with?
            <select name="interest">
              <option>Audit: find where time and money are going</option>
              <option>Invoicing and chasing payments</option>
              <option>Enquiries and follow-up</option>
              <option>Bookings and scheduling</option>
              <option>Connecting my apps</option>
              <option>Ads, CRM, website or SEO</option>
              <option>Not sure yet</option>
            </select>
          </label>
          <label>What's eating your time right now?<textarea name="message" rows="4" placeholder="e.g. I spend every Friday afternoon chasing invoices"></textarea></label>
          <input type="hidden" name="calc_estimate" id="calcEstimate">
          <input type="hidden" name="action" value="by_enquiry">
          <?php wp_nonce_field( 'by_enquiry', 'by_nonce' ); ?>
          <div class="hp" aria-hidden="true"><label>Leave this empty<input name="website" tabindex="-1" autocomplete="off"></label></div>
          <label class="check"><input type="checkbox" name="consent" required> <span>I agree to be contacted about my enquiry. See our <a href="<?php echo esc_url( by_privacy_url() ); ?>">privacy policy</a>.</span></label>
          <button class="btn" type="submit">Send enquiry <span aria-hidden="true">→</span></button>
          <p class="form__status" id="formStatus" role="status"></p>
        </form>
      </div>
    </section>
  </main>
<?php get_footer();
