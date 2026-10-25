<?php get_header(); ?>
<main id="main" class="policy">
  <div class="wrap wrap--narrow">
    <?php while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <div class="entry"><?php the_content(); ?></div>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer();
