<?php
/* Dynamic post index at /blogg/. */
get_header();
$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$post_query = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 7, 'paged' => $paged, 'orderby' => 'date', 'order' => 'DESC']);
$posts = $post_query->posts;
$featured = $posts ? array_shift($posts) : null;
$arrow = '<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$author_image = function ($post) {
    $name = arvinge_author_name($post->post_author);
    foreach (['Pär' => '28f67e62618ed96125d8841d7bf9f4ca.jpg', 'Max' => '91d83c7dc86c14f3908c77a7f7848894.jpg', 'Alice' => 'd0401589e9a1a2d56f7ca73f923f7f43.jpg', 'Johan' => '2397ebc4ed3eba0fe699a31ffa439be3.jpg'] as $person => $file) {
        if (strpos($name, $person) !== false) return arvinge_asset($file);
    }
    return esc_url(get_avatar_url($post->post_author, ['size' => 64]));
};
$post_excerpt = function ($post, $words = 24) {
    return wp_trim_words(wp_strip_all_tags(get_the_excerpt($post)), $words, '…');
};
?>
<main id="main" class="blog-page">
  <section id="top" class="hero blog-hero"><div class="wrap"><h1 class="h1 hero-h">Insikter, nyheter och perspektiv på digital närvaro</h1><div class="hero-row"><p class="lead hero-lead">Här delar vi med oss av tankar, trender och case från vårt arbete med företag som vill förstå, förtydliga och växa.</p></div>
    <?php if ($featured) : $author = arvinge_author_name($featured->post_author); ?><a href="<?php echo esc_url(get_permalink($featured)); ?>" class="feat"><span class="fmeta"><span class="av"><img src="<?php echo $author_image($featured); ?>" alt=""></span><?php echo arvinge_author_markup($author); ?> · <time datetime="<?php echo esc_attr(get_the_date('Y-m-d', $featured)); ?>"><?php echo esc_html(get_the_date('j F Y', $featured)); ?></time></span><span class="ftitle"><?php echo esc_html(get_the_title($featured)); ?></span><span class="fex"><?php echo esc_html($post_excerpt($featured, 26)); ?></span><span class="fmore">Läs inlägget <?php echo $arrow; ?></span></a><?php else : ?><div class="feat blog-empty"><span class="ftitle">Här kommer våra senaste tankar.</span><span class="fex">Besök sidan igen när det första inlägget är publicerat.</span></div><?php endif; ?>
  </div></section>
  <?php if ($posts) : ?><section class="sec blog-list-section" id="inlagg"><div class="wrap"><h2 class="h2">Fler inlägg.</h2><ul class="posts" aria-label="Fler inlägg"><?php foreach ($posts as $item) : $author = arvinge_author_name($item->post_author); ?><li><a href="<?php echo esc_url(get_permalink($item)); ?>" class="post"><time class="pdate" datetime="<?php echo esc_attr(get_the_date('Y-m-d', $item)); ?>"><?php echo esc_html(get_the_date('j F Y', $item)); ?></time><span class="pbody"><span class="ptitle"><?php echo esc_html(get_the_title($item)); ?></span><span class="pex"><?php echo esc_html($post_excerpt($item, 25)); ?></span></span><span class="pauth"><span class="av"><img src="<?php echo $author_image($item); ?>" alt=""></span><?php echo arvinge_author_markup($author); ?></span><span class="parr"><?php echo $arrow; ?></span></a></li><?php endforeach; ?></ul></div></section><?php endif; ?>
  <?php if ($post_query->max_num_pages > 1) : ?><nav class="wrap blog-pagination" aria-label="Bloggsidor"><?php echo paginate_links(['total' => $post_query->max_num_pages, 'current' => $paged, 'prev_text' => '← Föregående', 'next_text' => 'Nästa →']); ?></nav><?php endif; ?>
</main>
<?php get_footer(); ?>
