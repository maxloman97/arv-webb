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
    document.querySelectorAll('.goal-arrow').forEach((a, i) => { a.textContent = i === index ? '↑' : '→'; });
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
    let scheduled = false;
    const update = () => { scheduled = false; const r = section.getBoundingClientRect(); const travel = Math.max(1, r.height - innerHeight); const p = Math.max(0, Math.min(1, -r.top / travel)); chars.forEach((c, i) => { const t = Math.max(0, Math.min(1, (p * 1.35 - i / chars.length) / .35)); c.style.opacity = String(t); c.style.filter = t > 0 && t < 1 ? `blur(${(1-t)*5}px)` : 'none'; }); };
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
  if (video && !matchMedia('(prefers-reduced-motion: reduce)').matches && !navigator.connection?.saveData) {
    const start = () => { video.src = matchMedia('(max-width: 600px)').matches ? video.dataset.mobile : video.dataset.desktop; video.addEventListener('playing', () => { video.style.opacity = '1'; }, { once: true }); video.play().catch(() => {}); };
    if ('requestIdleCallback' in window) requestIdleCallback(start, { timeout: 3000 }); else setTimeout(start, 1500);
  }
})();
