<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="@yield('description')">
  <title>@yield('title') | Car manager</title>
  <script>
    (function () {
      const preference = localStorage.getItem('car-manager-theme') || 'system';
      const useDarkTheme = preference === 'dark'
        || (preference === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
      document.documentElement.dataset.theme = useDarkTheme ? 'dark' : 'light';
    })();
  </script>
  <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{color-scheme:light;--ink:#172033;--muted:#586579;--surface:#fff;--page:#f3f6fb;--line:#e1e7f0;--blue:#1769d2}
    :root[data-theme="dark"]{color-scheme:dark;--ink:#edf2f8;--muted:#b3bfce;--surface:#202936;--page:#111821;--line:#354253;--blue:#8dbbff}
    *{box-sizing:border-box}
    body{margin:0;background:var(--page);color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.7}
    a{color:var(--blue)}
    .legal-header{display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:980px;margin:0 auto;padding:24px}
    .legal-brand{display:inline-flex;align-items:center;gap:10px;color:var(--ink);font-weight:800;text-decoration:none}
    .legal-brand i{display:grid;place-items:center;width:40px;height:40px;border-radius:12px;background:#1769d2;color:#fff;font-size:21px}
    .legal-back{font-size:14px;font-weight:600;text-decoration:none}
    .legal-main{max-width:900px;margin:12px auto 64px;padding:0 24px}
    .legal-card{padding:clamp(24px,5vw,56px);border:1px solid var(--line);border-radius:20px;background:var(--surface);box-shadow:0 18px 48px rgba(20,35,60,.08)}
    .legal-eyebrow{margin:0 0 8px;color:var(--blue);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase}
    h1{margin:0 0 12px;font-size:clamp(30px,5vw,42px);font-weight:800;letter-spacing:-.04em;line-height:1.15}
    .legal-intro{margin:0 0 32px;color:var(--muted);font-size:17px}
    .legal-content h2{margin:30px 0 10px;font-size:20px;font-weight:700;line-height:1.35}
    .legal-content p,.legal-content li{color:var(--muted);font-size:15px}
    .legal-content p{margin:0 0 12px}
    .legal-content ul{padding-left:22px;margin:0 0 14px}
    .legal-footer{margin-top:32px;padding-top:20px;border-top:1px solid var(--line);color:var(--muted);font-size:13px}
    @media(max-width:575px){.legal-header{padding:18px}.legal-main{padding:0 14px}.legal-card{border-radius:14px}.legal-back span{display:none}}
  </style>
</head>
<body>
  <header class="legal-header">
    <a class="legal-brand" href="{{ route('login') }}">
      <i class="bi bi-car-front" aria-hidden="true"></i>
      <span>Car manager</span>
    </a>
    <a class="legal-back" href="{{ route('login') }}">
      <i class="bi bi-arrow-left" aria-hidden="true"></i>
      <span>Retour à la connexion</span>
    </a>
  </header>
  <main class="legal-main">
    <article class="legal-card">
      @yield('content')
      <footer class="legal-footer">
        Car manager — outil de gestion pour les agences de location de véhicules.
      </footer>
    </article>
  </main>
</body>
</html>
