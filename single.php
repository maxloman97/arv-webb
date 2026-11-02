<?php
/* Single blog post. */
get_header();
?>
<main id="main" class="single-post-page">
<?php if (have_posts()) : while (have_posts()) : the_post();
    $author_id = (int) get_post_field('post_author', get_the_ID());
    $author_name = arvinge_author_name($author_id);
    $author_role = arvinge_author_role($author_id);
    $author_bio = arvinge_author_bio($author_id);
    $author_image = arvinge_author_image($author_id);
    $post_url = get_permalink();
    $related = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()],
        'ignore_sticky_posts' => true,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
?>
  <div class="post-progress" aria-hidden="true"></div>
  <article <?php post_class('post-shell'); ?>>
    <header class="post-heading wrap">
      <a class="post-back" href="<?php echo arvinge_page('blogg'); ?>"><span aria-hidden="true">←</span> Alla inlägg</a>
      <h1><?php the_title(); ?></h1>
      <div class="post-meta">
        <span class="post-avatar"><img src="<?php echo $author_image; ?>" alt="" width="40" height="40"></span>
        <b><?php echo arvinge_author_markup($author_name); ?></b>
        <span class="post-meta-dot" aria-hidden="true">·</span>
        <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
      </div>
      <figure class="post-hero-media<?php echo has_post_thumbnail() ? '' : ' post-hero-empty'; ?>">
        <?php if (has_post_thumbnail()) : the_post_thumbnail('full', ['loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 820px) 100vw, 1120px']); endif; ?>
      </figure>
    </header>

    <div class="post-reading wrap">
      <aside class="post-share" aria-label="Dela inlägget">
        <span class="post-share-label">Dela</span>
        <a href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode($post_url)); ?>" target="_blank" rel="noopener noreferrer">LinkedIn <span class="sr">(öppnas i nytt fönster)</span></a>
        <button class="post-copy-link" type="button" data-url="<?php echo esc_url($post_url); ?>">Kopiera länk</button>
      </aside>
      <div class="post-prose">
        <?php if (has_excerpt()) : ?><p class="post-lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
        <?php the_content(); ?>
        <div class="post-author-card">
          <span class="post-avatar"><img src="<?php echo $author_image; ?>" alt="" width="64" height="64" loading="lazy"></span>
          <div>
            <span class="post-author-name"><?php echo arvinge_author_markup($author_name); ?></span>
            <?php if ($author_role) : ?><span class="post-author-role"><?php echo esc_html($author_role); ?></span><?php endif; ?>
            <?php if ($author_bio) : ?><p><?php echo esc_html($author_bio); ?></p><?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </article>

  <?php if ($related->have_posts()) : ?>
  <section class="post-more" aria-labelledby="post-more-title"><div class="wrap">
    <div class="post-more-heading"><h2 id="post-more-title">Fler inlägg.</h2><a href="<?php echo arvinge_page('blogg'); ?>">Alla inlägg <span aria-hidden="true">→</span></a></div>
    <ul class="post-more-list" aria-label="Fler inlägg">
      <?php while ($related->have_posts()) : $related->the_post();
          $item_author_id = (int) get_post_field('post_author', get_the_ID());
          $item_author_name = arvinge_author_name($item_author_id);
      ?>
      <li><a href="<?php the_permalink(); ?>" class="post-more-link">
        <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
        <span class="post-more-body"><span class="post-more-title"><?php the_title(); ?></span><span class="post-more-excerpt"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 25, '…')); ?></span></span>
        <span class="post-more-author"><span class="post-avatar"><img src="<?php echo arvinge_author_image($item_author_id); ?>" alt="" width="32" height="32" loading="lazy"></span><?php echo arvinge_author_markup($item_author_name); ?></span>
        <span class="post-more-arrow" aria-hidden="true">→</span>
      </a></li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </div></section>
  <?php endif; ?>
<?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
