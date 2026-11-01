<?php
$capabilities = ['Strategi', 'Innehåll', 'Webb & digital struktur', 'AI & automation', 'Forum & Event'];
$included = explode(' · ', $g[3]);
?>
<div class="gp">
  <h3><?php echo esc_html($g[1]); ?></h3>
  <p class="txt"><?php echo esc_html($g[2]); ?></p>
  <div class="goal-bottom">
    <p class="label">Det här ingår</p>
    <ul class="caps">
      <?php foreach ($capabilities as $cap) : $active = in_array($cap, $included, true); ?>
      <li class="cap<?php echo $active ? ' on' : ''; ?>"><span class="ck" aria-hidden="true"><?php echo $active ? '✓' : ''; ?></span><?php echo esc_html($cap); ?><span class="sr"><?php echo $active ? ' – ingår' : ' – ingår inte'; ?></span></li>
      <?php endforeach; ?>
    </ul>
    <div class="goal-actions"><a class="btn" href="<?php echo arvinge_page('kontakt'); ?><?php echo ($i === 4 || $i === 5) ? '?typ=event#formular' : '#formular'; ?>"><?php echo ($i === 4 || $i === 5) ? 'Mejla Johan om det här' : 'Boka ett möte om det här'; ?></a><?php if ($i === 4 || $i === 5) : ?><a class="tlink" href="#forum">Läs om Arvinge Forum →</a><?php endif; ?></div>
  </div>
</div>
