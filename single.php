<?php
get_header();
?>
<main id="main" class="arvinge-article">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article <?php post_class('article-shell wrap'); ?>>
    <header class="article-header">
      <a class="article-back" href="<?php echo arvinge_page('blogg'); ?>">← Till alla artiklar</a>
      <div class="article-meta">
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
        <?php $category = get_the_category(); if ($category) : ?><span aria-hidden="true">·</span><span><?php echo esc_html($category[0]->name); ?></span><?php endif; ?>
      </div>
      <h1><?php the_title(); ?></h1>
      <?php if (has_excerpt()) : ?><p class="article-intro"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
      <div class="article-author"><?php echo get_avatar(get_the_author_meta('ID'), 44, '', '', ['class' => 'article-avatar']); ?><span><?php echo esc_html(arvinge_author_name(get_the_author_meta('ID'))); ?></span></div>
    </header>
    <?php if (has_post_thumbnail()) : ?><figure class="article-cover"><?php the_post_thumbnail('full', ['loading' => 'eager']); ?></figure><?php endif; ?>
    <div class="article-content"><?php the_content(); ?></div>
    <nav class="article-end" aria-label="Artikelnavigering"><a href="<?php echo arvinge_page('blogg'); ?>">← Alla artiklar</a><?php $next = get_next_post(); if ($next) : ?><a href="<?php echo esc_url(get_permalink($next)); ?>">Nästa artikel →</a><?php endif; ?></nav>
  </article>
<?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
