<?php
/**
 * Data and privacy (v2.5.0): the site's privacy page, served at /privacy/.
 * First how we handle a client's business data when we work on their systems (Christianna's launch list:
 * where data lives, who can access it, not used to train AI), then the website privacy policy from the page editor.
 */
get_header();
$brand = by_opt( 'brand' );
?>
<main id="main">
  <section class="hero hero--page">
    <div class="wrap">
      <p class="eyebrow3">Data and privacy</p>
      <h1 class="hero3__h1 hero3__h1--page">Your data stays <span class="u">yours.<?php echo by_scribble( 'underline' ); ?></span></h1>
      <p class="lead dp__lead">What happens to your information when we work on your business, in plain English. The website privacy policy is further down.</p>
    </div>
  </section>

  <section class="section3 section3--top0">
    <div class="wrap">
      <ol class="dp">
        <li class="dp__item">
          <h2>Where your data lives</h2>
          <p>In your own accounts. We build inside the tools you already pay for (your accounting software, CRM, booking system, Google or Microsoft workspace), so your records stay where they are. We don't copy your client lists or financials into systems of ours.</p>
          <p>If a build needs a new service, such as an automation tool or an AI model, we tell you which one, what it stores and where, before we start. It goes on an account in your business's name wherever the service allows.</p>
        </li>
        <li class="dp__item">
          <h2>Who can access it</h2>
          <p>Only Christianna and Robert, and only the systems the job needs. You give us access through your own logins or user invites, never by sharing your password, and you can switch it off at any time. When a job ends we hand back or remove our access, and we never pass your data to anyone else.</p>
        </li>
        <li class="dp__item">
          <h2>Never used to train AI</h2>
          <p>We don't use your data to train AI models, and we choose AI services whose business terms say they don't train on what you send them. Where an AI tool reads your information to do a job, such as sorting enquiries or drafting replies, a person checks anything it isn't sure about.</p>
        </li>
        <li class="dp__item">
          <h2>You own what we build</h2>
          <p>The automations, the logins and the documentation are yours. If you stop working with us, everything keeps running and you keep the keys.</p>
        </li>
        <li class="dp__item">
          <h2>What we keep from the audit</h2>
          <p>Your audit notes and report, so we can help you act on them. Ask and we'll delete them. Anything confidential you share stays confidential.</p>
        </li>
      </ol>
      <p class="dp__ask">Questions about your data? Email <a href="#" data-email><?php echo esc_html( by_opt( 'email' ) ); ?></a>.</p>
    </div>
  </section>

  <section class="section3 section3--stone policy">
    <div class="wrap wrap--narrow">
      <?php while ( have_posts() ) : the_post(); ?>
        <h2 class="h3x dp__policy-h">Website privacy policy</h2>
        <div class="entry"><?php the_content(); ?></div>
      <?php endwhile; ?>
    </div>
  </section>
</main>
<?php get_footer();
