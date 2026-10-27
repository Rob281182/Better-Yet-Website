<?php
/**
 * Template Name: Contact
 * The enquiry form, moved off the home page (v2.2.0). Enquiries are saved under "Enquiries" and emailed.
 */
get_header(); ?>
  <main id="main">
    <section class="hero hero--page">
      <div class="wrap">
        <p class="eyebrow3">Contact</p>
        <h1 class="hero3__h1 hero3__h1--page">Tell us where the time <span class="u">goes.<?php echo by_scribble( 'underline' ); ?></span></h1>
      </div>
    </section>
    <section class="section3 section3--top0">
      <div class="wrap contact">
        <div>
          <p class="lead">A line or two about your business and what eats your week. We reply within one business day, usually with a few times for a free 20-minute call.</p>
          <div class="contact__alt">
            <a href="<?php echo esc_url( by_book_url() . '?call=audit' ); ?>" class="btn js-book">Book the audit <span aria-hidden="true">→</span></a>
            <p class="contact__line">Email <a href="#" data-email></a></p>
            <p class="contact__line" data-phone-wrap hidden>Phone <a href="#" data-phone></a></p>
          </div>
        </div>
        <form class="form form--flat" id="enquiryForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
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
          <div class="hp" aria-hidden="true"><label>Leave this empty<input name="website" tabindex="-1" autocomplete="off" type="text"></label></div>
          <label class="check"><input type="checkbox" name="consent" required> <span>I agree to be contacted about my enquiry. See our <a href="<?php echo esc_url( by_privacy_url() ); ?>">privacy policy</a>.</span></label>
          <button class="btn" type="submit">Send enquiry <span aria-hidden="true">→</span></button>
          <p class="form__status" id="formStatus" role="status"></p>
        </form>
      </div>
    </section>
  </main>
<?php get_footer();
