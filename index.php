<?php get_header(); ?>
<main id="main" class="policy">
  <div class="wrap wrap--narrow">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="entry-item">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php is_singular() ? the_content() : the_excerpt(); ?>
      </article>
    <?php endwhile; else : ?>
      <h1>Nothing here yet</h1>
      <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to the home page</a></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer();
