<?php
/**
 * Template Name: Our work
 * Case studies: businesses we've helped set up and optimise. Edit the copy here.
 *
 * Images are loaded straight from the client sites (all on the same Hostinger account),
 * so nothing has to be uploaded here. Swap any URL in $by_media below to change a picture.
 */
$by_media = array(
	'heiden' => array(
		'base'    => 'https://heiden.bike/wp-content/uploads/',
		'hero'    => '2026/08/heiden-hero-road-frame.jpg',
		'render'  => '2026/08/bike-render-extracted.jpg',
		'side'    => '2026/08/Side-on-view.png',
		'strip'   => array(
			array( '2026/08/heiden-strip-road-1.jpg', 'Road frame' ),
			array( '2026/08/heiden-strip-gravel-1.jpg', 'Gravel frame' ),
			array( '2026/08/heiden-strip-road-2.jpg', 'Drivetrain detail' ),
			array( '2026/08/heiden-strip-gravel-3.jpg', 'Cockpit detail' ),
		),
		'ride'    => '2026/10/heiden-kyushu-03-volcano-lookout-nobag.jpg',
		'builder' => 'https://heiden.bike/builder-v2/?h=178&in=82&st=0&ty=38&sc=full',
		'start'   => 'https://heiden.bike/builder-v2/start.html',
		'site'    => 'https://heiden.bike',
		'insta'   => 'https://www.instagram.com/heidenbike/',
	),
	'roam' => array(
		'base'     => 'https://roamorthotics.com.au/wp-content/uploads/2026/10/',
		'hero'     => 'roam-H2-hero-orthotics-1536x857.png',
		'workflow' => 'roam-K2-digital-workflow-1536x652.jpg',
		'map'      => 'roam-M1-service-map-1536x652.png',
		'kit'      => 'roam-K3-roaming-kit-1024x572.jpg',
		'products' => array(
			array( 'roam-solid-afo-300x300.png', 'Solid AFO' ),
			array( 'roam-kafo-300x300.png', 'KAFO' ),
			array( 'roam-custom-footwear-300x300.png', 'Custom footwear' ),
			array( 'roam-hand-splint-300x300.png', 'Hand splint' ),
		),
		'site'     => 'https://roamorthotics.com.au',
	),
	'stephanie' => array(
		'base'     => 'https://stephanieannestudio.com/wp-content/uploads/2026/10/',
		'portrait' => 'stephanie-portrait-670x1024.png',
		'works'    => array(
			array( 'from-the-shadows-she-blooms-black-724x1024.jpg', 'From the Shadows She Blooms' ),
			array( 'BlueReverie_WebFile-600x849.jpg', 'Blue Reverie' ),
			array( 'radiance-in-bloom-black-600x849.jpg', 'Radiance in Bloom' ),
			array( 'whispers-of-dawn-black-600x849.jpg', 'Whispers of Dawn' ),
			array( 'iris-of-the-night-black-600x848.jpg', 'Iris of the Night' ),
			array( 'eclipse-in-bloom-black-600x849.jpg', 'Eclipse in Bloom' ),
		),
		'site'     => 'https://stephanieannestudio.com',
		'shop'     => 'https://stephanieannestudio.com/#shop',
		'insta'    => 'https://www.instagram.com/stephanie.anne.studio/',
	),
);
$h = $by_media['heiden']; $r = $by_media['roam']; $s = $by_media['stephanie'];
get_header(); ?>
  <main id="main">
    <section class="hero hero--page">
      <div class="wrap">
        <p class="eyebrow">Our work</p>
        <h1>Real businesses. Real time back.</h1>
        <p class="lead">Three owner-run businesses we helped set up and streamline. Different trades, same result: the busywork runs itself, and the owner gets on with the work they love.</p>
        <div class="hero__strip" aria-hidden="true">
          <img src="<?php echo esc_url( $h['base'] . $h['strip'][0][0] ); ?>" alt="" loading="eager">
          <img src="<?php echo esc_url( $r['base'] . $r['workflow'] ); ?>" alt="" loading="eager">
          <img src="<?php echo esc_url( $s['base'] . $s['works'][1][0] ); ?>" alt="" loading="eager">
        </div>
      </div>
    </section>

    <!-- FEATURED: HEIDEN CYCLE WORKS -->
    <section class="section section--alt" id="heiden">
      <div class="wrap">
        <article class="case case--featured">
          <div class="case__head">
            <p class="eyebrow">Featured &middot; Custom bike builder</p>
            <h2 class="h2">Heiden Cycle Works</h2>
            <p class="case__sub">A fully automated geometry and lead-capture tool for a custom frame builder. <a href="<?php echo esc_url( $h['site'] ); ?>" target="_blank" rel="noopener">heiden.bike</a></p>
          </div>

          <figure class="media media--wide">
            <img src="<?php echo esc_url( $h['base'] . $h['hero'] ); ?>" alt="A Heiden custom road frame" loading="lazy">
            <figcaption>Every Heiden frame is built to one rider's measurements. The website had to do the same.</figcaption>
          </figure>

          <div class="case__grid">
            <div class="case__col">
              <h3>The problem</h3>
              <p>Heiden builds custom road, gravel and mountain frames fitted to each rider's body, not to S, M or L. Every enquiry used to mean a back-and-forth of emails, measurements, sketches and spreadsheets before anyone knew what the bike would look like or what it would cost. Hours of design time went into riders who hadn't committed.</p>
              <h3>What we built</h3>
              <p>An online Bike Builder that does the first design conversation automatically. The rider enters their height and inside leg, picks a riding style (stable, balanced or agile), tyre clearance, fork and build level, and the frame geometry is calculated and drawn live in 3D, every tube length and angle, in the browser. Step two lets them make it theirs: wheels and tyres, lug colour, groupset, bottle and bag fit-checks.</p>
              <p>When the rider is happy, a $500 deposit reserves their build slot. At that moment the full specification, geometry and the rider's details are captured automatically and land with the workshop, with the invoice generated and the rider's record created, no retyping. A fitter reviews every design before it's approved, so people stay in control and the software handles the busywork.</p>
            </div>
            <aside class="case__facts">
              <h3>How it works</h3>
              <ol class="case__steps">
                <li><strong>Dial in your fit.</strong> Height, inside leg, riding style. Geometry computed and drawn live in 3D.</li>
                <li><strong>Make it yours.</strong> Tyres, fork, lug colour, components and extras, with live fit-checks.</li>
                <li><strong>Reserve the build.</strong> A deposit sends the full spec and rider details straight to the workshop.</li>
                <li><strong>Human review.</strong> A fitter checks every design and sends a photorealistic render for approval.</li>
              </ol>
              <h3>Under the hood</h3>
              <ul class="case__stack">
                <li>Parametric 3D configurator wired to the frame-geometry maths</li>
                <li>Online store with deposits and partial payments</li>
                <li>Card payments, automatic invoices and packing slips</li>
                <li>Every build request captured as a customer record with its spec</li>
                <li>Analytics and tracking on the whole funnel</li>
              </ul>
            </aside>
          </div>

          <!-- Live builder embed -->
          <div class="showcase">
            <div class="showcase__head">
              <p class="eyebrow">Try it</p>
              <h3 class="h3">The Bike Builder, live</h3>
              <p>This is the real tool, running on heiden.bike. Drag to spin the frame, change the fit and watch the geometry redraw. Opens with a 178&nbsp;cm rider on a 38&nbsp;mm gravel tyre; press <em>Start from your measurements</em> to design your own.</p>
            </div>
            <div class="embed embed--app" data-embed="<?php echo esc_url( $h['builder'] ); ?>" data-embed-title="Heiden Bike Builder" data-embed-auto="1">
              <img class="embed__poster" src="<?php echo esc_url( $h['base'] . $h['render'] ); ?>" alt="Render of a Heiden frame from the builder" loading="lazy">
              <div class="embed__overlay">
                <button type="button" class="btn btn--light embed__load">Load the live 3D builder</button>
                <p class="embed__note">Loads a 3D model (about 10&nbsp;MB). Best on a laptop or desktop.</p>
              </div>
            </div>
            <p class="showcase__links">
              <a class="btn" href="<?php echo esc_url( $h['start'] ); ?>" target="_blank" rel="noopener">Start from your measurements <span aria-hidden="true">→</span></a>
              <a class="link-plain" href="<?php echo esc_url( $h['builder'] ); ?>" target="_blank" rel="noopener">Open the builder full screen</a>
            </p>
          </div>

          <div class="gallery gallery--4">
            <?php foreach ( $h['strip'] as $img ) : ?>
              <figure class="gallery__item"><img src="<?php echo esc_url( $h['base'] . $img[0] ); ?>" alt="<?php echo esc_attr( $img[1] ); ?>" loading="lazy"><figcaption><?php echo esc_html( $img[1] ); ?></figcaption></figure>
            <?php endforeach; ?>
          </div>

          <div class="case__outcomes">
            <div class="outcome"><span class="outcome__num">0</span><span class="outcome__label">emails before a rider sees their frame</span></div>
            <div class="outcome"><span class="outcome__num">24/7</span><span class="outcome__label">design and quoting, without the founder</span></div>
            <div class="outcome"><span class="outcome__num">1</span><span class="outcome__label">step from "I like it" to a paid, specced build in the queue</span></div>
          </div>
          <p class="case__yet">A frame fitted to your body. <em>Better yet,</em> designed, quoted and booked before anyone picks up the phone.</p>
          <p class="case__links"><a href="<?php echo esc_url( $h['site'] ); ?>" target="_blank" rel="noopener">Visit heiden.bike</a> &middot; <a href="<?php echo esc_url( $h['insta'] ); ?>" target="_blank" rel="noopener">@heidenbike on Instagram</a></p>
        </article>
      </div>
    </section>

    <!-- ROAM ORTHOTICS -->
    <section class="section" id="roam">
      <div class="wrap">
        <div class="case__grid case__grid--even">
          <div>
            <p class="eyebrow">Healthcare &middot; Mobile clinic</p>
            <h2 class="h2">Roam Orthotics</h2>
            <p class="case__sub">More patients. Less paperwork. <a href="<?php echo esc_url( $r['site'] ); ?>" target="_blank" rel="noopener">roamorthotics.com.au</a></p>
            <p>Roam is a mobile orthotics practice covering South East Queensland, seeing children and adults in homes, schools, workplaces and a clinic. Referrals come from families, therapists, support coordinators, GPs and specialists, many through the NDIS, and each one used to arrive a different way.</p>
            <p>We set up the whole front door: a clear website explaining who Roam helps and how it works, separate enquiry and referral paths so a parent and a support coordinator each get the right form, NDIS and funding information up front, and a search-optimised structure so the practice is found in every suburb it serves. Behind it, 3D scanning and printing replace plaster casting, which means digital measurements, faster turnaround and less discomfort for the client.</p>
            <div class="gallery gallery--products">
              <?php foreach ( $r['products'] as $img ) : ?>
                <figure class="gallery__item gallery__item--pad"><img src="<?php echo esc_url( $r['base'] . $img[0] ); ?>" alt="<?php echo esc_attr( $img[1] ); ?>" loading="lazy"><figcaption><?php echo esc_html( $img[1] ); ?></figcaption></figure>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="case__side">
            <figure class="media">
              <img src="<?php echo esc_url( $r['base'] . $r['workflow'] ); ?>" alt="Roam's digital scan-to-print workflow" loading="lazy">
              <figcaption>Scan, design, print. No plaster.</figcaption>
            </figure>
            <aside class="case__facts">
              <h3>What changed</h3>
              <ul class="case__stack">
                <li>One structured intake for enquiries and professional referrals</li>
                <li>NDIS, funding and service-area information answered before the first call</li>
                <li>Digital scan-to-print workflow instead of plaster casts</li>
                <li>Local SEO across Brisbane, Gold Coast, Sunshine Coast, Ipswich, Logan, Moreton Bay, Redlands and Toowoomba</li>
              </ul>
            </aside>
            <figure class="media">
              <img src="<?php echo esc_url( $r['base'] . $r['map'] ); ?>" alt="Map of the South East Queensland areas Roam visits" loading="lazy">
              <figcaption>Where Roam roams: every suburb on the map has its own search presence.</figcaption>
            </figure>
          </div>
        </div>
        <div class="embed embed--site" data-embed="<?php echo esc_url( $r['site'] ); ?>" data-embed-title="Roam Orthotics website">
          <img class="embed__poster" src="<?php echo esc_url( $r['base'] . $r['hero'] ); ?>" alt="The Roam Orthotics website" loading="lazy">
          <div class="embed__overlay">
            <button type="button" class="btn btn--light embed__load">Preview the live site</button>
            <p class="embed__note">or <a href="<?php echo esc_url( $r['site'] ); ?>" target="_blank" rel="noopener">open roamorthotics.com.au</a></p>
          </div>
        </div>
      </div>
    </section>

    <!-- STEPHANIE ANNE STUDIO -->
    <section class="section section--alt" id="stephanie">
      <div class="wrap">
        <div class="case__grid case__grid--even">
          <div>
            <p class="eyebrow">Artist &middot; Online studio</p>
            <h2 class="h2">Stephanie Anne Studio</h2>
            <p class="case__sub">More creating. Less invoicing. <a href="<?php echo esc_url( $s['site'] ); ?>" target="_blank" rel="noopener">stephanieannestudio.com</a></p>
            <p>Steph is a Melbourne artist working in oils and coloured pencil. Selling originals and prints used to mean DMs, manual invoices and chasing payments, which is time away from the easel.</p>
            <p>We set up an online studio that sells for her: a portfolio, a shop with original works and print options at every size, card and PayPal checkout, automatic order confirmations and a commissions enquiry form that lands in her inbox ready to answer. Orders, payments and receipts happen without her touching them, so her admin is packing the parcel.</p>
            <aside class="case__facts">
              <h3>What changed</h3>
              <ul class="case__stack">
                <li>Shop with originals and multi-size print options</li>
                <li>Card and PayPal payments, automatic receipts</li>
                <li>Commission enquiries through one structured form</li>
                <li>Portfolio and Instagram tied together for discovery</li>
              </ul>
            </aside>
            <p class="case__links"><a href="<?php echo esc_url( $s['shop'] ); ?>" target="_blank" rel="noopener">Visit the shop</a> &middot; <a href="<?php echo esc_url( $s['insta'] ); ?>" target="_blank" rel="noopener">@stephanie.anne.studio on Instagram</a></p>
          </div>
          <figure class="media media--portrait">
            <img src="<?php echo esc_url( $s['base'] . $s['portrait'] ); ?>" alt="Stephanie Anne in her studio" loading="lazy">
            <figcaption>Stephanie Anne in her studio.</figcaption>
          </figure>
        </div>
        <div class="gallery gallery--art">
          <?php foreach ( $s['works'] as $img ) : ?>
            <figure class="gallery__item"><img src="<?php echo esc_url( $s['base'] . $img[0] ); ?>" alt="<?php echo esc_attr( $img[1] ); ?>" loading="lazy"><figcaption><?php echo esc_html( $img[1] ); ?></figcaption></figure>
          <?php endforeach; ?>
        </div>
        <div class="embed embed--site" data-embed="<?php echo esc_url( $s['site'] ); ?>" data-embed-title="Stephanie Anne Studio website">
          <img class="embed__poster" src="<?php echo esc_url( $s['base'] . $s['works'][0][0] ); ?>" alt="The Stephanie Anne Studio website" loading="lazy">
          <div class="embed__overlay">
            <button type="button" class="btn btn--light embed__load">Preview the live shop</button>
            <p class="embed__note">or <a href="<?php echo esc_url( $s['site'] ); ?>" target="_blank" rel="noopener">open stephanieannestudio.com</a></p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="section section--dark">
      <div class="wrap cta">
        <h2 class="h2">What would you do with the time back?</h2>
        <p class="muted-light">Tell us where the hours go. We'll find the quick wins in a free 20-minute discovery call.</p>
        <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="btn btn--light js-book">Book a discovery call <span aria-hidden="true">→</span></a>
      </div>
    </section>
  </main>
<?php get_footer();
