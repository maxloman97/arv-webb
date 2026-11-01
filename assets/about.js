(() => {
  const story = document.querySelector('.about-page .story');
  if (!story) return;
  const pin = story.querySelector('.story-pin');
  const chapters = [...story.querySelectorAll('.ch')];
  const controls = [...story.querySelectorAll('.chbar')];
  const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
  let active = 0;
  const desktop = () => innerWidth > 820 && innerHeight <= 1600;
  function setActive(i) {
    i = Math.max(0, Math.min(chapters.length - 1, i));
    if (active === i) return;
    active = i;
    chapters.forEach((chapter, n) => {
      chapter.classList.toggle('on', n === i);
      chapter.classList.toggle('past', n < i);
    });
    controls.forEach((control, n) => {
      control.classList.toggle('on', n === i);
      control.classList.toggle('done', n < i);
      control.setAttribute('aria-current', String(n === i));
    });
  }
  function measure() {
    if (desktop()) {
      story.style.height = Math.round(innerHeight * (chapters.length * .7 + 1)) + 'px';
      pin.style.height = innerHeight + 'px';
    } else {
      story.style.height = '';
      pin.style.height = '';
    }
    sync();
  }
  function sync() {
    if (!desktop()) return;
    const total = story.offsetHeight - innerHeight;
    const progress = total > 0 ? Math.max(0, Math.min(1, -story.getBoundingClientRect().top / total)) : 0;
    setActive(Math.min(chapters.length - 1, Math.floor(progress * chapters.length * .999)));
  }
  controls.forEach((control, i) => control.addEventListener('click', () => {
    if (!desktop()) return;
    const top = story.getBoundingClientRect().top + scrollY;
    const total = story.offsetHeight - innerHeight;
    scrollTo({ top: top + total * (i + .5) / chapters.length, behavior: reduced ? 'instant' : 'smooth' });
  }));
  measure();
  addEventListener('scroll', sync, { passive: true });
  addEventListener('resize', measure);
})();
