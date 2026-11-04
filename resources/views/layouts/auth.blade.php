<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Car manager')</title>
<script>
  (function () {
    const preference = localStorage.getItem('car-manager-theme') || 'system';
    const useDarkTheme = preference === 'dark'
      || (preference === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.dataset.theme = useDarkTheme ? 'dark' : 'light';
    const textColor = localStorage.getItem('car-manager-text-color')
      || localStorage.getItem('car-manager-login-text-color');
    if (['navy', 'blue', 'green', 'burgundy', 'purple', 'mixed'].includes(textColor)) {
      document.documentElement.dataset.appTextColor = textColor;
      localStorage.setItem('car-manager-text-color', textColor);
      localStorage.removeItem('car-manager-login-text-color');
    }
  })();
</script>

<link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  :root{
    --ink:#0f172a; --muted:#6b7280; --line:#e6e8ee;
    --primary:#1877f2; --primary-tint:#e7f0ff; --bs-primary:#1877f2; --bs-primary-rgb:24,119,242;
    --danger:#ef4444; --danger-tint:#fdeaea;
    --success:#16a34a; --success-tint:#e7f6ec;
  }
  *{box-sizing:border-box}
  body{margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;color:var(--ink)}
  a{text-decoration:none;color:var(--primary);font-weight:600}
  .btn-primary{
    --bs-btn-color:#fff;--bs-btn-bg:var(--primary);--bs-btn-border-color:var(--primary);
    --bs-btn-hover-color:#fff;--bs-btn-hover-bg:#1664d9;--bs-btn-hover-border-color:#155dc9;
    --bs-btn-active-color:#fff;--bs-btn-active-bg:#155dc9;--bs-btn-active-border-color:#155dc9;
    --bs-btn-disabled-color:#fff;--bs-btn-disabled-bg:var(--primary);--bs-btn-disabled-border-color:var(--primary)}

  .auth{display:flex;min-height:100vh}

  /* ---- left brand panel ---- */
  .auth-left{
    flex:1;position:relative;overflow:hidden;color:#fff;padding:48px 52px;
    background:linear-gradient(120deg,#0754c7 0%,#1877f2 24%,#0866ff 50%,#1d6fe8 74%,#064cb5 100%);
    display:grid;grid-template-rows:auto minmax(0,1fr) auto;align-items:center;
  }
  .auth-left::after{content:"";position:absolute;right:-120px;bottom:-120px;width:360px;height:360px;
    border-radius:50%;background:rgba(255,255,255,.08)}
  .auth-left::before{content:"";position:absolute;left:-80px;top:-80px;width:240px;height:240px;
    border-radius:50%;background:rgba(255,255,255,.06)}
  .al-brand{grid-row:1;justify-self:center;display:flex;align-items:center;gap:12px;position:relative;z-index:1;
    animation:brand-enter-from-right .8s cubic-bezier(.2,.8,.2,1) both}
  @keyframes brand-enter-from-right{
    from{opacity:0;transform:translateX(72px) rotate(4deg)}
    75%{opacity:1;transform:translateX(-5px) rotate(-.5deg)}
    to{opacity:1;transform:translateX(0) rotate(0)}
  }
  @media(prefers-reduced-motion:reduce){.al-brand{animation:none}}
  .al-brand .logo,.card-brand .logo{width:46px;height:46px;border-radius:13px;
    background:linear-gradient(135deg,#a8ccff 0%,#1877f2 30%,#0866ff 58%,#0754c7 82%,#4b91f1 100%);
    color:#fff;display:grid;place-items:center;font-size:24px;
    box-shadow:0 6px 16px rgba(0,44,110,.28),inset 0 1px rgba(255,255,255,.55)}
  .al-brand .logo i,.card-brand .logo i{color:#fff}
  .al-brand b{font-size:20px;font-weight:800;letter-spacing:.3px}
  .al-brand span{display:block;font-size:12px;opacity:.8;font-weight:500}
  .al-hero{grid-row:2;position:relative;z-index:1;text-align:center}
  .al-hero h1{font-size:30px;font-weight:800;line-height:1.25;margin:0 0 14px}
  .al-hero p{opacity:.85;font-size:14.5px;line-height:1.6;max-width:380px;margin:0 auto}
  .al-feats{grid-row:3;position:relative;z-index:1;display:flex;flex-direction:column;align-items:flex-start;gap:12px}
  .al-feats div{display:flex;align-items:center;justify-content:flex-start;gap:10px;font-size:14px;opacity:.92;text-align:left}
  .al-feats i{font-size:18px}

  /* ---- right form area ---- */
  .auth-right{width:560px;max-width:100%;display:flex;align-items:center;justify-content:center;
    padding:32px 24px;background:linear-gradient(135deg,#080809 0%,#202023 24%,#0b0b0d 48%,#242428 72%,#09090a 100%);color:#f8fafc}
  .auth-right a{color:#60a5fa}
  .auth-card{width:100%;max-width:400px}
  .card-brand{display:none;align-items:center;gap:10px;margin-bottom:26px;justify-content:center}
  .card-brand .logo{width:40px;height:40px;border-radius:11px;font-size:20px}
  .card-brand b{font-size:17px;font-weight:800}
  .auth-card h2{font-size:23px;font-weight:800;margin:0 0 4px}
  .auth-card .sub{color:#cbd5e1;font-size:13.5px;margin:0 0 24px}

  .form-label{font-size:12.5px;font-weight:600;color:#e5e7eb;margin-bottom:6px}
  .form-control{border:1px solid var(--line);border-radius:11px;font-size:14px;padding:11px 13px;color:var(--ink)}
  .form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px var(--primary-tint)}
  .input-ico{position:relative}
  .input-ico i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9aa1ac;font-size:16px}
  .input-ico .form-control{padding-left:40px}

  .btn-brand{background:var(--primary);border:0;color:#fff;font-weight:700;border-radius:11px;
    padding:12px 16px;font-size:14px;width:100%;display:inline-flex;align-items:center;justify-content:center;gap:8px}
  .btn-brand:hover{background:#1664d9;color:#fff}

  .form-check-input:checked{background-color:var(--primary);border-color:var(--primary)}
  .form-check-label{font-size:13px;color:#e5e7eb}

  .flash{border-radius:11px;padding:12px 14px;font-size:13.5px;margin-bottom:18px;border:1px solid transparent}
  .flash.ok{background:var(--success-tint);color:#15803d;border-color:#bfe5cb}
  .invalid-feedback{font-size:12px}

  .auth-foot{text-align:center;font-size:13.5px;color:#cbd5e1;margin-top:22px}

  .theme-mode-toggle{
    position:fixed;top:20px;right:22px;z-index:10;display:grid;place-items:center;
    width:42px;height:42px;padding:0;border:1px solid rgba(255,255,255,.3);border-radius:50%;
    background:rgba(15,23,42,.72);color:#fff;font-size:18px;cursor:pointer;
    box-shadow:0 4px 14px rgba(0,0,0,.18);backdrop-filter:blur(8px)
  }
  .theme-mode-toggle:hover{background:rgba(15,23,42,.9)}
  .theme-mode-toggle:focus-visible{outline:3px solid #60a5fa;outline-offset:3px}

  .text-color-controls{position:fixed;top:70px;right:22px;z-index:10}
  .text-color-toggle{
    display:grid;place-items:center;width:42px;height:42px;padding:0;border:1px solid rgba(255,255,255,.3);
    border-radius:50%;background:rgba(15,23,42,.72);color:#fff;font-size:18px;cursor:pointer;
    box-shadow:0 4px 14px rgba(0,0,0,.18);backdrop-filter:blur(8px)
  }
  .text-color-toggle:hover{background:rgba(15,23,42,.9)}
  .text-color-toggle:focus-visible,
  .text-color-option:focus-visible{outline:3px solid #60a5fa;outline-offset:3px}
  .text-color-options{
    position:absolute;top:50px;right:0;display:grid;gap:4px;min-width:150px;padding:8px;
    border:1px solid rgba(148,163,184,.35);border-radius:12px;background:#fff;color:#0f172a;
    box-shadow:0 10px 28px rgba(15,23,42,.2)
  }
  .text-color-options[hidden]{display:none}
  .text-color-option{
    display:flex;align-items:center;gap:9px;width:100%;padding:8px;border:0;border-radius:8px;
    background:transparent;color:#0f172a;font:500 13px 'Inter',sans-serif;text-align:left;cursor:pointer
  }
  .text-color-option:hover,
  .text-color-option[aria-pressed="true"]{background:#f1f5f9}
  .text-color-swatch{width:15px;height:15px;flex:none;border:1px solid rgba(15,23,42,.2);border-radius:50%}
  .text-color-option[data-text-color="navy"] .text-color-swatch{background:#1e3a8a}
  .text-color-option[data-text-color="blue"] .text-color-swatch{background:#1d4ed8}
  .text-color-option[data-text-color="green"] .text-color-swatch{background:#166534}
  .text-color-option[data-text-color="burgundy"] .text-color-swatch{background:#991b1b}
  .text-color-option[data-text-color="purple"] .text-color-swatch{background:#6b21a8}
  .text-color-option[data-text-color="mixed"] .text-color-swatch{
    background:linear-gradient(135deg,#7c3aed 0 33%,#1d4ed8 33% 66%,#16a34a 66%)}
  .text-color-option[data-text-color="default"] .text-color-swatch{
    background:linear-gradient(135deg,#2d2208 50%,#f8fafc 50%)
  }

  :root[data-app-text-color="navy"]{--app-text-color:#1e3a8a}
  :root[data-app-text-color="blue"]{--app-text-color:#1d4ed8}
  :root[data-app-text-color="green"]{--app-text-color:#166534}
  :root[data-app-text-color="burgundy"]{--app-text-color:#991b1b}
  :root[data-app-text-color="purple"]{--app-text-color:#6b21a8}
  :root[data-app-text-color="mixed"]{--app-text-color:#0f172a}
  :root[data-theme="dark"][data-app-text-color="navy"]{--app-text-color:#bfdbfe}
  :root[data-theme="dark"][data-app-text-color="blue"]{--app-text-color:#93c5fd}
  :root[data-theme="dark"][data-app-text-color="green"]{--app-text-color:#86efac}
  :root[data-theme="dark"][data-app-text-color="burgundy"]{--app-text-color:#fca5a5}
  :root[data-theme="dark"][data-app-text-color="purple"]{--app-text-color:#d8b4fe}
  :root[data-theme="dark"][data-app-text-color="mixed"]{--app-text-color:#edf0f2}
  :root[data-app-text-color] .auth :is(
    .al-brand b,.al-brand span,.al-hero h1,.al-hero p,.al-feats div,
    .auth-card h2,.auth-card .sub,.auth-card .form-label,.auth-card .form-check-label,
    .auth-card .auth-foot,.auth-card .invalid-feedback
  ){color:var(--app-text-color)!important}
  :root[data-app-text-color] .auth-card .form-control{color:var(--app-text-color)}
  :root[data-app-text-color="mixed"] .auth :is(.al-brand b,.auth-card h2,.al-hero h1){color:#7c3aed!important}
  :root[data-app-text-color="mixed"] .auth :is(a,.auth-card .form-check-label){color:#1d4ed8!important}
  :root[data-app-text-color="mixed"] .auth :is(.form-label,.al-feats div){color:#166534!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .auth :is(.al-brand b,.auth-card h2,.al-hero h1){color:#c4b5fd!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .auth :is(a,.auth-card .form-check-label){color:#93c5fd!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .auth :is(.form-label,.al-feats div){color:#86efac!important}

  :root[data-theme="light"] .auth-right{
    background:linear-gradient(135deg,#fff 0%,#f8fafc 55%,#eef2f7 100%);color:#0f172a
  }
  :root[data-theme="light"] .auth-right a{color:#1664d9}
  :root[data-theme="light"] .auth-card .sub,
  :root[data-theme="light"] .form-check-label,
  :root[data-theme="light"] .auth-foot{color:#64748b}
  :root[data-theme="light"] .form-label{color:#334155}
  :root[data-theme="light"] .theme-mode-toggle{
    border-color:rgba(15,23,42,.14);background:rgba(255,255,255,.88);color:#0f172a
  }
  :root[data-theme="light"] .theme-mode-toggle:hover{background:#fff}

  @media(max-width:991px){
    .auth-left{display:none}
    .auth-right{width:100%}
    .card-brand{display:flex}
  }
  @media(max-width:575px){
    .theme-mode-toggle{top:12px;right:12px}
    .text-color-controls{top:62px;right:12px}
  }
</style>
</head>
<body>

<button class="theme-mode-toggle" type="button" id="themeModeToggle" aria-label="Mode système" title="Mode système">
  <i class="bi bi-display" aria-hidden="true"></i>
</button>
<div class="text-color-controls">
  <button class="text-color-toggle" type="button" id="textColorToggle" aria-label="Choisir la couleur du texte"
          title="Couleur du texte" aria-expanded="false" aria-controls="textColorOptions">
    <i class="bi bi-spellcheck" aria-hidden="true"></i>
  </button>
  <div class="text-color-options" id="textColorOptions" role="group" aria-label="Couleur du texte" hidden>
    <button class="text-color-option" type="button" data-text-color="default" aria-pressed="true">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Original</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="navy" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Bleu marine</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="blue" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Bleu</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="green" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Vert</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="burgundy" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Bordeaux</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="purple" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Violet</span>
    </button>
    <button class="text-color-option" type="button" data-text-color="mixed" aria-pressed="false">
      <span class="text-color-swatch" aria-hidden="true"></span><span>Couleurs mixtes</span>
    </button>
  </div>
</div>

<div class="auth">
  <div class="auth-left">
    <div class="al-brand">
      <div class="logo"><i class="bi bi-car-front"></i></div>
      <div><b>Car manager</b><span>Location de voiture</span></div>
    </div>

    <div class="al-hero">
      <h1>Gérez votre agence<br>de location en toute simplicité.</h1>
      <p>Clients, véhicules, contrats et facturation — tout au même endroit, avec un tableau de bord clair et des contrats PDF en un clic.</p>
    </div>

    <div class="al-feats">
      <div><i class="bi bi-check-circle-fill"></i> Suivi de la flotte en temps réel</div>
      <div><i class="bi bi-check-circle-fill"></i> Contrats &amp; PDF automatisés</div>
      <div><i class="bi bi-check-circle-fill"></i> Alertes assurance &amp; vidange</div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-card">
      <div class="card-brand">
        <div class="logo"><i class="bi bi-car-front"></i></div>
        <b>Car manager</b>
      </div>
      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/ui-click-sound.js') }}"></script>
<script>
  (function () {
    const toggle = document.getElementById('themeModeToggle');
    const textColorToggle = document.getElementById('textColorToggle');
    const textColorOptions = document.getElementById('textColorOptions');
    const textColorChoices = document.querySelectorAll('[data-text-color]');
    const textColors = ['navy', 'blue', 'green', 'burgundy', 'purple', 'mixed'];
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');
    const themes = ['light', 'dark', 'system'];
    const themeDetails = {
      light: { label: 'Clair', icon: 'bi-sun' },
      dark: { label: 'Sombre', icon: 'bi-moon-stars' },
      system: { label: 'Système', icon: 'bi-display' }
    };

    function updateToggle() {
      const preference = localStorage.getItem('car-manager-theme') || 'system';
      const currentTheme = themeDetails[preference] ? preference : 'system';
      const nextTheme = themes[(themes.indexOf(currentTheme) + 1) % themes.length];
      toggle.innerHTML = `<i class="bi ${themeDetails[currentTheme].icon}" aria-hidden="true"></i>`;
      toggle.setAttribute('aria-label', `Mode ${themeDetails[currentTheme].label}. Passer au mode ${themeDetails[nextTheme].label}.`);
      toggle.setAttribute('title', `Mode ${themeDetails[currentTheme].label} · suivant : ${themeDetails[nextTheme].label}`);
      toggle.dataset.nextTheme = nextTheme;
    }

    toggle.addEventListener('click', function () {
      const nextTheme = toggle.dataset.nextTheme;
      localStorage.setItem('car-manager-theme', nextTheme);
      const useDarkTheme = nextTheme === 'dark'
        || (nextTheme === 'system' && systemTheme.matches);
      document.documentElement.dataset.theme = useDarkTheme ? 'dark' : 'light';
      updateToggle();
    });

    systemTheme.addEventListener('change', function (event) {
      if (localStorage.getItem('car-manager-theme') === 'system') {
        document.documentElement.dataset.theme = event.matches ? 'dark' : 'light';
        updateToggle();
      }
    });

    function setTextColor(color) {
      if (color === 'default') {
        delete document.documentElement.dataset.appTextColor;
        localStorage.removeItem('car-manager-text-color');
        localStorage.removeItem('car-manager-login-text-color');
      } else if (textColors.includes(color)) {
        document.documentElement.dataset.appTextColor = color;
        localStorage.setItem('car-manager-text-color', color);
        localStorage.removeItem('car-manager-login-text-color');
      } else {
        return;
      }

      textColorChoices.forEach(function (choice) {
        choice.setAttribute('aria-pressed', String(choice.dataset.textColor === color));
      });
    }

    textColorToggle.addEventListener('click', function () {
      const expanded = textColorToggle.getAttribute('aria-expanded') === 'true';
      textColorToggle.setAttribute('aria-expanded', String(!expanded));
      textColorOptions.hidden = expanded;
    });

    textColorChoices.forEach(function (choice) {
      choice.addEventListener('click', function () {
        setTextColor(choice.dataset.textColor);
        textColorOptions.hidden = true;
        textColorToggle.setAttribute('aria-expanded', 'false');
        textColorToggle.focus();
      });
    });

    document.addEventListener('click', function (event) {
      if (!event.target.closest('.text-color-controls')) {
        textColorOptions.hidden = true;
        textColorToggle.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !textColorOptions.hidden) {
        textColorOptions.hidden = true;
        textColorToggle.setAttribute('aria-expanded', 'false');
        textColorToggle.focus();
      }
    });

    const savedTextColor = localStorage.getItem('car-manager-text-color')
      || localStorage.getItem('car-manager-login-text-color');
    setTextColor(textColors.includes(savedTextColor) ? savedTextColor : 'default');
    updateToggle();
  })();
</script>
</body>
</html>
