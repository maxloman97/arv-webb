<footer class="site-footer"><div class="wrap">
  <div class="fgrid">
    <div><img src="<?php echo arvinge_asset('03182411dd657e5c91dc10431b989d57.png'); ?>" alt="Arvinge" width="150"><p>Vi gör företag enklare att förstå och svårare att välja bort.</p></div>
    <div><h3>Navigering</h3><a href="<?php echo esc_url(home_url('/#case')); ?>">Case</a><a href="<?php echo esc_url(home_url('/#tjanster')); ?>">Tjänster</a><a href="<?php echo arvinge_page('forum-event'); ?>">Forum &amp; Event</a><a href="<?php echo arvinge_page('blogg'); ?>">Blogg</a></div>
    <div><h3>Företaget</h3><a href="<?php echo arvinge_page('om-oss'); ?>">Om oss</a><a href="<?php echo arvinge_page('press'); ?>">Press</a><a href="<?php echo arvinge_page('kontakt'); ?>">Kontakt</a></div>
    <div id="analys"><?php if (is_page('forum-event')) : ?><h3>Planera ett event</h3><p>Berätta vad ni vill samla folk kring, så tar vi det därifrån.</p><a class="tlink" href="<?php echo arvinge_page('kontakt'); ?>?typ=event#formular">Till kontaktformuläret →</a><?php else : ?><h3>Analysera din hemsida</h3><p>Se hur din webbplats står sig – med vårt nya verktyg.</p><?php if (is_page('kontakt') || is_page('om-oss')) : ?><a class="tlink" href="<?php echo esc_url(home_url('/#analys')); ?>">Till analysverktyget →</a><?php else : ?><form class="analysis-form"><label for="domain" class="sr">Din webbadress</label><input id="domain" class="finput" type="text" placeholder="dittforetag.se"><button type="button" class="btn">Analysera</button></form><?php endif; ?><?php endif; ?></div>
  </div>
  <div class="fbottom"><span>© <?php echo esc_html(date_i18n('Y')); ?> Arvinge kommunikation AB</span><span>Johan Tillanders Väg 17, 168 52 Bromma · 08-745 05 55</span></div>
</div></footer>
<?php wp_footer(); ?>
</body></html>
