(() => {
  const progress = document.querySelector('.post-progress');
  const article = document.querySelector('.post-shell');
  if (progress && article && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    let scheduled = false;
    const update = () => {
      const start = article.getBoundingClientRect().top + scrollY;
      const end = article.getBoundingClientRect().bottom + scrollY - innerHeight;
      const fraction = end > start ? Math.min(1, Math.max(0, (scrollY - start) / (end - start))) : 1;
      progress.style.transform = `scaleX(${fraction})`;
      scheduled = false;
    };
    const requestUpdate = () => {
      if (!scheduled) {
        scheduled = true;
        requestAnimationFrame(update);
      }
    };
    addEventListener('scroll', requestUpdate, { passive: true });
    addEventListener('resize', requestUpdate);
    requestUpdate();
  }

  const copyButton = document.querySelector('.post-copy-link');
  if (copyButton) {
    copyButton.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(copyButton.dataset.url);
        copyButton.textContent = 'Länken kopierad';
        setTimeout(() => { copyButton.textContent = 'Kopiera länk'; }, 2500);
      } catch (_) {
        copyButton.textContent = 'Kunde inte kopiera';
        setTimeout(() => { copyButton.textContent = 'Kopiera länk'; }, 2500);
      }
    });
  }
})();
