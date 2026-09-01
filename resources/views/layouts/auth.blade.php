<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'SOULAMI CAR')</title>

<link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  :root{
    --ink:#0f172a; --muted:#6b7280; --line:#e6e8ee;
    --primary:#4f46e5; --primary-tint:#eef0fe; --danger:#ef4444; --danger-tint:#fdeaea;
    --success:#16a34a; --success-tint:#e7f6ec;
  }
  *{box-sizing:border-box}
  body{margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;color:var(--ink)}
  a{text-decoration:none;color:var(--primary);font-weight:600}

  .auth{display:flex;min-height:100vh}

  /* ---- left brand panel ---- */
  .auth-left{
    flex:1;position:relative;overflow:hidden;color:#fff;padding:48px 52px;
    background:linear-gradient(135deg,#4f46e5 0%,#4338ca 55%,#3730a3 100%);
    display:flex;flex-direction:column;justify-content:space-between;
  }
  .auth-left::after{content:"";position:absolute;right:-120px;bottom:-120px;width:360px;height:360px;
    border-radius:50%;background:rgba(255,255,255,.08)}
  .auth-left::before{content:"";position:absolute;left:-80px;top:-80px;width:240px;height:240px;
    border-radius:50%;background:rgba(255,255,255,.06)}
  .al-brand{display:flex;align-items:center;gap:12px;position:relative;z-index:1}
  .al-brand .logo{width:46px;height:46px;border-radius:13px;background:rgba(255,255,255,.15);
    display:grid;place-items:center;font-size:24px}
  .al-brand b{font-size:20px;font-weight:800;letter-spacing:.3px}
  .al-brand span{display:block;font-size:12px;opacity:.8;font-weight:500}
  .al-hero{position:relative;z-index:1}
  .al-hero h1{font-size:30px;font-weight:800;line-height:1.25;margin:0 0 14px}
  .al-hero p{opacity:.85;font-size:14.5px;line-height:1.6;max-width:380px;margin:0}
  .al-feats{position:relative;z-index:1;display:flex;flex-direction:column;gap:12px}
  .al-feats div{display:flex;align-items:center;gap:10px;font-size:14px;opacity:.92}
  .al-feats i{font-size:18px}

  /* ---- right form area ---- */
  .auth-right{width:560px;max-width:100%;display:flex;align-items:center;justify-content:center;
    padding:32px 24px;background:#f6f7f9}
  .auth-card{width:100%;max-width:400px}
  .card-brand{display:none;align-items:center;gap:10px;margin-bottom:26px;justify-content:center}
  .card-brand .logo{width:40px;height:40px;border-radius:11px;background:var(--primary);color:#fff;
    display:grid;place-items:center;font-size:20px}
  .card-brand b{font-size:17px;font-weight:800}
  .auth-card h2{font-size:23px;font-weight:800;margin:0 0 4px}
  .auth-card .sub{color:var(--muted);font-size:13.5px;margin:0 0 24px}

  .form-label{font-size:12.5px;font-weight:600;color:#4b5563;margin-bottom:6px}
  .form-control{border:1px solid var(--line);border-radius:11px;font-size:14px;padding:11px 13px;color:var(--ink)}
  .form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px var(--primary-tint)}
  .input-ico{position:relative}
  .input-ico i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9aa1ac;font-size:16px}
  .input-ico .form-control{padding-left:40px}

  .btn-brand{background:var(--primary);border:0;color:#fff;font-weight:700;border-radius:11px;
    padding:12px 16px;font-size:14px;width:100%;display:inline-flex;align-items:center;justify-content:center;gap:8px}
  .btn-brand:hover{background:#4338ca;color:#fff}

  .form-check-input:checked{background-color:var(--primary);border-color:var(--primary)}
  .form-check-label{font-size:13px;color:#4b5563}

  .flash{border-radius:11px;padding:12px 14px;font-size:13.5px;margin-bottom:18px;border:1px solid transparent}
  .flash.ok{background:var(--success-tint);color:#15803d;border-color:#bfe5cb}
  .invalid-feedback{font-size:12px}

  .auth-foot{text-align:center;font-size:13.5px;color:var(--muted);margin-top:22px}

  @media(max-width:991px){
    .auth-left{display:none}
    .auth-right{width:100%}
    .card-brand{display:flex}
  }
</style>
</head>
<body>

<div class="auth">
  <div class="auth-left">
    <div class="al-brand">
      <div class="logo"><i class="bi bi-car-front-fill"></i></div>
      <div><b>Soulami Car</b><span>Location de voiture</span></div>
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
        <div class="logo"><i class="bi bi-car-front-fill"></i></div>
        <b>SOULAMI CAR</b>
      </div>
      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>
