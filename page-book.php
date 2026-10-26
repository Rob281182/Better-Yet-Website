<?php
/**
 * Template Name: Book a call
 * On-site booking page: /book/. Pre-select the audit session with ?call=audit.
 */
get_header();
$types   = by_call_types();
$pre     = isset( $_GET['call'] ) && isset( $types[ sanitize_key( $_GET['call'] ) ] ) ? sanitize_key( $_GET['call'] ) : 'discovery';
$embed   = by_opt( 'booking_embed' ) && by_opt( 'booking_url' );
$avail   = array();
foreach ( $types as $k => $t ) { $avail[ $k ] = by_available_slots( $t['mins'] ); }
$tz      = by_booking_tz();
$tzlabel = ( new DateTime( 'now', $tz ) )->format( 'T' );
?>
<main id="main">
  <section class="hero hero--page hero--book">
    <div class="wrap">
      <p class="eyebrow">Book a call</p>
      <h1>Let's find <span class="u">your time back.<?php echo by_scribble( 'underline' ); ?></span></h1>
      <p class="lead">Pick a time that suits you. Twenty minutes, no slides, no pressure. You tell us where the hours go and we tell you honestly what we would fix first.</p>
    </div>
  </section>

  <section class="section section--tight">
    <div class="wrap book">
      <aside class="book__side">
        <p class="eyebrow">What happens</p>
        <ol class="book__steps">
          <li><strong>Pick a time.</strong> Times are shown in <?php echo esc_html( str_replace( '_', ' ', by_opt( 'booking_tz' ) ) ); ?> (<?php echo esc_html( $tzlabel ); ?>). You get a confirmation email with a calendar invite straight away.</li>
          <li><strong>We talk.</strong> <?php echo esc_html( by_opt( 'booking_how' ) ); ?> You'll speak with Christianna or Robert, not a sales team.</li>
          <li><strong>You get a next step.</strong> A couple of quick wins you can do yourself, and whether <?php echo esc_html( by_opt( 'audit_name' ) ); ?> makes sense for you. If it doesn't, we'll say so.</li>
        </ol>
        <p class="note"><span class="hand hand--sm">No prep needed. Bring the thing that annoys you most.</span></p>
        <div class="book__alt">
          <p class="book__alt-h">Prefer not to book?</p>
          <p>Email <a href="mailto:<?php echo esc_attr( by_opt( 'email' ) ); ?>" data-email><?php echo esc_html( by_opt( 'email' ) ); ?></a><?php if ( by_opt( 'phone' ) ) : ?> or call <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', by_opt( 'phone' ) ) ); ?>"><?php echo esc_html( by_opt( 'phone' ) ); ?></a><?php endif; ?>, or <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">send a message</a> and we'll come back within one business day.</p>
        </div>
      </aside>

      <div class="book__main">
        <?php if ( $embed ) : ?>
          <div class="book__embed">
            <iframe src="<?php echo esc_url( by_opt( 'booking_url' ) ); ?>" title="Book a call" loading="lazy"></iframe>
            <p class="book__fallback">Calendar not loading? <a href="<?php echo esc_url( by_opt( 'booking_url' ) ); ?>" target="_blank" rel="noopener">Open it in a new tab</a>.</p>
          </div>
        <?php else : ?>
          <form id="bookWidget" class="bookw" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate
                data-slots="<?php echo esc_attr( wp_json_encode( $avail ) ); ?>" data-pre="<?php echo esc_attr( $pre ); ?>">
            <input type="hidden" name="action" value="by_booking">
            <input type="hidden" name="by_nonce" value="<?php echo esc_attr( wp_create_nonce( 'by_booking' ) ); ?>">
            <input type="hidden" name="date" id="bookDate" value="">
            <input type="hidden" name="time" id="bookTime" value="">
            <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">

            <div class="bookw__step" data-step="1">
              <p class="bookw__label"><span class="bookw__num">1</span> What kind of call?</p>
              <div class="bookw__types">
                <?php foreach ( $types as $k => $t ) : ?>
                <label class="bookw__type">
                  <input type="radio" name="call_type" value="<?php echo esc_attr( $k ); ?>" <?php checked( $k, $pre ); ?>>
                  <span class="bookw__type-card">
                    <span class="bookw__type-top"><strong><?php echo esc_html( $t['name'] ); ?></strong><span class="tag"><?php echo esc_html( $t['mins'] ); ?> min &middot; <?php echo esc_html( $t['price'] ); ?></span></span>
                    <span class="bookw__type-blurb"><?php echo esc_html( $t['blurb'] ); ?></span>
                  </span>
                </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="bookw__step" data-step="2">
              <p class="bookw__label"><span class="bookw__num">2</span> Pick a day <span class="bookw__tz">(<?php echo esc_html( $tzlabel ); ?>)</span></p>
              <div class="bookw__days" id="bookDays" role="listbox" aria-label="Available days"></div>
            </div>

            <div class="bookw__step" data-step="3">
              <p class="bookw__label"><span class="bookw__num">3</span> Pick a time</p>
              <div class="bookw__times" id="bookTimes" role="listbox" aria-label="Available times"><p class="bookw__hint">Choose a day first.</p></div>
            </div>

            <div class="bookw__step" data-step="4">
              <p class="bookw__label"><span class="bookw__num">4</span> Your details</p>
              <div class="form form--flat">
                <div class="form__row">
                  <label>Name<input type="text" name="name" required autocomplete="name"></label>
                  <label>Business<input type="text" name="business" autocomplete="organization"></label>
                </div>
                <div class="form__row">
                  <label>Email<input type="email" name="email" required autocomplete="email"></label>
                  <label>Phone<input type="tel" name="phone" required autocomplete="tel" placeholder="So we can call you"></label>
                </div>
                <label>What's slowing you down? <span class="muted">(optional)</span><textarea name="notes" rows="3" placeholder="e.g. chasing invoices, quotes that take all evening, enquiries we miss"></textarea></label>
                <label class="check"><input type="checkbox" name="consent" required> You can contact me about this call. <a href="<?php echo esc_url( by_privacy_url() ); ?>">Privacy</a></label>
                <p class="bookw__summary" id="bookSummary" hidden></p>
                <button type="submit" class="btn" id="bookSubmit" disabled>Confirm booking <span aria-hidden="true">→</span></button>
                <p class="form__status" id="bookStatus" aria-live="polite"></p>
              </div>
            </div>
          </form>

          <div class="bookw__done" id="bookDone" hidden>
            <p class="eyebrow">Booked</p>
            <h2 class="h2">You're in.</h2>
            <p class="lead" id="bookDoneText"></p>
            <p id="bookDoneHow" class="muted"></p>
            <p><a href="#" class="btn" id="bookIcs" download="better-yet-call.ics">Add to calendar</a> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--ghost">Back to the site</a></p>
            <p class="muted">A confirmation with the calendar file is on its way to your inbox. Need to change it? Reply to that email.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<?php get_footer();
