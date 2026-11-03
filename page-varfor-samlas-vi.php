<?php
/* Existing WordPress page: /forum-event/varfor-samlas-vi/. */
get_header();
require __DIR__ . '/template-parts/forum-history-data.php';
?>
<main id="main" class="forum-detail history-page">
  <section class="detail-hero"><div class="wrap"><a class="detail-back" href="<?php echo arvinge_page('forum-event'); ?>">← Forum och Event</a><h1>Varför samlas vi?</h1><div class="detail-lead"><?php foreach ($intro as $paragraph) : ?><p><?php echo esc_html($paragraph); ?></p><?php endforeach; ?></div></div></section>
  <nav class="detail-index wrap" aria-label="Välj årtal"><?php foreach ($stories as $story) : ?><a href="#ar-<?php echo esc_attr($story[0] === 'I dag' ? 'idag' : $story[0]); ?>"><?php echo esc_html($story[0]); ?></a><?php endforeach; ?></nav>
  <div class="wrap detail-stories"><?php foreach ($stories as $story) : ?><article id="ar-<?php echo esc_attr($story[0] === 'I dag' ? 'idag' : $story[0]); ?>" class="detail-story"><h2><?php echo esc_html($story[1]); ?></h2><?php foreach ($story[2] as $paragraph) : ?><p><?php echo esc_html($paragraph); ?></p><?php endforeach; ?><?php foreach ($story[3] as $source) : ?><p class="detail-source"><?php echo esc_html($source); ?></p><?php endforeach; ?></article><?php endforeach; ?></div>
  <section class="detail-end"><div class="wrap"><p><?php echo esc_html($closing); ?></p><div class="detail-actions"><a class="btn lg" href="<?php echo arvinge_page('kontakt'); ?>?typ=event#formular">Prata mötesplats med oss</a><a class="tlink" href="<?php echo arvinge_page('forum-event/motesplats'); ?>">Skapa en mötesplats →</a><a class="tlink" href="<?php echo arvinge_page('forum-event') . '#partnerskap'; ?>">Delta som partner →</a></div></div></section>
</main>
<?php get_footer(); ?>
