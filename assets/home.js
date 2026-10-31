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
  document.querySelectorAll('[data-goal]').forEach(b => b.addEventListener('click', () => select('[data-goal]', '[data-goal-panel]', Number(b.dataset.goal))));
  document.querySelectorAll('[data-case]').forEach(b => b.addEventListener('click', () => select('[data-case]', '[data-case-panel]', Number(b.dataset.case))));
  const video = document.querySelector('.hero-video');
  if (video && !matchMedia('(prefers-reduced-motion: reduce)').matches && !navigator.connection?.saveData) {
    const start = () => { video.src = matchMedia('(max-width: 600px)').matches ? video.dataset.mobile : video.dataset.desktop; video.addEventListener('playing', () => { video.style.opacity = '1'; }, { once: true }); video.play().catch(() => {}); };
    if ('requestIdleCallback' in window) requestIdleCallback(start, { timeout: 3000 }); else setTimeout(start, 1500);
  }
})();
