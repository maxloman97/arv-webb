(() => {
  const nav = document.getElementById('site-nav');
  const menu = document.getElementById('mmenu');
  const burger = document.querySelector('.navburger');
  const closeMenu = () => { if (!menu || !burger) return; menu.hidden = true; burger.classList.remove('on'); burger.setAttribute('aria-expanded', 'false'); burger.setAttribute('aria-label', 'Öppna menyn'); document.documentElement.style.overflow = ''; };
  burger?.addEventListener('click', () => { const open = menu.hidden; menu.hidden = !open; burger.classList.toggle('on', open); burger.setAttribute('aria-expanded', String(open)); burger.setAttribute('aria-label', open ? 'Stäng menyn' : 'Öppna menyn'); document.documentElement.style.overflow = open ? 'hidden' : ''; });
  menu?.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
  const onScroll = () => nav?.classList.toggle('scrolled', scrollY > 8);
  onScroll(); addEventListener('scroll', onScroll, { passive: true });
  const select = (buttonSelector, panelSelector, index) => { document.querySelectorAll(buttonSelector).forEach((b, i) => { const active = i === index; b.classList.toggle('on', active); b.setAttribute('aria-pressed', String(active)); }); document.querySelectorAll(panelSelector).forEach((p, i) => { p.hidden = i !== index; }); };
  document.querySelectorAll('[data-goal]').forEach(b => b.addEventListener('click', () => {
    const index = Number(b.dataset.goal);
    select('[data-goal]', '[data-goal-panel]', index);
    document.querySelectorAll('[data-goal-accordion]').forEach((p, i) => { p.hidden = i !== index; });
    document.querySelectorAll('.goal-arrow').forEach((a, i) => { a.textContent = i === index && innerWidth <= 1000 ? '↑' : '→'; });
  }));
  document.querySelectorAll('[data-case]').forEach(b => b.addEventListener('click', () => select('[data-case]', '[data-case-panel]', Number(b.dataset.case))));
  const goalSection = document.querySelector('.goals-sec');
  const updateGoals = () => { if (!goalSection) return; const r = goalSection.getBoundingClientRect(); goalSection.classList.toggle('light', r.top < innerHeight * .5 && r.bottom > innerHeight * .5); };
  updateGoals(); addEventListener('scroll', updateGoals, { passive: true }); addEventListener('resize', updateGoals);
  const statement = document.querySelector('.stmt');
  if (statement && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const walker = document.createTreeWalker(statement, NodeFilter.SHOW_TEXT);
    const nodes = []; while (walker.nextNode()) nodes.push(walker.currentNode);
    const chars = [];
    nodes.forEach(node => { const frag = document.createDocumentFragment(); for (const ch of node.textContent) { if (/\s/.test(ch)) frag.append(ch); else { const span = document.createElement('span'); span.className = 'stmt-char'; span.textContent = ch; frag.append(span); chars.push(span); } } node.replaceWith(frag); });
    const section = statement.closest('.statement');
    statement.classList.add('is-animated');
    const clamp = value => Math.max(0, Math.min(1, value));
    const ghost = [50, 50, 59], soft = [175, 178, 206], ink = [244, 245, 249];
    const mix = (a, b, k) => `rgb(${a.map((v, i) => Math.round(v + (b[i] - v) * k)).join(',')})`;
    let scheduled = false;
    const update = () => {
      scheduled = false;
      const H = innerHeight;
      const y = -section.getBoundingClientRect().top / H;
      const rise = .205 * (1 - clamp(y / .74)) ** 2 * H;
      const progress = clamp((y + .13) / 2.03);
      section.style.setProperty('--rise', `${rise.toFixed(1)}px`);
      chars.forEach((c, i) => {
        const t = clamp((progress * 1.16 - i / chars.length) / .16);
        if (t >= 1) { c.style.opacity = '1'; c.style.color = 'inherit'; c.style.filter = 'none'; }
        else if (t <= 0) { c.style.opacity = '0'; c.style.color = mix(ghost, ghost, 0); c.style.filter = 'none'; }
        else if (t < .35) { const k = t / .35; c.style.opacity = k.toFixed(3); c.style.color = mix(ghost, ghost, 0); c.style.filter = `blur(${(8 - 6.5 * k).toFixed(2)}px)`; }
        else if (t < .7) { const k = (t - .35) / .35; c.style.opacity = '1'; c.style.color = mix(ghost, soft, k); c.style.filter = `blur(${(1.5 * (1 - k)).toFixed(2)}px)`; }
        else { const k = (t - .7) / .3; c.style.opacity = '1'; c.style.color = mix(soft, ink, k); c.style.filter = 'none'; }
      });
    };
    const schedule = () => { if (!scheduled) { scheduled = true; requestAnimationFrame(update); } };
    update(); addEventListener('scroll', schedule, { passive: true }); addEventListener('resize', schedule);
  }
  if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const headings = document.querySelectorAll('.hero h1, main h2.h2');
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.querySelectorAll('.reveal-char').forEach((span, i) => {
        span.style.animationDelay = `${(entry.target.matches('h1') ? .45 : .08) + i * .012}s`;
        span.classList.add('revealing');
      });
      observer.unobserve(entry.target);
    }), { threshold: .15 });
    headings.forEach(heading => {
      const walker = document.createTreeWalker(heading, NodeFilter.SHOW_TEXT);
      const nodes = []; while (walker.nextNode()) nodes.push(walker.currentNode);
      nodes.forEach(node => { const frag = document.createDocumentFragment(); for (const ch of node.textContent) { if (/\s/.test(ch)) frag.append(ch); else { const span = document.createElement('span'); span.className = 'reveal-char'; span.textContent = ch; frag.append(span); } } node.replaceWith(frag); });
      observer.observe(heading);
    });
  }
  const video = document.querySelector('.hero-video');
  const still = document.querySelector('.hero-bg img.hero-img');
  const hero = document.querySelector('.hero');
  const connection = navigator.connection;
  const skipVideo = matchMedia('(prefers-reduced-motion: reduce)').matches ||
    connection?.saveData || /(^|\b)(slow-2g|2g)(\b|$)/.test(connection?.effectiveType || '');
  if (video && still && hero && !skipVideo) {
    let started = false;
    let firstFrameShown = false;
    let inView = false;
    const play = () => {
      if (!started || !inView || document.hidden) return;
      video.play().catch(() => { video.style.opacity = '0'; });
    };
    const showFirstFrame = () => {
      if (firstFrameShown || !inView || document.hidden || video.readyState < HTMLMediaElement.HAVE_CURRENT_DATA) return;
      const reveal = () => { if (inView && !document.hidden) { video.style.opacity = '1'; firstFrameShown = true; } };
      if ('requestVideoFrameCallback' in video) {
        video.requestVideoFrameCallback(reveal);
      } else {
        requestAnimationFrame(() => requestAnimationFrame(reveal));
      }
    };
    video.addEventListener('playing', showFirstFrame);
    video.addEventListener('loadeddata', showFirstFrame);
    video.addEventListener('error', () => { video.style.opacity = '0'; });
    const start = () => {
      if (started || !inView || document.hidden) return;
      started = true;
      video.preload = 'auto';
      video.src = matchMedia('(max-width: 600px)').matches ? video.dataset.mobile : video.dataset.desktop;
      video.load();
      play();
    };
    const whenIdle = () => {
      if ('requestIdleCallback' in window) requestIdleCallback(start, { timeout: 5000 });
      else setTimeout(start, 1200);
    };
    const pageReady = document.readyState === 'complete' ? Promise.resolve() :
      new Promise(resolve => addEventListener('load', resolve, { once: true }));
    const imageReady = still.complete && still.naturalWidth ? Promise.resolve() :
      new Promise(resolve => { still.addEventListener('load', resolve, { once: true }); still.addEventListener('error', resolve, { once: true }); });
    Promise.all([pageReady, imageReady, document.fonts?.ready || Promise.resolve()]).then(async () => {
      if (!still.naturalWidth) return;
      if (still.decode) await still.decode().catch(() => {});
      if (!('IntersectionObserver' in window)) { inView = true; whenIdle(); return; }
      const observer = new IntersectionObserver(entries => {
        inView = entries[0].isIntersecting;
        if (inView) { if (started) play(); else whenIdle(); }
        else if (started) video.pause();
      });
      observer.observe(hero);
      document.addEventListener('visibilitychange', () => { if (document.hidden) video.pause(); else play(); });
    });
  }
})();
