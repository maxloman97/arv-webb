<?php
/* Template for the WordPress page with slug "kontakt". */
get_header();
$check = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10"/></svg>';
$chevron = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
?>
<main id="main" class="contact-page">
  <section class="hero hero-bg contact-hero">
    <div class="hbg" aria-hidden="true"><img src="<?php echo arvinge_asset('8e466922d86a3ad89b9068a8637c3ffc.jpg'); ?>" alt="" fetchpriority="high" style="object-position:50% 40%"><span class="hbg-shade"></span></div>
    <div class="wrap contact-hero-content">
      <h1 class="h1 hero-h">Berätta vad ni vill uppnå.</h1>
      <div class="hero-row"><p class="lead hero-lead">Gäller det ett nytt projekt eller ett event? Välj nedan så anpassar sig formuläret – och rätt person hos oss hör av sig.</p></div>
    </div>
  </section>

  <section id="formular" class="contact-form-section" aria-label="Kontaktformulär">
    <div class="wrap kgrid">
      <div class="fcard">
        <form id="contact-form" novalidate>
          <input type="hidden" name="action" value="arvinge_contact"><input type="hidden" name="type" value="projekt">
          <div class="sr contact-honeypot" aria-hidden="true"><label for="website">Webbplats</label><input id="website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
          <div class="fsec first">
            <p class="fstep"><span>01</span>Vad gäller det?</p>
            <div class="types" role="group" aria-label="Välj typ av förfrågan">
              <?php
              $types = [
                'projekt' => ['Ett nytt projekt', 'Strategi, innehåll, webb eller AI', '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/><circle cx="12" cy="12" r="3"/>'],
                'event' => ['Event och mötesplatser', 'Arvinge Forum & Event', '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>'],
                'ovrigt' => ['Något annat', 'Press, jobb eller en fråga', '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>'],
              ];
              foreach ($types as $key => $item) : ?>
                <button type="button" class="type<?php echo $key === 'projekt' ? ' on' : ''; ?>" data-type="<?php echo esc_attr($key); ?>" aria-pressed="<?php echo $key === 'projekt' ? 'true' : 'false'; ?>"><span class="ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $item[2]; ?></svg></span><span><span class="tt"><?php echo esc_html($item[0]); ?></span><span class="ts"><?php echo esc_html($item[1]); ?></span></span><span class="tick" aria-hidden="true"><?php echo $check; ?></span></button>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="fsec branch" data-branch="projekt">
            <p class="fstep"><span>02</span>Om projektet</p><div class="stack">
              <div class="field"><span class="lbl" id="lbl-needs">Vad behöver ni hjälp med? <span class="opt">Välj en eller flera</span></span><div class="chips" role="group" aria-labelledby="lbl-needs">
                <?php foreach (['Strategi', 'Innehåll', 'Webb & digital struktur', 'AI & automation', 'Vet inte än'] as $item) : ?><button type="button" class="chip" data-chip="needs" data-value="<?php echo esc_attr($item); ?>" aria-pressed="false"><span class="ck"><?php echo $check; ?></span><?php echo esc_html($item); ?></button><?php endforeach; ?>
              </div></div>
              <div class="field"><label class="lbl" for="when">När vill ni komma igång?</label><div class="sel"><select id="when" name="when" class="inp"><option value="">Välj</option><?php foreach (['Så snart som möjligt', 'Inom tre månader', 'Senare i år', 'Vet inte än'] as $item) : ?><option><?php echo esc_html($item); ?></option><?php endforeach; ?></select><?php echo $chevron; ?></div></div>
              <div class="field"><label class="lbl" for="msgP">Berätta kort om utmaningen</label><textarea id="msgP" class="inp" placeholder="Vad vill ni uppnå, och vad står i vägen i dag?"></textarea><p class="err" data-error="message" hidden>Skriv några rader om vad ni behöver hjälp med.</p></div>
            </div>
          </div>

          <div class="fsec branch" data-branch="event" hidden>
            <p class="fstep"><span>02</span>Om eventet</p><div class="stack">
              <div class="field"><span class="lbl" id="lbl-kind">Eget event eller partner på någon annans?</span><div class="chips" role="group" aria-labelledby="lbl-kind"><?php foreach (['Eget event', 'Partner på någon annans', 'Vet inte än'] as $item) : ?><button type="button" class="chip" data-chip="kinds" data-value="<?php echo esc_attr($item); ?>" aria-pressed="false"><span class="ck"><?php echo $check; ?></span><?php echo esc_html($item); ?></button><?php endforeach; ?></div></div>
              <div class="field"><span class="lbl" id="lbl-fmt">Vilket format lockar? <span class="opt">Välj en eller flera</span></span><div class="chips" role="group" aria-labelledby="lbl-fmt"><?php foreach (['Kundevent och partnerträffar', 'Seminarier och rapportsläpp', 'Rundabordssamtal', 'Konferens', 'Vet inte än'] as $item) : ?><button type="button" class="chip" data-chip="formats" data-value="<?php echo esc_attr($item); ?>" aria-pressed="false"><span class="ck"><?php echo $check; ?></span><?php echo esc_html($item); ?></button><?php endforeach; ?></div></div>
              <div class="grid2"><div class="field"><label class="lbl" for="people">Ungefärligt antal deltagare</label><div class="sel"><select id="people" name="people" class="inp"><option value="">Välj</option><?php foreach (['Under 25', '25–100', '100–300', 'Fler än 300', 'Vet inte än'] as $item) : ?><option><?php echo esc_html($item); ?></option><?php endforeach; ?></select><?php echo $chevron; ?></div></div><div class="field"><label class="lbl" for="period">Preliminärt datum eller period <span class="opt">Valfritt</span></label><input id="period" name="period" class="inp" type="text" placeholder="t.ex. våren 2027"></div></div>
              <div class="field"><label class="lbl" for="msgE">Vad ska ni samlas kring – och varför?</label><textarea id="msgE" class="inp" placeholder="Ämnet, vilka som ska vara där och vad ni vill att mötet leder till."></textarea><p class="err" data-error="message" hidden>Berätta kort vad eventet ska handla om.</p></div>
            </div>
          </div>

          <div class="fsec branch" data-branch="ovrigt" hidden>
            <p class="fstep"><span>02</span>Ditt ärende</p><div class="stack">
              <div class="field"><label class="lbl" for="topic">Vad gäller det?</label><div class="sel"><select id="topic" name="topic" class="inp"><option value="">Välj</option><?php foreach (['Press', 'Jobb och praktik', 'Samarbete', 'Övrigt'] as $item) : ?><option><?php echo esc_html($item); ?></option><?php endforeach; ?></select><?php echo $chevron; ?></div></div>
              <div class="field"><label class="lbl" for="msgO">Meddelande</label><textarea id="msgO" class="inp" placeholder="Skriv ditt meddelande här."></textarea><p class="err" data-error="message" hidden>Skriv ett meddelande.</p></div>
            </div>
          </div>

          <div class="fsec"><p class="fstep"><span>03</span>Kontaktuppgifter</p><div class="grid2">
            <div class="field"><label class="lbl" for="name">Namn</label><input id="name" name="name" class="inp" type="text" autocomplete="name" required><p class="err" data-error="name" hidden>Fyll i ditt namn.</p></div>
            <div class="field"><label class="lbl" for="company">Företag <span class="opt">Valfritt</span></label><input id="company" name="company" class="inp" type="text" autocomplete="organization"></div>
            <div class="field"><label class="lbl" for="email">E-post</label><input id="email" name="email" class="inp" type="email" autocomplete="email" required><p class="err" data-error="email" hidden>Ange en giltig e-postadress.</p></div>
            <div class="field"><label class="lbl" for="phone">Telefon <span class="opt">Valfritt</span></label><input id="phone" name="phone" class="inp" type="tel" autocomplete="tel"></div>
          </div></div>
          <div class="fsec"><label class="consent"><input id="consent" name="consent" type="checkbox" value="1" required><span>Jag godkänner att Arvinge sparar mina uppgifter för att kunna svara på min förfrågan. Läs mer i vår <a href="<?php echo arvinge_page('integritetspolicy'); ?>">integritetspolicy</a>.</span></label><p class="err" data-error="consent" hidden>Du behöver godkänna för att vi ska kunna svara.</p><div class="submit"><button type="submit" class="btn lg">Skicka förfrågan</button><p class="err" id="form-error" role="alert" hidden></p></div></div>
        </form>
        <div class="thanks" id="contact-thanks" role="status" hidden><span class="big" aria-hidden="true"><?php echo $check; ?></span><h2>Tack, <span id="thanks-name"></span>!</h2><p class="lead">Vi har tagit emot din förfrågan. <span id="thanks-person"></span> hör av sig så snart vi har läst den.</p><div class="thanks-actions"><a href="<?php echo esc_url(home_url('/')); ?>" class="btn">Till startsidan</a><button type="button" class="btn secondary" id="contact-reset">Skicka en till</button></div></div>
      </div>
      <aside class="aside" aria-live="polite">
        <div data-aside="projekt" class="acard branch"><div class="person"><span class="avatar"><img src="<?php echo arvinge_asset('28f67e62618ed96125d8841d7bf9f4ca.jpg'); ?>" alt=""></span><span><span class="pn">Pär Johansson</span><span class="pr">Budskap, koncept och positionering</span><a class="pm" href="mailto:par@arvinge.se">par@arvinge.se</a></span></div><div class="person"><span class="avatar"><img src="<?php echo arvinge_asset('91d83c7dc86c14f3908c77a7f7848894.jpg'); ?>" alt=""></span><span><span class="pn"><img class="person-name-image" src="<?php echo arvinge_asset('person-01.png'); ?>" alt="" width="387" height="56"></span><span class="pr">Teknik, webbutveckling och digitalisering</span><a class="pm" href="mailto:max@arvinge.se">max@arvinge.se</a></span></div></div>
        <div data-aside="event" class="branch" hidden><div class="acard"><div class="person"><span class="avatar"><img src="<?php echo arvinge_asset('2397ebc4ed3eba0fe699a31ffa439be3.jpg'); ?>" alt=""></span><span><span class="pn">Johan Zetterstedt</span><span class="pr">Mötesplatser och event</span><a class="pm" href="mailto:johan@arvinge.se">johan@arvinge.se</a></span></div></div><div class="acard"><p class="aside-heading">Först vad. Sen varför. <em>Därefter hur.</em></p><ol class="steps"><li><b>Vad</b><span>Vad ska vi samlas kring – och vilka behöver vara där?</span></li><li><b>Varför</b><span>Vi prövar idén mot syftet innan något bokas.</span></li><li><b>Hur</b><span>Innehåll, förberedelser, genomförande – och uppföljning från start.</span></li></ol></div></div>
        <div data-aside="ovrigt" class="acard branch" hidden><p class="company-heading">Arvinge kommunikation AB</p><p class="company-address">Johan Tillanders Väg 17<br>168 52 Bromma</p><a href="<?php echo arvinge_page('press'); ?>" class="tlink">Till pressrummet →</a></div>
        <div class="acard call-card"><span><span class="call-label">Hellre ringa?</span><a href="tel:+4687450555" class="call-number">08-745 05 55</a></span><a href="tel:+4687450555" class="navlogin" aria-label="Ring Arvinge">☎</a></div>
      </aside>
    </div>
  </section>
</main>
<?php get_footer(); ?>
