<?php
/* Front page: the one-page Better Yet site. Copy follows the brand deck (October 2026). Settings are in Appearance > Customize > Better Yet settings. */
get_header(); ?>
  <main id="main">
    <!-- HERO -->
    <section class="hero">
      <div class="wrap hero__grid">
        <div>
          <p class="eyebrow">The human-first AI agency</p>
          <h1>Smarter systems.<br>More time back.</h1>
          <p class="lead">We find where your business is losing time and money, then put practical, smarter systems in place to fix it. We're not selling AI for the sake of AI. We're giving people their time back.</p>
          <div class="hero__cta">
            <a href="#contact" class="btn js-book">Book a free discovery call <span aria-hidden="true">→</span></a>
            <a href="#calculator" class="btn btn--ghost">See how much time you could get back</a>
          </div>
        </div>
        <div class="hero__card" aria-hidden="true">
          <p class="hero__card-label">A Friday, after</p>
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
    </section>

    <!-- THE IDEA -->
    <section class="section section--tight">
      <div class="wrap">
        <p class="eyebrow">The idea</p>
        <h2 class="h2">Technology should give you more time to be human.</h2>
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
      </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="section section--alt" id="how">
      <div class="wrap">
        <p class="eyebrow">How it works</p>
        <h2 class="h2">Find it. Fix it. Keep it working.</h2>
        <ol class="steps">
          <li class="step">
            <span class="step__num">01</span>
            <h3>Audit</h3>
            <p>We find the wasted time, costs and missed opportunities in how your business runs today, and give you a plain-English plan to fix them.</p>
            <span class="tag">One-off fee</span>
          </li>
          <li class="step">
            <span class="step__num">02</span>
            <h3>Implement</h3>
            <p>We put practical, smarter systems in place: connected apps, automatic follow-up, booking, quoting and the reporting you actually need.</p>
            <span class="tag">Project fee</span>
          </li>
          <li class="step">
            <span class="step__num">03</span>
            <h3>Manage</h3>
            <p>We maintain, improve and support everything over time, so it keeps working while you get on with the business.</p>
            <span class="tag">Monthly retainer</span>
          </li>
        </ol>
        <p class="complementary"><strong>Complementary services:</strong> digital ads &middot; CRM &middot; lead generation &middot; websites &middot; SEO</p>
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
          <h2 class="h2">How much time could you get back?</h2>
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
          <a href="#contact" class="btn btn--light" id="calcCta">Talk to us about it <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </section>

    <!-- THE CUSTOMERS -->
    <section class="section" id="who">
      <div class="wrap">
        <p class="eyebrow">Who we help</p>
        <h2 class="h2">Different businesses. Same feeling.</h2>
        <div class="customers">
          <article class="customer"><p class="customer__kicker">Artists</p><p class="customer__line">More creating.<br>Less invoicing.</p></article>
          <article class="customer"><p class="customer__kicker">Small business</p><p class="customer__line">Less admin.<br>More growing.</p></article>
          <article class="customer"><p class="customer__kicker">Healthcare</p><p class="customer__line">More patients.<br>Less paperwork.</p></article>
          <article class="customer"><p class="customer__kicker">Trades</p><p class="customer__line">More tools.<br>Less chasing invoices.</p></article>
        </div>
      </div>
    </section>

    <!-- RECENT WORK -->
    <section class="section section--tight work-teaser">
      <div class="wrap">
        <p class="eyebrow">Recent work</p>
        <h2 class="h2">Set up, streamlined, and running themselves.</h2>
        <div class="customers">
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#heiden' ); ?>"><p class="customer__kicker">Custom bikes</p><p class="customer__line">Heiden Cycle Works</p><p class="customer__meta">An automated bike builder: geometry, 3D render and deposit, all before the first email.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#roam' ); ?>"><p class="customer__kicker">Healthcare</p><p class="customer__line">Roam Orthotics</p><p class="customer__meta">One front door for enquiries, NDIS referrals and a scan-to-print workflow.</p></a>
          <a class="customer customer--link" href="<?php echo esc_url( by_work_url() . '#stephanie' ); ?>"><p class="customer__kicker">Artist</p><p class="customer__line">Stephanie Anne Studio</p><p class="customer__meta">An online studio that sells originals and prints while she paints.</p></a>
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
          <p>Most audits are completed within one to two weeks, depending on the size of the business and how quickly we can speak with your team.</p>
        </details>
        <details>
          <summary>Do you work with businesses outside my city?</summary>
          <p>Yes. We work with businesses across Australia, mostly online with on-site visits where it helps.</p>
        </details>
      </div>
    </section>

    <!-- CONTACT -->
    <section class="section section--alt" id="contact">
      <div class="wrap contact">
        <div>
          <p class="eyebrow">Get started</p>
          <h2 class="h2">Less time doing what you have to. More time doing what you love.</h2>
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
