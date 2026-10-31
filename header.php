<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sr skip-link" href="#main">Hoppa till innehåll</a>
<header class="nav" id="site-nav">
  <div class="wrap navbar">
    <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Arvinge – till start"><img class="navlogo" src="<?php echo arvinge_asset('03182411dd657e5c91dc10431b989d57.png'); ?>" alt="Arvinge"></a>
    <nav class="navlinks" aria-label="Huvudmeny">
      <a href="<?php echo esc_url(home_url('/#case')); ?>">Case</a><a href="<?php echo esc_url(home_url('/#tjanster')); ?>">Tjänster</a><a href="<?php echo arvinge_page('forum-event'); ?>">Forum &amp; Event</a><a href="<?php echo arvinge_page('om-oss'); ?>">Om oss</a><a href="<?php echo arvinge_page('blogg'); ?>">Blogg</a>
    </nav>
    <div class="navr"><a class="btn sm" href="<?php echo arvinge_page('kontakt'); ?>">Boka möte</a><button type="button" class="navburger" aria-expanded="false" aria-controls="mmenu" aria-label="Öppna menyn"><span class="bl"></span><span class="bl"></span></button></div>
  </div>
</header>
<div id="mmenu" class="mmenu" hidden>
  <nav class="mlinks" aria-label="Mobilmeny"><a href="<?php echo esc_url(home_url('/#case')); ?>">Case →</a><a href="<?php echo esc_url(home_url('/#tjanster')); ?>">Tjänster →</a><a href="<?php echo arvinge_page('forum-event'); ?>">Forum &amp; Event →</a><a href="<?php echo arvinge_page('om-oss'); ?>">Om oss →</a><a href="<?php echo arvinge_page('blogg'); ?>">Blogg →</a></nav>
  <div class="mfoot"><a class="btn lg" href="<?php echo arvinge_page('kontakt'); ?>">Boka ett möte</a><a class="mtel" href="tel:+4687450555">Hellre ringa? 08-745 05 55</a></div>
</div>
