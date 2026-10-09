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
    --bg:#f6f7f9; --card:#fff; --line:#eceef2; --ink:#0f172a; --muted:#6b7280;
    --primary:#4f46e5; --primary-tint:#eef0fe;
    --success:#16a34a; --success-tint:#e7f6ec;
    --warning:#f59e0b; --warning-tint:#fef3e2;
    --danger:#ef4444;  --danger-tint:#fdeaea;
    --info:#0ea5e9;    --info-tint:#e6f5fd;
    --sidebar:250px; --radius:16px;
  }
  *{box-sizing:border-box}
  body{margin:0;background:var(--bg);color:var(--ink);
    font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;font-size:14px}
  a{text-decoration:none}

  .sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar);background:var(--card);
    border-right:1px solid var(--line);padding:22px 16px;display:flex;flex-direction:column;z-index:20}
  .brand{display:flex;align-items:center;gap:10px;padding:4px 8px 22px}
  .brand .logo{width:38px;height:38px;border-radius:11px;background:var(--primary);color:#fff;
    display:grid;place-items:center;font-size:20px;box-shadow:0 6px 16px rgba(79,70,229,.35)}
  .brand b{font-size:16px;font-weight:800;letter-spacing:.2px}
  .brand span{display:block;font-size:11px;color:var(--muted);font-weight:500;margin-top:-2px}
  .nav-label{font-size:11px;text-transform:uppercase;letter-spacing:.6px;color:#9aa1ac;font-weight:600;padding:14px 10px 6px}
  .nav-item{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:11px;
    color:#4b5563;font-weight:500;margin-bottom:2px;transition:.15s;width:100%;border:0;background:none;text-align:left}
  .nav-item i{font-size:17px}
  .nav-item:hover{background:#f4f5f7;color:var(--ink)}
  .nav-item.active{background:var(--primary-tint);color:var(--primary);font-weight:600}
  .nav-item .badge{margin-left:auto;font-weight:600}
  .sidebar .foot{margin-top:auto;border-top:1px solid var(--line);padding-top:12px}

  .main{margin-left:var(--sidebar);min-height:100vh}
  .topbar{position:sticky;top:0;z-index:10;background:rgba(246,247,249,.85);backdrop-filter:blur(8px);
    border-bottom:1px solid var(--line);padding:16px 28px;display:flex;align-items:center;gap:16px}
  .topbar h1{font-size:19px;font-weight:700;margin:0}
  .topbar p{margin:0;font-size:12.5px;color:var(--muted)}
  .greet{min-width:0;flex:1}
  .greet h1,.greet p{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .icon-btn{width:40px;height:40px;border-radius:10px;border:1px solid var(--line);background:#fff;
    display:grid;place-items:center;color:#4b5563;position:relative;flex:none}
  .avatar{width:40px;height:40px;border-radius:11px;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;flex:none}
  .content{padding:24px 28px 40px}

  .card2{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);box-shadow:0 1px 2px rgba(16,24,40,.04)}
  .card2 .hd{padding:18px 20px 0;display:flex;align-items:center;justify-content:space-between}
  .card2 .hd h5{font-size:15px;font-weight:700;margin:0}
  .card2 .hd a{font-size:12.5px;color:var(--primary);font-weight:600}
  .kpi{padding:20px}
  a.kpi{display:block;color:inherit;transition:.15s;cursor:pointer}
  a.kpi:hover{box-shadow:0 6px 18px rgba(16,24,40,.08);transform:translateY(-2px);border-color:#dde0e6}
  .kpi .top{display:flex;align-items:flex-start;justify-content:space-between}
  .kpi .ic{width:46px;height:46px;border-radius:13px;display:grid;place-items:center;font-size:22px}
  .kpi .val{font-size:28px;font-weight:800;margin:14px 0 2px;letter-spacing:-.5px}
  .kpi .lbl{color:var(--muted);font-size:13px;font-weight:500}
  .trend{display:inline-flex;align-items:center;gap:3px;font-size:12px;font-weight:600;padding:3px 8px;border-radius:20px}
  .trend.up{color:var(--success);background:var(--success-tint)}
  .trend.down{color:var(--danger);background:var(--danger-tint)}
  .trend.flat{color:var(--muted);background:#f1f3f5}
  .sub{font-size:12.5px;color:var(--muted);margin-top:10px}
  .tint-primary{background:var(--primary-tint);color:var(--primary)}
  .tint-success{background:var(--success-tint);color:var(--success)}
  .tint-warning{background:var(--warning-tint);color:var(--warning)}
  .tint-info{background:var(--info-tint);color:var(--info)}
  .tint-danger{background:var(--danger-tint);color:var(--danger)}
  .legend{display:flex;flex-direction:column;gap:14px}
  .legend .row2{display:flex;align-items:center;gap:10px}
  .legend .dot{width:11px;height:11px;border-radius:4px}
  .legend .row2 .n{margin-left:auto;font-weight:700}
  .legend .row2 .t{color:var(--muted)}
  .ministat{border:1px solid var(--line);border-radius:13px;padding:14px 16px}
  .ministat .k{font-size:12.5px;color:var(--muted)}
  .ministat .v{font-size:24px;font-weight:800;margin-top:4px}
  .alert2{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--line)}
  .alert2:last-child{border-bottom:0}
  .alert2 .ic{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;font-size:17px;flex:none}
  .alert2 .g{flex:1}
  .alert2 .g b{font-size:13.5px}
  .alert2 .g div{font-size:12px;color:var(--muted)}
  table.t2{width:100%;border-collapse:collapse}
  table.t2 th{font-size:11.5px;text-transform:uppercase;letter-spacing:.4px;color:#9aa1ac;font-weight:600;text-align:left;padding:12px 16px;border-bottom:1px solid var(--line)}
  table.t2 td{padding:13px 16px;border-bottom:1px solid var(--line);font-size:13.5px;vertical-align:middle}
  table.t2 tr:last-child td{border-bottom:0}
  table.t2 tr:hover td{background:#fafbfc}
  .pill{font-size:11.5px;font-weight:600;padding:4px 10px;border-radius:20px;display:inline-block}
  .pill.attente{background:var(--warning-tint);color:#b26a02}
  .pill.cours{background:var(--info-tint);color:#0369a1}
  .pill.termine{background:var(--success-tint);color:#15803d}
  .pill.annule{background:var(--danger-tint);color:#b91c1c}
  .cust{display:flex;align-items:center;gap:10px}
  .cust .av{width:32px;height:32px;border-radius:9px;display:grid;place-items:center;font-weight:700;font-size:12px;color:#fff;flex:none}
  .mut{color:var(--muted)}
  .nowrap{white-space:nowrap}

  /* shared: buttons */
  .btn-brand{background:var(--primary);border:0;color:#fff;font-weight:600;border-radius:10px;
    padding:9px 16px;font-size:13.5px;display:inline-flex;align-items:center;gap:7px}
  .btn-brand:hover{background:#4338ca;color:#fff}
  .btn-soft{background:#fff;border:1px solid var(--line);color:#4b5563;font-weight:600;
    border-radius:10px;padding:9px 16px;font-size:13.5px;display:inline-flex;align-items:center;gap:7px}
  .btn-soft:hover{background:#f4f5f7;color:var(--ink)}
  /* variante icone seule : meme hauteur que les boutons voisins */
  .btn-soft.icon-only,.btn-brand.icon-only{padding:9px;width:38px;justify-content:center;gap:0;font-size:15px}

  /* shared: form controls */
  .form-control,.form-select{border:1px solid var(--line);border-radius:10px;font-size:13.5px;
    padding:9px 12px;color:var(--ink)}
  .form-control:focus,.form-select:focus{border-color:var(--primary);box-shadow:0 0 0 3px var(--primary-tint)}
  .form-label{font-size:12.5px;font-weight:600;color:#4b5563;margin-bottom:5px}

  /* shared: table action buttons */
  .act{width:32px;height:32px;border-radius:8px;border:1px solid var(--line);background:#fff;
    display:inline-grid;place-items:center;color:#6b7280;font-size:14px;margin-left:2px}
  .act:hover{background:#f4f5f7;color:var(--ink)}
  .act.view:hover{background:var(--info-tint);color:#0369a1;border-color:transparent}
  .act.edit:hover{background:var(--warning-tint);color:#b26a02;border-color:transparent}
  .act.oil:hover{background:var(--info-tint);color:var(--info);border-color:transparent}
  .act.pdf:hover{background:var(--danger-tint);color:var(--danger);border-color:transparent}
  .act.danger:hover{background:var(--danger-tint);color:var(--danger);border-color:transparent}

  /* shared: page header */
  .page-head{display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px}
  .page-head h2{font-size:22px;font-weight:800;margin:0}
  .page-head p{margin:2px 0 0;color:var(--muted);font-size:13px}

  /* shared: stat mini card */
  .stat{padding:15px 18px}
  .stat .k{font-size:12.5px;color:var(--muted)}
  .stat .v{font-size:26px;font-weight:800;margin-top:2px;line-height:1.1}

  /* shared: flash */
  .flash{border-radius:12px;padding:13px 16px;font-size:13.5px;font-weight:500;margin-bottom:18px;border:1px solid transparent}
  .flash.ok{background:var(--success-tint);color:#15803d;border-color:#bfe5cb}
  .flash.err{background:var(--danger-tint);color:#b91c1c;border-color:#f3c2c2}

  /* shared: form card + sections */
  .form-card{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
    box-shadow:0 1px 2px rgba(16,24,40,.04);padding:22px 24px}
  .section-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;
    color:#9aa1ac;margin:24px 0 14px;padding-bottom:8px;border-bottom:1px solid var(--line);
    display:flex;align-items:center;gap:8px}
  .section-title:first-of-type{margin-top:2px}
  .form-footer{display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:18px;border-top:1px solid var(--line)}
  .form-label{font-size:12.5px;font-weight:600;color:#4b5563;margin-bottom:5px}
  .req{color:var(--danger)}

  /* shared: detail (show) view */
  .detail{width:100%;border-collapse:collapse}
  .detail th{text-align:left;width:230px;font-weight:600;color:var(--muted);font-size:13px;
    padding:12px 6px;border-bottom:1px solid var(--line);vertical-align:top}
  .detail td{padding:12px 6px;border-bottom:1px solid var(--line);font-size:13.5px;font-weight:500}
  .detail tr:last-child th,.detail tr:last-child td{border-bottom:0}

  /* pill variants keyed by enum ->color() */
  .pill.success{background:var(--success-tint);color:#15803d}
  .pill.primary{background:var(--primary-tint);color:var(--primary)}
  .pill.info{background:var(--info-tint);color:#0369a1}
  .pill.warning{background:var(--warning-tint);color:#b26a02}
  .pill.danger{background:var(--danger-tint);color:#b91c1c}
  .pill.secondary{background:#f1f3f5;color:#6b7280}

  /* bootstrap pagination tuned to theme */
  .pagination{gap:4px}
  .page-link{border-radius:9px;border-color:var(--line);color:#4b5563;font-size:13.5px}
  .page-item.active .page-link{background:var(--primary);border-color:var(--primary)}
  .page-link:focus{box-shadow:0 0 0 3px var(--primary-tint)}

  .menu-btn{display:none}
  .sidebar-close{display:none;position:absolute;top:20px;right:16px;width:32px;height:32px;
    border-radius:9px;border:1px solid var(--line);background:#fff;color:#4b5563;
    place-items:center;font-size:16px}
  .sidebar-overlay{display:none}

  @media(max-width:992px){
    .menu-btn{display:grid}
    .sidebar-close{display:grid}
    .sidebar{transform:translateX(-100%);transition:transform .25s ease;box-shadow:0 0 0 rgba(0,0,0,0)}
    .sidebar.open{transform:translateX(0);box-shadow:0 0 40px rgba(0,0,0,.25)}
    .main{margin-left:0}
    .sidebar-overlay{position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:19;opacity:0;
      pointer-events:none;transition:opacity .25s ease}
    .topbar{padding:14px 16px;gap:10px}
    .content{padding:18px 16px 32px}
    .sidebar-overlay.open{opacity:1;pointer-events:auto}
  }

  @media(max-width:576px){
    .topbar{padding:12px}
    .topbar h1{font-size:16px}
    .greet p{display:none}
  }
</style>
@stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
  <button class="sidebar-close" type="button" id="sidebarCloseBtn" aria-label="Fermer le menu">
    <i class="bi bi-x-lg"></i>
  </button>
  <div class="brand">
    <div class="logo"><i class="bi bi-car-front-fill"></i></div>
    <div><b>{{ auth()->user()?->tenant?->name ?? 'Soulami Car' }}</b><span>Location de voiture</span></div>
  </div>

  <div class="nav-label">Menu</div>
  <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
    <i class="bi bi-grid-1x2"></i> Tableau de bord</a>
  <a class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
    <i class="bi bi-people"></i> Clients</a>
  <a class="nav-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
    <i class="bi bi-car-front"></i> Véhicules</a>
  @can('view-contracts')
  <a class="nav-item {{ request()->routeIs('contracts.*') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
    <i class="bi bi-file-earmark-text"></i> Contrats</a>
  @endcan
  @can('view-infractions')<a class="nav-item {{ request()->routeIs('infractions.*') ? 'active' : '' }}" href="{{ route('infractions.index') }}">
    <i class="bi bi-exclamation-triangle"></i> Infractions</a>
  @endcan

  <div class="nav-label">Système</div>
  <a class="nav-item" href="#"><i class="bi bi-gear"></i> Paramètres</a>
  <a class="nav-item" href="#"><i class="bi bi-question-circle"></i> Aide</a>

  <div class="foot">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="nav-item"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <button class="icon-btn menu-btn" type="button" id="menuBtn" aria-label="Ouvrir le menu">
      <i class="bi bi-list" style="font-size:20px"></i>
    </button>
    <div class="greet">
      <h1>Bonjour, {{ auth()->user()->name ?? 'Administrateur' }} 👋</h1>
      <p>Voici l'activité de votre agence — {{ ucfirst(now()->locale('fr')->isoFormat('dddd D MMMM YYYY')) }}</p>
    </div>
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
  </div>

  <div class="content">
    @yield('content')
  </div>
</div>

<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
  (function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.add('open');
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
    }

    menuBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
    closeBtn.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
      if (window.innerWidth > 992) closeSidebar();
    });
  })();
</script>
@stack('scripts')
</body>
</html>
