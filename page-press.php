<?php
/* Press room at /press/. */
get_header();
?>
<main id="main" class="press-page">
  <section class="hero hero-bg press-hero"><div class="hbg" aria-hidden="true"><img src="<?php echo arvinge_asset('8e466922d86a3ad89b9068a8637c3ffc.jpg'); ?>" alt="" fetchpriority="high" style="object-position:50% 40%"><span class="hbg-shade"></span></div><div class="wrap press-hero-content"><h1 class="h1 hero-h">Press och nyheter från Arvinge.</h1><div class="hero-row"><p class="lead hero-lead">Vad händer hos Arvinge? Våra pressmeddelanden berättar om nya uppdrag och sådant vi har på gång. Pressmaterial och kontaktuppgifter finns också samlade här.</p></div></div></section>
  <section class="press-shortcode-content"><div class="wrap"><?php echo do_shortcode('[arvinge_pressrum]'); ?></div></section>
</main>
<?php get_footer(); ?>
