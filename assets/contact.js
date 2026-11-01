(() => {
  const form = document.getElementById('contact-form');
  if (!form) return;
  const types = [...form.querySelectorAll('[data-type]')];
  const branches = [...form.querySelectorAll('[data-branch]')];
  const asides = [...document.querySelectorAll('[data-aside]')];
  const thanks = document.getElementById('contact-thanks');
  const error = document.getElementById('form-error');
  const messages = { projekt: '#msgP', event: '#msgE', ovrigt: '#msgO' };
  const people = { projekt: 'Pär eller Max', event: 'Johan', ovrigt: 'Någon av oss' };
  let type = 'projekt';

  function choose(next) {
    type = next;
    form.elements.type.value = next;
    types.forEach(button => {
      const active = button.dataset.type === next;
      button.classList.toggle('on', active);
      button.setAttribute('aria-pressed', String(active));
    });
    branches.forEach(section => { section.hidden = section.dataset.branch !== next; });
    asides.forEach(section => { section.hidden = section.dataset.aside !== next; });
    clearErrors();
  }
  types.forEach(button => button.addEventListener('click', () => choose(button.dataset.type)));
  form.querySelectorAll('[data-chip]').forEach(button => button.addEventListener('click', () => {
    const active = button.getAttribute('aria-pressed') !== 'true';
    button.classList.toggle('on', active);
    button.setAttribute('aria-pressed', String(active));
  }));
  function clearErrors() {
    form.querySelectorAll('[data-error]').forEach(node => { node.hidden = true; });
    form.querySelectorAll('[aria-invalid]').forEach(node => node.removeAttribute('aria-invalid'));
    error.hidden = true;
  }
  form.querySelectorAll('input,textarea').forEach(input => input.addEventListener('input', () => {
    input.removeAttribute('aria-invalid');
    const marker = input.closest('.field,.fsec')?.querySelector('[data-error]');
    if (marker) marker.hidden = true;
  }));
  const mark = (input, key) => {
    input.setAttribute('aria-invalid', 'true');
    const marker = input.closest('.field,.fsec')?.querySelector(`[data-error="${key}"]`);
    if (marker) marker.hidden = false;
  };

  form.addEventListener('submit', async event => {
    event.preventDefault();
    clearErrors();
    const name = form.elements.name;
    const email = form.elements.email;
    const consent = form.elements.consent;
    const message = form.querySelector(messages[type]);
    let firstInvalid = null;
    const invalid = (input, key) => { mark(input, key); firstInvalid ||= input; };
    if (!message.value.trim()) invalid(message, 'message');
    if (!name.value.trim()) invalid(name, 'name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) invalid(email, 'email');
    if (!consent.checked) invalid(consent, 'consent');
    if (firstInvalid) {
      error.textContent = 'Några fält behöver fyllas i innan vi kan skicka.';
      error.hidden = false;
      firstInvalid.focus();
      return;
    }
    const data = new FormData(form);
    data.set('message', message.value.trim());
    data.set('nonce', window.arvingeContact?.nonce || '');
    form.querySelectorAll('[data-chip][aria-pressed="true"]').forEach(button => data.append(button.dataset.chip + '[]', button.dataset.value));
    const submit = form.querySelector('[type="submit"]');
    submit.disabled = true;
    submit.textContent = 'Skickar…';
    try {
      if (window.arvingeContact?.preview) {
        await new Promise(resolve => setTimeout(resolve, 350));
      } else {
        const response = await fetch(window.arvingeContact.endpoint, { method: 'POST', body: data, credentials: 'same-origin' });
        const result = await response.json();
        if (!response.ok || !result.success) throw new Error(result.data?.message || 'Meddelandet kunde inte skickas.');
      }
      document.getElementById('thanks-name').textContent = name.value.trim().split(/\s+/)[0];
      document.getElementById('thanks-person').textContent = people[type];
      form.hidden = true;
      thanks.hidden = false;
      thanks.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } catch (failure) {
      error.textContent = failure.message || 'Meddelandet kunde inte skickas just nu.';
      error.hidden = false;
    } finally {
      submit.disabled = false;
      submit.textContent = 'Skicka förfrågan';
    }
  });
  document.getElementById('contact-reset').addEventListener('click', () => {
    form.reset();
    form.querySelectorAll('[data-chip]').forEach(button => { button.classList.remove('on'); button.setAttribute('aria-pressed', 'false'); });
    choose(new URLSearchParams(location.search).get('typ') === 'event' ? 'event' : 'projekt');
    thanks.hidden = true;
    form.hidden = false;
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
  if (new URLSearchParams(location.search).get('typ') === 'event') choose('event');
})();
