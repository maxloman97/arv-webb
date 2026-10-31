(() => {
  const root = document.querySelector('.forum-page');
  if (!root) return;
  const track = root.querySelector('.tl-track');
  const cards = [...root.querySelectorAll('.tl-card')];
  const rails = [...root.querySelectorAll('.tl-yr')];
  const prev = root.querySelector('#tl-prev');
  const next = root.querySelector('#tl-next');
  const current = root.querySelector('#tl-current');
  let index = 0;
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  function mark(i) {
    index = Math.max(0, Math.min(cards.length - 1, i));
    cards.forEach((card, n) => card.classList.toggle('on', n === index));
    rails.forEach((rail, n) => {
      rail.classList.toggle('on', n === index);
      rail.setAttribute('aria-current', String(n === index));
    });
    current.textContent = String(index + 1).padStart(2, '0');
    prev.disabled = index === 0;
    next.disabled = index === cards.length - 1;
    const max = track.scrollWidth - track.clientWidth;
    document.documentElement.style.setProperty('--tp', String(max > 0 ? track.scrollLeft / max : 0));
  }
  function go(i) {
    i = Math.max(0, Math.min(cards.length - 1, i));
    const pad = parseFloat(getComputedStyle(track).paddingLeft) || 0;
    track.scrollTo({ left: cards[i].offsetLeft - pad, behavior: reduce ? 'instant' : 'smooth' });
    mark(i);
  }
  rails.forEach((button, i) => button.addEventListener('click', () => go(i)));
  prev.addEventListener('click', () => go(index - 1));
  next.addEventListener('click', () => go(index + 1));
  let scrolling = false;
  track.addEventListener('scroll', () => {
    if (scrolling) return;
    scrolling = true;
    requestAnimationFrame(() => {
      scrolling = false;
      const pad = parseFloat(getComputedStyle(track).paddingLeft) || 0;
      const max = track.scrollWidth - track.clientWidth;
      let closest = 0, distance = Infinity;
      cards.forEach((card, i) => {
        const d = Math.abs(card.offsetLeft - pad - track.scrollLeft);
        if (d < distance) { distance = d; closest = i; }
      });
      if (max > 0 && track.scrollLeft / max > .995) closest = cards.length - 1;
      mark(closest);
    });
  }, { passive: true });

  const process = [...root.querySelectorAll('.pstep')];
  const headings = [...root.querySelectorAll('.proc-h span')];
  function updateProcess() {
    let active = 0;
    const line = innerHeight * .55;
    process.forEach((item, i) => { if (item.getBoundingClientRect().top < line) active = i; });
    process.forEach((item, i) => {
      item.classList.toggle('on', i === active);
      item.classList.toggle('past', i < active);
    });
    headings.forEach((item, i) => item.classList.toggle('lit', i === active || active === 3));
  }
  updateProcess();
  addEventListener('scroll', updateProcess, { passive: true });
  addEventListener('resize', updateProcess);

  root.querySelectorAll('.faq-q').forEach(button => button.addEventListener('click', () => {
    const opening = button.getAttribute('aria-expanded') !== 'true';
    root.querySelectorAll('.faq-q').forEach(other => {
      other.setAttribute('aria-expanded', 'false');
      document.getElementById(other.getAttribute('aria-controls')).hidden = true;
    });
    if (opening) {
      button.setAttribute('aria-expanded', 'true');
      document.getElementById(button.getAttribute('aria-controls')).hidden = false;
    }
  }));
})();
