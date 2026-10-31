<?php get_header(); ?>
<main class="wrap basic-page">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>><h1><?php the_title(); ?></h1><?php the_content(); ?></article>
<?php endwhile; else : ?><h1><?php esc_html_e('Inget innehåll hittades.', 'arvinge'); ?></h1><?php endif; ?>
</main>
<?php get_footer(); ?>
