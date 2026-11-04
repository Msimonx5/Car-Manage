<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Car manager')</title>
<script>
  (function () {
    const preference = localStorage.getItem('car-manager-theme') || 'system';
    const useDarkTheme = preference === 'dark'
      || (preference === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.dataset.theme = useDarkTheme ? 'dark' : 'light';
    document.documentElement.dataset.contractNotifications =
      localStorage.getItem('car-manager-contract-notifications') === 'off' ? 'off' : 'on';
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
    --bg:#f6f7f9; --card:#fff; --line:#eceef2; --ink:#0f172a; --muted:#6b7280;
    --primary:#1877f2; --primary-tint:#e7f0ff; --bs-primary:#1877f2; --bs-primary-rgb:24,119,242;
    --success:#16a34a; --success-tint:#e7f6ec;
    --warning:#f59e0b; --warning-tint:#fef3e2;
    --danger:#ef4444;  --danger-tint:#fdeaea;
    --info:#0ea5e9;    --info-tint:#e6f5fd;
    --calculated-field-background:#f6f7f9; --calculated-total-background:#e7f0ff; --calculated-field-color:var(--ink);
    --sidebar-background:#1877f2;
    --sidebar-control:rgba(255,255,255,.12); --sidebar-hover:rgba(255,255,255,.2);
    --sidebar-selected:rgba(255,255,255,.28); --sidebar-accent:#fff;
    --sidebar-border:rgba(255,255,255,.25); --sidebar-control-border:rgba(255,255,255,.28);
    --sidebar-ink:#fff; --sidebar-muted:#e5efff;
    --sidebar:250px; --radius:16px;
  }
  *{box-sizing:border-box}
  body{margin:0;background:var(--bg);color:var(--ink);
    font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;font-size:14px}
  a{text-decoration:none}
  .btn-primary{
    --bs-btn-color:#fff;--bs-btn-bg:var(--primary);--bs-btn-border-color:var(--primary);
    --bs-btn-hover-color:#fff;--bs-btn-hover-bg:#1664d9;--bs-btn-hover-border-color:#155dc9;
    --bs-btn-active-color:#fff;--bs-btn-active-bg:#155dc9;--bs-btn-active-border-color:#155dc9;
    --bs-btn-disabled-color:#fff;--bs-btn-disabled-bg:var(--primary);--bs-btn-disabled-border-color:var(--primary)}

  .sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar);
    background:var(--sidebar-background);
    border-right:1px solid var(--sidebar-border);padding:22px 16px;display:flex;flex-direction:column;z-index:20;
    overflow-y:auto;overscroll-behavior-y:contain}
  .sidebar .brand b,.sidebar .nav-label,.sidebar .nav-item,
  .sidebar .theme-choice,.sidebar .contract-notification-toggle{color:var(--sidebar-ink)}
  .sidebar .brand span{color:var(--sidebar-muted)}
  .sidebar .nav-item,.sidebar .theme-choice,.sidebar .avatar-icon-choice,
  .sidebar .contract-notification-toggle,
  .sidebar .help-contact-prompt{
    background:var(--sidebar-control);
    box-shadow:inset 0 1px rgba(255,255,255,.35)}
  .sidebar .nav-item:hover,.sidebar .theme-choice:hover,
  .sidebar .avatar-icon-choice:hover,.sidebar .contract-notification-toggle:hover{
    background:var(--sidebar-hover)}
  .sidebar .nav-item.active,.sidebar .nav-item[aria-expanded="true"],
  .sidebar .theme-choice[aria-pressed="true"],
  .sidebar .avatar-icon-choice[aria-pressed="true"]{
    background:var(--sidebar-selected)}
  .sidebar .nav-item.active{color:var(--sidebar-ink)}
  .sidebar .sidebar-icon{
    --icon-color:#1877f2;width:30px;height:30px;flex:none;display:inline-grid;place-items:center;
    border-radius:9px;background:rgba(255,255,255,.96);color:var(--icon-color);font-size:15px;
    box-shadow:inset 0 1px rgba(255,255,255,.8),0 2px 5px rgba(0,44,110,.12)}
  .sidebar .sidebar-icon-primary{--icon-color:#1877f2}
  .sidebar .sidebar-icon-success{--icon-color:#16a34a}
  .sidebar .sidebar-icon-warning{--icon-color:#d97706}
  .sidebar .sidebar-icon-danger{--icon-color:#dc2626}
  .sidebar .sidebar-icon-info{--icon-color:#0284c7}
  .sidebar .sidebar-icon-purple{--icon-color:#7c3aed}
  .sidebar .sidebar-close{
    width:40px;height:40px;padding:4px;border-radius:12px;
    background:rgba(255,255,255,.16);border-color:rgba(255,255,255,.48);
    box-shadow:0 3px 10px rgba(0,44,110,.18);transition:background .15s,border-color .15s,transform .15s}
  .sidebar .sidebar-close .sidebar-icon{
    width:18px;height:18px;border-radius:5px;font-size:8px;
    background:#fff1f2;color:#dc2626;
    box-shadow:inset 0 1px rgba(255,255,255,.9),0 1px 3px rgba(127,29,29,.12);
    transition:background .15s,color .15s,transform .15s}
  .sidebar .sidebar-close:hover{background:rgba(255,255,255,.28);border-color:rgba(255,255,255,.72)}
  .sidebar .sidebar-close:hover .sidebar-icon{background:#dc2626;color:#fff;transform:rotate(90deg)}
  .sidebar .sidebar-close:active{transform:scale(.96)}
  .sidebar .avatar-icon-choice{border-color:var(--sidebar-control-border);color:var(--sidebar-ink)}
  .sidebar .avatar-icon-choice[aria-pressed="true"]{border-color:var(--sidebar-accent);color:var(--sidebar-accent)}
  .sidebar .contract-notification-toggle{
    border:1px solid rgba(255,255,255,.28);border-radius:8px;color:var(--sidebar-ink)}
  .sidebar .contract-notification-toggle input:checked{background:#fbbf24;border-color:#fbbf24}
  .sidebar .contract-notification-toggle input:focus-visible{outline-color:var(--sidebar-ink)}
  .sidebar .help-contact-prompt{border-radius:8px;color:#ffe1e1}
  .sidebar .help-call strong{color:var(--sidebar-ink)}
  .sidebar .foot{position:relative;margin-top:auto;padding-top:16px;flex-shrink:0}
  .sidebar .foot::before{content:"";position:absolute;top:0;left:4px;right:4px;height:1px;
    background:linear-gradient(90deg,transparent,var(--sidebar-border) 16%,rgba(255,255,255,.78) 50%,var(--sidebar-border) 84%,transparent)}
  .sidebar .foot .logout-form{margin:0}
  .sidebar .foot .nav-item{
    min-height:56px;margin:0;padding:8px 10px;gap:11px;border:1px solid var(--sidebar-control-border);
    border-radius:12px;background:var(--sidebar-control);
    box-shadow:inset 0 1px rgba(255,255,255,.62),0 3px 9px rgba(15,23,42,.06);
    color:var(--sidebar-ink);font-weight:650;transition:transform .15s,background .15s,border-color .15s,box-shadow .15s}
  .sidebar .foot .nav-item:hover{
    transform:translateY(-1px);border-color:var(--sidebar-border);
    background:var(--sidebar-hover);
    box-shadow:inset 0 1px rgba(255,255,255,.72),0 5px 12px rgba(15,23,42,.1);color:var(--sidebar-ink)}
  .sidebar .foot .nav-item:active{transform:translateY(0);box-shadow:inset 0 2px 4px rgba(15,23,42,.1)}
  .sidebar .foot .nav-item:focus-visible{outline:2px solid var(--sidebar-accent);outline-offset:2px}
  .sidebar-logout-icon{width:36px;height:36px;display:grid;place-items:center;flex:none;
    border:1px solid var(--sidebar-control-border);border-radius:10px;
    background:var(--sidebar-hover);
    box-shadow:inset 0 1px rgba(255,255,255,.7)}
  .sidebar-logout-icon i{font-size:16px}
  .sidebar-logout-label{display:grid;gap:2px}
  .sidebar-logout-label small{color:var(--sidebar-muted);font-size:10px;font-weight:500}
  .sidebar .nav-item:focus-visible,.sidebar .theme-choice:focus-visible,
  .sidebar .avatar-icon-choice:focus-visible,.sidebar .sidebar-close:focus-visible{
    outline:2px solid var(--sidebar-accent);outline-offset:2px}
  @media(prefers-reduced-motion:reduce){
    .sidebar .sidebar-close,.sidebar .sidebar-close .sidebar-icon{transition:none}
    .sidebar .sidebar-close:hover .sidebar-icon{transform:none}
  }
  .brand{display:flex;align-items:center;gap:10px;padding:4px 8px 22px}
  .brand .logo{width:38px;height:38px;border-radius:11px;background:#fff;color:#1877f2;
    display:grid;place-items:center;font-size:20px;box-shadow:0 6px 16px rgba(0,44,110,.22),inset 0 1px rgba(255,255,255,.75)}
  .brand b{font-size:16px;font-weight:800;letter-spacing:.2px}
  .brand span{display:block;font-size:11px;color:var(--muted);font-weight:500;margin-top:-2px}
  .nav-label{font-size:11px;text-transform:uppercase;letter-spacing:.6px;font-weight:600;padding:14px 10px 6px}
  .nav-item{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:11px;
    font-weight:500;margin-bottom:2px;transition:.15s;width:100%;border:0;background:none;text-align:left}
  .nav-item i{font-size:17px}
  .sidebar .nav-item.active{font-weight:600}
  .nav-item .badge{margin-left:auto;font-weight:600}
  @media(prefers-reduced-motion:reduce){
    .sidebar .nav-item,.sidebar .foot .nav-item,.sidebar .foot .nav-item:hover{
      transition:none;transform:none}
  }

  .main{margin-left:var(--sidebar);min-height:100vh}
  .topbar{position:sticky;top:0;z-index:10;background:rgba(246,247,249,.85);backdrop-filter:blur(8px);
    border-bottom:1px solid var(--line);padding:16px 28px;display:flex;align-items:center;gap:16px}
  .topbar h1{font-size:19px;font-weight:700;margin:0}
  .topbar p{margin:0;font-size:12.5px;color:var(--muted)}
  .greet{min-width:0;flex:1;text-align:center}
  .greet h1,.greet p{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .icon-btn{width:40px;height:40px;border-radius:10px;border:1px solid var(--line);background:#fff;
    display:grid;place-items:center;color:#4b5563;position:relative;flex:none}
  .avatar-menu{position:relative;flex:none}
  .avatar{width:40px;height:40px;border:0;border-radius:11px;background:var(--primary);color:#fff;
    display:grid;place-items:center;font:inherit;font-weight:700;cursor:pointer;position:relative}
  .avatar>i{font-size:20px;line-height:1}
  .avatar>img{width:100%;height:100%;border-radius:inherit;object-fit:cover}
  .avatar-notification-count{position:absolute;top:-5px;right:-5px;min-width:18px;min-height:18px;height:auto;padding:1px 4px;white-space:nowrap;
    display:grid;place-items:center;border:2px solid var(--card);border-radius:999px;background:var(--danger);
    color:#fff;font-size:10px;line-height:1;font-weight:700}
  :root[data-contract-notifications="off"] .avatar-notification-count,
  :root[data-contract-notifications="off"] #avatarNotifications{display:none!important}
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
  .btn-brand:hover{background:#1664d9;color:#fff}
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
  .avatar-menu-panel{position:absolute;top:calc(100% + 8px);right:0;z-index:30;width:280px;max-height:calc(100vh - 90px);overflow-y:auto;
    padding:8px;border:1px solid var(--line);border-radius:9px;background:#f8fafc;box-shadow:0 8px 24px rgba(15,23,42,.16)}
  .avatar-menu-panel[hidden]{display:none}
  .avatar-notifications-heading{display:flex;align-items:center;justify-content:space-between;padding:7px 8px;
    font-size:12px;font-weight:700;color:var(--ink)}
  .avatar-notifications-heading span{display:flex;align-items:center;gap:7px}
  .avatar-notifications-heading i{color:var(--danger);font-size:15px}
  .avatar-notification-menu-count{margin-left:auto;color:var(--danger);font-size:11px;font-weight:700}
  .avatar-notification-item{display:grid;grid-template-columns:30px minmax(0,1fr);gap:9px;padding:8px;border-radius:7px;color:var(--ink)}
  .avatar-notification-example{cursor:default}
  .avatar-notification-form{margin:0}
  button.avatar-notification-item{width:100%;border:0;background:transparent;font:inherit;text-align:left;cursor:pointer}
  .avatar-notification-item:hover{background:var(--danger-tint);color:var(--ink)}
  .avatar-notification-item>i{color:var(--danger);font-size:16px;padding-top:1px}
  .avatar-notification-item strong,.avatar-notification-item small{display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
  .avatar-notification-item strong{font-size:11.5px}
  .avatar-notification-item small,.avatar-notifications-empty{font-size:10.5px;color:var(--muted)}
  .avatar-notifications-empty{margin:0;padding:8px}
  .avatar-notifications-mark-read{width:100%;padding:6px 8px;border:0;background:transparent;color:var(--primary);
    font:inherit;font-size:10.5px;text-align:left;cursor:pointer}
  .avatar-notifications-mark-read:hover{text-decoration:underline}
  .avatar-account-form{margin:0}
  .avatar-account-choice span{display:grid;min-width:0}
  .avatar-account-choice small{overflow:hidden;color:var(--muted);font-size:10px;text-overflow:ellipsis}
  .avatar-add-account-form{display:grid;gap:7px;margin:6px 0;padding:8px;border:1px solid var(--line);border-radius:8px}
  .avatar-add-account-form label{display:grid;gap:4px;color:var(--muted);font-size:10.5px}
  .avatar-add-account-form input{width:100%;padding:7px 8px;border:1px solid var(--line);border-radius:6px;
    background:var(--card);color:var(--ink);font:inherit;font-size:12px}
  .avatar-add-account-form input:focus{outline:2px solid var(--primary-tint);border-color:var(--primary)}
  .avatar-account-error{color:var(--danger);font-size:10.5px}
  .theme-options{display:flex;flex-direction:column;gap:4px;margin:4px 0 10px 10px}
  .theme-options[hidden]{display:none}
  .theme-submenu-options{display:flex;flex-direction:column;gap:4px;margin-left:8px}
  .theme-submenu-options[hidden]{display:none}
  .avatar-upload-form{grid-column:1 / -1;margin:4px 0 0}
  .avatar-upload-input{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
  .avatar-upload-error{display:block;padding:0 10px;color:var(--danger);font-size:11px}
  .avatar-icon-picker{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:4px;padding:4px 10px 8px}
  .avatar-icon-picker[hidden]{display:none}
  .avatar-icon-picker form{margin:0}
  .avatar-icon-choice{width:36px;height:36px;display:grid;place-items:center;border:1px solid var(--line);border-radius:8px;
    background:var(--card);color:var(--muted);cursor:pointer}
  .avatar-icon-choice i{font-size:17px}
  .avatar-icon-choice[aria-pressed="true"]{border-color:var(--primary);background:var(--primary-tint);color:var(--primary)}
  .contract-notification-toggle{display:flex;align-items:center;gap:10px;padding:8px 10px;color:var(--muted);
    font-size:12px;cursor:pointer}
  .contract-notification-toggle input{appearance:none;width:34px;height:20px;margin:0;position:relative;flex:none;
    border:1px solid var(--line);border-radius:999px;background:#cbd5e1;cursor:pointer;transition:background .15s}
  .contract-notification-toggle input::before{content:"";position:absolute;top:2px;left:2px;width:14px;height:14px;
    border-radius:50%;background:#fff;transition:transform .15s}
  .contract-notification-toggle input:checked{background:var(--primary)}
  .contract-notification-toggle input:checked::before{transform:translateX(14px)}
  .contract-notification-toggle input:focus-visible{outline:2px solid var(--primary);outline-offset:2px}
  .theme-choice{display:flex;align-items:center;justify-content:flex-start;gap:10px;width:100%;
    min-height:42px;padding:8px 10px;border:0;border-radius:8px;background:transparent;color:var(--muted);
    font:inherit;font-size:12px;text-align:left;cursor:pointer}
  .sidebar .help-options .nav-item{color:var(--sidebar-ink)}
  .theme-choice i{font-size:16px}
  .theme-choice[aria-pressed="true"]{background:var(--primary-tint);color:var(--primary);font-weight:600}
  .theme-choice span{min-width:0}
  .avatar-menu-divider{height:1px;margin:8px 0;background:var(--line)}
  .help-call{display:grid;gap:2px;line-height:1.3}
  .help-call strong{font-size:12px;color:#17191b}
  .help-options{margin-left:10px}
  .help-options[hidden]{display:none}
  .help-problems-options{margin-left:6px}
  .help-problems-options[hidden]{display:none}
  .help-contact-prompt{margin:0;padding:7px 12px;color:var(--danger);font-size:11px;line-height:1.45}
  .avatar-logout{display:flex;align-items:center;gap:8px;width:100%;padding:8px 9px;border:0;border-radius:6px;
    background:transparent;color:#b91c1c;font:inherit;font-size:12px;text-align:left;cursor:pointer}
  .avatar-logout:hover{background:#fdeaea}

  @media(max-width:992px){
    .menu-btn{display:grid}
    .sidebar-close{display:grid}
    .sidebar .brand{padding-right:44px}
    .sidebar .brand>div{min-width:0;flex:1}
    .sidebar .brand b,.sidebar .brand span{
      max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .sidebar .brand b{display:block;font-size:13.5px;letter-spacing:0}
    .sidebar{width:min(320px,calc(100vw - 40px));max-height:100vh;max-height:100dvh;
      padding:calc(18px + env(safe-area-inset-top)) 14px calc(18px + env(safe-area-inset-bottom));
      transform:translateX(-100%);transition:transform .25s ease;box-shadow:0 0 0 rgba(0,0,0,0)}
    .sidebar.open{transform:translateX(0);box-shadow:0 0 40px rgba(0,0,0,.25)}
    body.sidebar-open{overflow:hidden}
    .main{margin-left:0}
    .sidebar-overlay{position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:19;opacity:0;
      pointer-events:none;transition:opacity .25s ease;backdrop-filter:blur(2px)}
    .topbar{padding:14px 16px;gap:10px}
    .content{padding:18px 16px 32px}
    .sidebar-overlay.open{opacity:1;pointer-events:auto}
    .theme-choice{min-height:44px;font-size:13px}
    .theme-options{gap:5px;margin:6px 0 12px 8px}
    .theme-submenu-options{gap:5px;margin-left:6px}
    .avatar-menu-panel{position:fixed;top:calc(64px + env(safe-area-inset-top));right:12px;
      width:min(340px,calc(100vw - 24px));max-height:calc(100vh - 76px - env(safe-area-inset-top));
      max-height:calc(100dvh - 76px - env(safe-area-inset-top));padding:10px}
    .avatar-menu-panel .theme-choice{min-height:44px}
  }

  @media(max-width:576px){
    .topbar{padding:12px;gap:8px}
    .menu-btn,.avatar{width:44px;height:44px}
    .greet{text-align:left}
    .topbar h1{font-size:16px}
    .greet p{display:none}
    .content{padding:14px 12px 28px}
    .sidebar{width:min(320px,calc(100vw - 32px))}
    .sidebar-close{top:calc(16px + env(safe-area-inset-top));right:12px}
    .avatar-menu-panel{top:calc(64px + env(safe-area-inset-top));right:8px;width:calc(100vw - 16px);
      max-height:calc(100vh - 72px - env(safe-area-inset-top));
      max-height:calc(100dvh - 72px - env(safe-area-inset-top))}
  }
  @media(prefers-reduced-motion:reduce){
    .sidebar,.sidebar-overlay{transition:none}
  }

  :root[data-theme="dark"]{
    color-scheme:dark;
    --bg:#14171a; --card:#25292d; --line:#42474c; --ink:#edf0f2; --muted:#aeb5ba;
    --primary:#1877f2; --primary-tint:#17345a; --bs-primary:#1877f2; --bs-primary-rgb:24,119,242;
    --success:#4ade80; --success-tint:#173b27;
    --warning:#fbbf24; --warning-tint:#3b2f17;
    --danger:#f87171; --danger-tint:#3d2226;
    --info:#38bdf8; --info-tint:#163344;
    --calculated-field-background:#30353a; --calculated-total-background:#17345a; --calculated-field-color:#fff;
  }
  :root[data-theme="dark"] body{background:linear-gradient(135deg,#111417 0%,#1c2024 35%,#121518 68%,#202428 100%);color:var(--ink)}
  :root[data-theme="dark"] .topbar{background:linear-gradient(110deg,rgba(35,39,43,.96),rgba(22,26,29,.94),rgba(42,46,50,.96))}
  :root[data-theme="dark"] .card2,
  :root[data-theme="dark"] .form-card,
  :root[data-theme="dark"] .ministat,
  :root[data-theme="dark"] .stat{background:linear-gradient(135deg,#30353a 0%,#23272b 42%,#34393e 100%);border-color:#454b50}
  :root[data-theme="dark"] .modal-content,
  :root[data-theme="dark"] .dropdown-menu{background:linear-gradient(135deg,#30353a 0%,#23272b 42%,#34393e 100%);color:var(--ink);border-color:#50565b}
  :root[data-theme="dark"] .modal-header,
  :root[data-theme="dark"] .modal-footer{border-color:#50565b}
  :root[data-theme="dark"] .card2,
  :root[data-theme="dark"] .form-card{box-shadow:0 2px 8px rgba(0,0,0,.28),inset 0 1px rgba(255,255,255,.035)}
  :root[data-theme="dark"] .icon-btn,
  :root[data-theme="dark"] .btn-soft,
  :root[data-theme="dark"] .act,
  :root[data-theme="dark"] .page-link,
  :root[data-theme="dark"] .avatar-icon-choice{background:linear-gradient(135deg,#3b4045,#252a2e 55%,#34393e);color:#e3e7e9;border-color:#50565b}
  :root[data-theme="dark"] .btn-soft:hover,
  :root[data-theme="dark"] .act:hover{background:linear-gradient(135deg,#4a5055,#30363a);color:#fff}
  :root[data-theme="dark"] .form-control,
  :root[data-theme="dark"] .form-select{background:linear-gradient(135deg,#292e32,#202428);color:var(--ink);border-color:#50565b}
  :root[data-theme="dark"] .form-control::placeholder{color:#aeb5ba}
  :root[data-theme="dark"] option{background:#25292d;color:var(--ink)}
  :root[data-theme="dark"] .form-label{color:#d3d8db}
  :root[data-theme="dark"] .section-title{color:#c1c7cb}
  :root[data-theme="dark"] table.t2 th{color:#c1c7cb}
  :root[data-theme="dark"] table.t2 tr:hover td{background:rgba(225,232,236,.06)}
  :root[data-theme="dark"] .trend.flat,
  :root[data-theme="dark"] .pill.secondary{background:linear-gradient(135deg,#41474c,#30353a);color:#e0e4e6}
  :root[data-theme="dark"] .pill.attente{color:#fcd879}
  :root[data-theme="dark"] .pill.cours{color:#7dd3fc}
  :root[data-theme="dark"] .pill.termine{color:#86efac}
  :root[data-theme="dark"] .pill.annule{color:#fca5a5}
  :root[data-theme="dark"] .flash.ok{background:var(--success-tint);color:#86efac;border-color:#28593b}
  :root[data-theme="dark"] .flash.err{background:var(--danger-tint);color:#fca5a5;border-color:#65343a}
  :root[data-theme="dark"] .avatar-menu-panel{background:linear-gradient(135deg,#34393e,#22272b 55%,#30353a);border-color:#50565b}
  :root[data-theme="dark"] .avatar-logout{color:#fca5a5}
  :root[data-theme="dark"] .avatar-logout:hover{background:#3d2226}
  :root[data-theme="dark"] .avatar-notification-item{color:var(--ink)}
  :root[data-theme="dark"] .sidebar .theme-choice{color:var(--sidebar-ink)}
  :root[data-theme="dark"] .sidebar .theme-choice[aria-pressed="true"]{
    background:var(--sidebar-selected);color:var(--sidebar-ink)}
  :root[data-theme="dark"] .avatar-icon-choice[aria-pressed="true"]{border-color:var(--primary);background:var(--primary-tint);color:#93c5fd}
  :root[data-theme="dark"] .sidebar .avatar-icon-choice{
    background:var(--sidebar-control);color:var(--sidebar-ink);border-color:var(--sidebar-control-border)}
  :root[data-theme="dark"] .sidebar .avatar-icon-choice[aria-pressed="true"]{
    background:var(--sidebar-selected);color:var(--sidebar-accent);border-color:var(--sidebar-accent)}
  :root[data-theme="dark"] .sidebar .sidebar-close{
    background:var(--sidebar-control);color:var(--sidebar-ink);border-color:var(--sidebar-control-border)}
  :root[data-theme="dark"] .page-link{color:#e0e4e6}
  :root[data-theme="dark"] .page-item.active .page-link{background:var(--primary);border-color:var(--primary);color:#fff}

  :root[data-app-text-color="navy"]{--app-text-color:#1e3a8a}
  :root[data-app-text-color="blue"]{--app-text-color:#1d4ed8}
  :root[data-app-text-color="green"]{--app-text-color:#166534}
  :root[data-app-text-color="burgundy"]{--app-text-color:#991b1b}
  :root[data-app-text-color="purple"]{--app-text-color:#6b21a8}
  :root[data-app-text-color="mixed"]{--app-text-color:var(--ink)}
  :root[data-theme="dark"][data-app-text-color="navy"]{--app-text-color:#bfdbfe}
  :root[data-theme="dark"][data-app-text-color="blue"]{--app-text-color:#93c5fd}
  :root[data-theme="dark"][data-app-text-color="green"]{--app-text-color:#86efac}
  :root[data-theme="dark"][data-app-text-color="burgundy"]{--app-text-color:#fca5a5}
  :root[data-theme="dark"][data-app-text-color="purple"]{--app-text-color:#d8b4fe}
  :root[data-theme="dark"][data-app-text-color="mixed"]{--app-text-color:var(--ink)}
  :root[data-app-text-color="navy"]{--sidebar-ink:#dbeafe}
  :root[data-app-text-color="blue"]{--sidebar-ink:#eff6ff}
  :root[data-app-text-color="green"]{--sidebar-ink:#dcfce7}
  :root[data-app-text-color="burgundy"]{--sidebar-ink:#fee2e2}
  :root[data-app-text-color="purple"]{--sidebar-ink:#f3e8ff}
  :root[data-app-text-color="mixed"]{--sidebar-ink:#fff}
  :root[data-app-text-color] body{color:var(--app-text-color)}
  :root[data-app-text-color] .main :is(
    h1,h2,h3,h4,h5,p,
    label,td,th,a,small,strong,li,dt,dd,legend,.theme-choice,.contract-notification-toggle,
    .avatar-notifications-empty
  ){color:var(--app-text-color)!important}
  :root[data-app-text-color] .main :is(input:not([type="checkbox"]):not([type="radio"]),select,textarea){
    color:var(--app-text-color)
  }
  :root[data-app-text-color] .sidebar :is(
    .brand b,.brand span,.nav-label,.nav-item,.theme-choice,.contract-notification-toggle,
    .help-contact-prompt,.help-call strong,.sidebar-logout-label small
  ){color:var(--sidebar-ink)}
  :root[data-app-text-color] .sidebar .help-options .help-contact-prompt{color:#ffe1e1}
  :root[data-app-text-color="mixed"] .main :is(h1,h2,h3,h4,h5,.section-title){color:#7c3aed!important}
  :root[data-app-text-color="mixed"] .main a{color:#1d4ed8!important}
  :root[data-app-text-color="mixed"] .main :is(label,th,strong){color:#166534!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .main :is(h1,h2,h3,h4,h5,.section-title){color:#c4b5fd!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .main a{color:#93c5fd!important}
  :root[data-theme="dark"][data-app-text-color="mixed"] .main :is(label,th,strong){color:#86efac!important}
  .app-text-color-swatch{display:inline-block;width:15px;height:15px;flex:none;
    border:1px solid rgba(148,163,184,.6);border-radius:50%;vertical-align:middle}
  .app-text-color-choice[data-app-text-color-choice="default"] .app-text-color-swatch{
    background:linear-gradient(135deg,#0f172a 50%,#edf0f2 50%)
  }
  .app-text-color-choice[data-app-text-color-choice="navy"] .app-text-color-swatch{background:#1e3a8a}
  .app-text-color-choice[data-app-text-color-choice="blue"] .app-text-color-swatch{background:#1d4ed8}
  .app-text-color-choice[data-app-text-color-choice="green"] .app-text-color-swatch{background:#166534}
  .app-text-color-choice[data-app-text-color-choice="burgundy"] .app-text-color-swatch{background:#991b1b}
  .app-text-color-choice[data-app-text-color-choice="purple"] .app-text-color-swatch{background:#6b21a8}
  .app-text-color-choice[data-app-text-color-choice="mixed"] .app-text-color-swatch{
    background:linear-gradient(135deg,#7c3aed 0 33%,#1d4ed8 33% 66%,#16a34a 66%)}
</style>
@stack('styles')
</head>
<body data-login-succeeded="{{ session('login_succeeded') ? '1' : '0' }}">

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
  <button class="sidebar-close" type="button" id="sidebarCloseBtn" aria-label="Fermer le menu">
    <i class="bi bi-x-lg sidebar-icon sidebar-icon-danger"></i>
  </button>
  <div class="brand">
    <a class="logo" href="{{ route('dashboard') }}" aria-label="Tableau de bord" title="Tableau de bord">
      <i class="bi bi-car-front" aria-hidden="true"></i>
    </a>
    <div><b>{{ auth()->user()?->tenant?->name ?? 'Car manager' }}</b><span>Location de voiture</span></div>
  </div>

  <div class="nav-label">Menu</div>
  <a class="nav-item Parallel {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
    <i class="bi bi-grid-1x2 sidebar-icon sidebar-icon-primary"></i> Tableau de bord</a>
  <a class="nav-item Parallel {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
    <i class="bi bi-people sidebar-icon sidebar-icon-primary"></i> Clients</a>
  <a class="nav-item Parallel {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
    <i class="bi bi-car-front sidebar-icon sidebar-icon-success"></i> Véhicules</a>
  @can('view-contracts')
  <a class="nav-item Parallel {{ request()->routeIs('contracts.*') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
    <i class="bi bi-file-earmark-text sidebar-icon sidebar-icon-warning"></i> Contrats</a>
  @endcan
  @can('view-infractions')<a class="nav-item Parallel {{ request()->routeIs('infractions.*') ? 'active' : '' }}" href="{{ route('infractions.index') }}">
    <i class="bi bi-exclamation-triangle sidebar-icon sidebar-icon-danger"></i> Infractions</a>
  @endcan

  <div class="nav-label">Système</div>
  <button class="nav-item" type="button" id="themeMenuToggle" aria-expanded="false" aria-controls="themeOptions">
    <i class="bi bi-gear sidebar-icon sidebar-icon-purple"></i> Paramètres <i class="bi bi-chevron-down" style="margin-left:auto;font-size:12px"></i>
  </button>
  <div class="theme-options" id="themeOptions" role="group" aria-label="Thème d’affichage" hidden>
    @can('view-contracts')
    <button class="theme-choice" type="button" id="notificationSettingsToggle" aria-expanded="false" aria-controls="notificationSettingsOptions">
      <i class="bi bi-bell sidebar-icon sidebar-icon-warning" aria-hidden="true"></i><span>Notifications</span>
      <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
    </button>
    <div class="theme-submenu-options" id="notificationSettingsOptions" role="group" aria-label="Paramètres des notifications" hidden>
      <label class="contract-notification-toggle" for="contractNotificationToggle">
        <input id="contractNotificationToggle" type="checkbox" checked>
        Alertes contrats expirés
      </label>
    </div>
    @endcan
    <button class="theme-choice" type="button" id="avatarIconMenuToggle" aria-expanded="false" aria-controls="avatarIconOptions">
      <i class="bi bi-grid sidebar-icon sidebar-icon-info" aria-hidden="true"></i><span>Choisir une icône</span>
      <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
    </button>
    <div class="avatar-icon-picker" id="avatarIconOptions" role="group" aria-label="Choisir une icône Bootstrap" hidden>
      @foreach([
        'bi-person' => 'Personne',
        'bi-person-circle' => 'Personne avec cercle',
        'bi-person-badge' => 'Badge personne',
        'bi-emoji-smile' => 'Sourire',
        'bi-briefcase' => 'Mallette',
        'bi-star' => 'Étoile',
        'bi-shield-check' => 'Bouclier',
        'bi-lightning-charge' => 'Éclair',
      ] as $icon => $label)
        <form action="{{ route('profile.avatar.icon') }}" method="POST">
          @csrf
          <input type="hidden" name="avatar_icon" value="{{ $icon }}">
          <button class="avatar-icon-choice" type="submit" aria-label="{{ $label }}" title="{{ $label }}"
                  aria-pressed="{{ auth()->user()->avatar_icon === $icon ? 'true' : 'false' }}">
            <i class="bi {{ $icon }}" aria-hidden="true"></i>
          </button>
        </form>
      @endforeach
      <form class="avatar-upload-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="avatar-upload-input" id="avatarUploadInput" type="file" name="avatar" accept="image/jpeg,image/png,image/webp" required>
        <button class="theme-choice" type="button" id="avatarUploadButton">
          <i class="bi bi-camera sidebar-icon sidebar-icon-primary" aria-hidden="true"></i><span>Changer l’avatar</span>
        </button>
        @error('avatar')<span class="avatar-upload-error">{{ $message }}</span>@enderror
      </form>
    </div>
    <button class="theme-choice" type="button" id="themeSubmenuToggle" aria-expanded="false" aria-controls="themeSubmenuOptions">
      <i class="bi bi-palette sidebar-icon sidebar-icon-purple" aria-hidden="true"></i><span>Thème</span>
      <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
    </button>
    <div class="theme-submenu-options" id="themeSubmenuOptions" role="group" aria-label="Choisir le thème" hidden>
      <button class="theme-choice" type="button" data-theme-choice="light" aria-label="Thème clair" aria-pressed="false" title="Clair">
        <i class="bi bi-sun sidebar-icon sidebar-icon-warning" aria-hidden="true"></i><span>Clair</span>
      </button>
      <button class="theme-choice" type="button" data-theme-choice="dark" aria-label="Thème sombre" aria-pressed="false" title="Sombre">
        <i class="bi bi-moon-stars sidebar-icon sidebar-icon-purple" aria-hidden="true"></i><span>Sombre</span>
      </button>
      <button class="theme-choice" type="button" data-theme-choice="system" aria-label="Thème système" aria-pressed="true" title="Système">
        <i class="bi bi-display sidebar-icon sidebar-icon-info" aria-hidden="true"></i><span>Système</span>
      </button>
    </div>
    <button class="theme-choice" type="button" id="sidebarTextColorMenuToggle"
            aria-expanded="false" aria-controls="sidebarTextColorOptions">
      <i class="bi bi-spellcheck sidebar-icon sidebar-icon-info" aria-hidden="true"></i><span>Couleur du texte</span>
      <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
    </button>
    <div class="theme-submenu-options" id="sidebarTextColorOptions" role="group"
         aria-label="Choisir la couleur du texte" hidden>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="default" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Original</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="navy" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bleu marine</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="blue" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bleu</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="green" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Vert</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="burgundy" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bordeaux</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="purple" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Violet</span>
      </button>
      <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="mixed" aria-pressed="false">
        <span class="app-text-color-swatch" aria-hidden="true"></span><span>Couleurs mixtes</span>
      </button>
    </div>
  </div>
  <button class="nav-item" type="button" id="helpMenuToggle" aria-expanded="false" aria-controls="helpOptions">
    <i class="bi bi-question-circle sidebar-icon sidebar-icon-info"></i> Aide <i class="bi bi-chevron-down" style="margin-left:auto;font-size:12px"></i>
  </button>
  <div class="help-options" id="helpOptions" hidden>
    <button class="nav-item" type="button" id="helpProblemsToggle" aria-expanded="false" aria-controls="helpProblemsOptions">
      <i class="bi bi-exclamation-circle sidebar-icon sidebar-icon-danger"></i> Problèmes <i class="bi bi-chevron-down" style="margin-left:auto;font-size:12px"></i>
    </button>
    <div class="help-problems-options" id="helpProblemsOptions" hidden>
      <p class="help-contact-prompt">S'il y a un problème, veuillez nous contacter.</p>
      <a class="nav-item" href="tel:+212690171687" aria-label="Appeler Madmi">
        <i class="bi bi-telephone sidebar-icon sidebar-icon-success"></i>
        <span class="help-call"><strong>Madmi</strong></span>
      </a>
      <a class="nav-item" href="tel:+212777492706" aria-label="Appeler Mqaddache">
        <i class="bi bi-telephone sidebar-icon sidebar-icon-success"></i>
        <span class="help-call"><strong>Mqaddache</strong></span>
      </a>
    </div>
  </div>

  <div class="foot">
    <form class="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="nav-item">
        <span class="sidebar-logout-icon"><i class="bi bi-box-arrow-right sidebar-icon sidebar-icon-danger" aria-hidden="true"></i></span>
        <span class="sidebar-logout-label">Déconnexion<small>Quitter la session</small></span>
      </button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <button class="icon-btn menu-btn" type="button" id="menuBtn" aria-label="Ouvrir le menu"
            aria-expanded="false" aria-controls="sidebar">
      <i class="bi bi-list" style="font-size:20px"></i>
    </button>
    <div class="greet">
      <h1>Bonjour, {{ auth()->user()->name ?? 'Administrateur' }} 👋</h1>
      <p>Voici l'activité de votre agence — {{ ucfirst(now()->locale('fr')->isoFormat('dddd D MMMM YYYY')) }}</p>
    </div>
    @php($accountFormHasErrors = $errors->has('email') || $errors->has('password'))
    <div class="avatar-menu">
      <button class="avatar" type="button" id="avatarMenuToggle" aria-label="Menu du compte"
              aria-expanded="{{ $accountFormHasErrors ? 'true' : 'false' }}" aria-controls="avatarMenu">
        @if(auth()->user()->avatar_icon)
          <i class="bi {{ auth()->user()->avatar_icon }}" aria-hidden="true"></i>
        @elseif(auth()->user()->avatar_path)
          <img src="{{ route('profile.avatar', ['v' => auth()->user()->updated_at?->timestamp ?? 0]) }}" alt="">
        @else
          <i class="bi bi-person" aria-hidden="true"></i>
        @endif
        @if($expiredContractCount > 0)
          <span class="avatar-notification-count" aria-label="{{ $expiredContractCount }} contrats expirés">
            {{ $expiredContractCount }}
          </span>
        @endif
      </button>
      <div class="avatar-menu-panel" id="avatarMenu"
           data-notification-count="{{ $expiredContractCount }}"
           data-notification-status-url="{{ route('contracts.notifications.status') }}"
           data-notification-read-url-template="{{ route('contracts.notifications.read', ['contract' => '__CONTRACT_ID__']) }}"
           data-contract-index-url="{{ route('contracts.index') }}"
           data-user-id="{{ auth()->id() }}" @if(!$accountFormHasErrors) hidden @endif>
        <button class="theme-choice" type="button" id="avatarAccountsToggle"
                aria-expanded="{{ $accountFormHasErrors ? 'true' : 'false' }}" aria-controls="avatarAccountOptions">
          <i class="bi bi-arrow-left-right" aria-hidden="true"></i><span>Changer de compte</span>
          <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
        </button>
        <div class="theme-submenu-options" id="avatarAccountOptions" role="group" aria-label="Comptes connectés"
             @if(!$accountFormHasErrors) hidden @endif>
          @foreach($switchableAccounts as $account)
            @if((int) $account->id === (int) auth()->id())
              <div class="theme-choice avatar-account-choice" aria-current="true">
                <i class="bi bi-person-check" aria-hidden="true"></i>
                <span>{{ $account->name }}<small>Compte actuel</small></span>
              </div>
            @else
              <form class="avatar-account-form" action="{{ route('account.switch') }}" method="POST">
                @csrf
                <input type="hidden" name="account_id" value="{{ $account->id }}">
                <button class="theme-choice avatar-account-choice" type="submit">
                  <i class="bi bi-person" aria-hidden="true"></i>
                  <span>{{ $account->name }}<small>{{ $account->email }}</small></span>
                </button>
              </form>
            @endif
          @endforeach
          <button class="theme-choice" type="button" id="avatarAddAccountToggle"
                  aria-expanded="{{ $errors->has('email') || $errors->has('password') ? 'true' : 'false' }}"
                  aria-controls="avatarAddAccountForm">
            <i class="bi bi-person-plus" aria-hidden="true"></i><span>Ajouter un compte</span>
          </button>
          <div id="avatarAddAccountForm" @if(!$accountFormHasErrors) hidden @endif>
            <form class="avatar-add-account-form" action="{{ route('account.add') }}" method="POST">
              @csrf
              <label>
                Adresse e-mail
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required>
              </label>
              @error('email')<span class="avatar-account-error">{{ $message }}</span>@enderror
              <label>
                Mot de passe
                <input type="password" name="password" autocomplete="current-password" required>
              </label>
              @error('password')<span class="avatar-account-error">{{ $message }}</span>@enderror
              <button class="theme-choice" type="submit">
                <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i><span>Se connecter à ce compte</span>
              </button>
            </form>
          </div>
        </div>
        <div id="avatarNotifications">
        @can('view-contracts')
          <button class="theme-choice" type="button" id="avatarNotificationToggle" aria-expanded="false" aria-controls="avatarNotificationContent">
            <i class="bi bi-bell" aria-hidden="true"></i><span>Notifications</span>
            <span class="avatar-notification-menu-count" id="avatarNotificationCount">{{ $expiredContractCount }}</span>
            <i class="bi bi-chevron-down" style="font-size:11px" aria-hidden="true"></i>
          </button>
          <div id="avatarNotificationContent" hidden>
            <div class="avatar-notifications-heading">
              <span><i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i> Contrats expirés</span>
            </div>
            <form id="avatarReadAllForm" action="{{ route('contracts.notifications.read-all') }}" method="POST"
                  @if($expiredContractCount === 0) hidden @endif>
              @csrf
              <button class="avatar-notifications-mark-read" type="submit">Tout marquer comme lu</button>
            </form>
            <div id="avatarNotificationItems" aria-live="polite">
            @forelse($expiredContractNotifications as $contract)
              <form class="avatar-notification-form" action="{{ route('contracts.notifications.read', $contract) }}" method="POST">
                @csrf
                <button class="avatar-notification-item" type="submit">
                  <i class="bi bi-file-earmark-x" aria-hidden="true"></i>
                  <span>
                    <strong>Contrat {{ $contract->numero }}</strong>
                    <small>{{ $contract->client_full_name }} · retour {{ $contract->date_retour->format('d/m/Y') }}</small>
                  </span>
                </button>
              </form>
            @empty
              <p class="avatar-notifications-empty">Aucune notification non lue. En attente de la prochaine expiration.</p>
            @endforelse
            @if($expiredContractCount > $expiredContractNotifications->count())
              <a class="avatar-notifications-empty" href="{{ route('contracts.index') }}">Voir tous les contrats</a>
            @endif
            </div>
          </div>
          <div class="avatar-menu-divider"></div>
        @endcan
        </div>
        <button class="theme-choice" type="button" id="avatarThemeMenuToggle" aria-expanded="false" aria-controls="avatarThemeOptions">
          <i class="bi bi-palette" aria-hidden="true"></i><span>Thème</span>
          <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
        </button>
        <div class="theme-submenu-options" id="avatarThemeOptions" role="group" aria-label="Choisir le thème" hidden>
          <button class="theme-choice" type="button" data-theme-choice="light" aria-label="Thème clair" aria-pressed="false" title="Clair">
            <i class="bi bi-sun" aria-hidden="true"></i><span>Clair</span>
          </button>
          <button class="theme-choice" type="button" data-theme-choice="dark" aria-label="Thème sombre" aria-pressed="false" title="Sombre">
            <i class="bi bi-moon-stars" aria-hidden="true"></i><span>Sombre</span>
          </button>
          <button class="theme-choice" type="button" data-theme-choice="system" aria-label="Thème système" aria-pressed="true" title="Système">
            <i class="bi bi-display" aria-hidden="true"></i><span>Système</span>
          </button>
        </div>
        <button class="theme-choice" type="button" id="avatarTextColorMenuToggle"
                aria-expanded="false" aria-controls="avatarTextColorOptions">
          <i class="bi bi-spellcheck" aria-hidden="true"></i><span>Couleur du texte</span>
          <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px" aria-hidden="true"></i>
        </button>
        <div class="theme-submenu-options" id="avatarTextColorOptions" role="group"
             aria-label="Choisir la couleur du texte" hidden>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="default" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Original</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="navy" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bleu marine</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="blue" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bleu</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="green" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Vert</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="burgundy" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Bordeaux</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="purple" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Violet</span>
          </button>
          <button class="theme-choice app-text-color-choice" type="button" data-app-text-color-choice="mixed" aria-pressed="false">
            <span class="app-text-color-swatch" aria-hidden="true"></span><span>Couleurs mixtes</span>
          </button>
        </div>
        <div class="avatar-menu-divider"></div>
        <form class="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="avatar-logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
        </form>
      </div>
    </div>
  </div>

  <div class="content">
    @yield('content')
  </div>
</div>

<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/ui-click-sound.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
  (function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('sidebarCloseBtn');
    const themeMenuToggle = document.getElementById('themeMenuToggle');
    const themeSubmenuToggle = document.getElementById('themeSubmenuToggle');
    const themeSubmenuOptions = document.getElementById('themeSubmenuOptions');
    const sidebarTextColorMenuToggle = document.getElementById('sidebarTextColorMenuToggle');
    const sidebarTextColorOptions = document.getElementById('sidebarTextColorOptions');
    const notificationSettingsToggle = document.getElementById('notificationSettingsToggle');
    const notificationSettingsOptions = document.getElementById('notificationSettingsOptions');
    const avatarThemeMenuToggle = document.getElementById('avatarThemeMenuToggle');
    const avatarThemeOptions = document.getElementById('avatarThemeOptions');
    const avatarTextColorMenuToggle = document.getElementById('avatarTextColorMenuToggle');
    const avatarTextColorOptions = document.getElementById('avatarTextColorOptions');
    const appTextColorChoices = document.querySelectorAll('[data-app-text-color-choice]');
    const helpMenuToggle = document.getElementById('helpMenuToggle');
    const helpOptions = document.getElementById('helpOptions');
    const helpProblemsToggle = document.getElementById('helpProblemsToggle');
    const helpProblemsOptions = document.getElementById('helpProblemsOptions');
    const avatarMenuToggle = document.getElementById('avatarMenuToggle');
    const avatarNotificationToggle = document.getElementById('avatarNotificationToggle');
    const avatarNotificationContent = document.getElementById('avatarNotificationContent');
    const avatarAccountsToggle = document.getElementById('avatarAccountsToggle');
    const avatarAccountOptions = document.getElementById('avatarAccountOptions');
    const avatarAddAccountToggle = document.getElementById('avatarAddAccountToggle');
    const avatarAddAccountForm = document.getElementById('avatarAddAccountForm');
    const themeOptions = document.getElementById('themeOptions');
    const avatarMenu = document.getElementById('avatarMenu');
    const avatarUploadInput = document.getElementById('avatarUploadInput');
    const avatarUploadButton = document.getElementById('avatarUploadButton');
    const avatarIconMenuToggle = document.getElementById('avatarIconMenuToggle');
    const avatarIconOptions = document.getElementById('avatarIconOptions');
    const contractNotificationToggle = document.getElementById('contractNotificationToggle');
    const themeChoices = document.querySelectorAll('[data-theme-choice]');
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');
    let notificationCount = Number(avatarMenu.dataset.notificationCount || 0);
    let previousNotificationCount = Number(localStorage.getItem(
      'car-manager-expired-contract-notification-count-' + avatarMenu.dataset.userId
    ) || 0);
    const notificationCountKey = 'car-manager-expired-contract-notification-count-' + avatarMenu.dataset.userId;
    const notificationCountDisplay = document.getElementById('avatarNotificationCount');
    const notificationItems = document.getElementById('avatarNotificationItems');
    const readAllForm = document.getElementById('avatarReadAllForm');
    let notificationPollInProgress = false;
    const loginSucceeded = document.body.dataset.loginSucceeded === '1';
    let notificationAudioContext = null;
    let pendingSoundSequence = null;

    function setTheme(preference) {
      const useDarkTheme = preference === 'dark'
        || (preference === 'system' && systemTheme.matches);

      document.documentElement.dataset.theme = useDarkTheme ? 'dark' : 'light';
      localStorage.setItem('car-manager-theme', preference);
      themeChoices.forEach(function (choice) {
        choice.setAttribute('aria-pressed', String(choice.dataset.themeChoice === preference));
      });
    }

    function setAppTextColor(color) {
      if (color === 'default') {
        delete document.documentElement.dataset.appTextColor;
        localStorage.removeItem('car-manager-text-color');
        localStorage.removeItem('car-manager-login-text-color');
      } else if (['navy', 'blue', 'green', 'burgundy', 'purple', 'mixed'].includes(color)) {
        document.documentElement.dataset.appTextColor = color;
        localStorage.setItem('car-manager-text-color', color);
        localStorage.removeItem('car-manager-login-text-color');
      } else {
        return;
      }

      appTextColorChoices.forEach(function (choice) {
        choice.setAttribute('aria-pressed', String(choice.dataset.appTextColorChoice === color));
      });
    }

    function playSoundSequence(notes) {
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;

      if (!AudioContextClass) return;

      try {
        notificationAudioContext ||= new AudioContextClass();
      } catch (error) {
        return;
      }

      if (notificationAudioContext.state !== 'running') {
        pendingSoundSequence = notes;
        notificationAudioContext.resume().then(function () {
          playPendingSoundSequence();
        }).catch(function () {});
        return;
      }

      emitSoundSequence(notes);
    }

    function playNotificationChime() {
      playSoundSequence([
        { frequency: 784, delay: 0, duration: 0.18 },
        { frequency: 1046, delay: 0.16, duration: 0.18 },
      ]);
    }

    function playLoginChime() {
      playSoundSequence([
        { frequency: 523, delay: 0, duration: 0.14 },
        { frequency: 659, delay: 0.12, duration: 0.14 },
        { frequency: 784, delay: 0.24, duration: 0.22 },
      ]);
    }

    function playLogoutChime() {
      playSoundSequence([
        { frequency: 880, delay: 0, duration: 0.12, type: 'triangle' },
        { frequency: 587, delay: 0.16, duration: 0.14, type: 'triangle' },
        { frequency: 392, delay: 0.32, duration: 0.24, type: 'triangle' },
      ]);
    }

    function emitSoundSequence(notes) {
      notes.forEach(function (note) {
        const startsAt = notificationAudioContext.currentTime + note.delay;
        const oscillator = notificationAudioContext.createOscillator();
        const volume = notificationAudioContext.createGain();

        oscillator.type = note.type || 'sine';
        oscillator.frequency.value = note.frequency;
        volume.gain.setValueAtTime(0.0001, startsAt);
        volume.gain.exponentialRampToValueAtTime(0.12, startsAt + 0.02);
        volume.gain.exponentialRampToValueAtTime(0.0001, startsAt + note.duration);
        oscillator.connect(volume);
        volume.connect(notificationAudioContext.destination);
        oscillator.start(startsAt);
        oscillator.stop(startsAt + note.duration + 0.02);
      });
    }

    function playPendingSoundSequence() {
      if (!pendingSoundSequence || !notificationAudioContext
        || notificationAudioContext.state !== 'running') return;

      const notes = pendingSoundSequence;
      pendingSoundSequence = null;
      emitSoundSequence(notes);
    }

    function unlockNotificationSound() {
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;

      if (!notificationAudioContext && AudioContextClass) {
        try {
          notificationAudioContext = new AudioContextClass();
        } catch (error) {
          return;
        }
      }

      if (!notificationAudioContext || notificationAudioContext.state === 'running') return;

      notificationAudioContext.resume().then(function () {
        playPendingSoundSequence();
      }).catch(function () {});
    }

    function updateNotificationBadge(count) {
      let badge = avatarMenuToggle.querySelector('.avatar-notification-count');

      if (count === 0) {
        badge?.remove();
        return;
      }

      if (!badge) {
        badge = document.createElement('span');
        badge.className = 'avatar-notification-count';
        avatarMenuToggle.appendChild(badge);
      }

      badge.textContent = String(count);
      badge.setAttribute('aria-label', count + ' contrats expirés');
    }

    function renderNotificationItems(notifications, count) {
      if (!notificationItems) return;

      notificationItems.replaceChildren();

      if (notifications.length === 0) {
        const emptyMessage = document.createElement('p');
        emptyMessage.className = 'avatar-notifications-empty';
        emptyMessage.textContent = 'Aucune notification non lue. En attente de la prochaine expiration.';
        notificationItems.appendChild(emptyMessage);
      } else {
        notifications.forEach(function (item) {
          const form = document.createElement('form');
          form.className = 'avatar-notification-form';
          form.method = 'POST';
          form.action = avatarMenu.dataset.notificationReadUrlTemplate.replace(
            '__CONTRACT_ID__',
            encodeURIComponent(item.id)
          );

          const csrf = document.createElement('input');
          csrf.type = 'hidden';
          csrf.name = '_token';
          csrf.value = document.querySelector('meta[name="csrf-token"]').content;
          form.appendChild(csrf);

          const button = document.createElement('button');
          button.className = 'avatar-notification-item';
          button.type = 'submit';

          const icon = document.createElement('i');
          icon.className = 'bi bi-file-earmark-x';
          icon.setAttribute('aria-hidden', 'true');

          const content = document.createElement('span');
          const title = document.createElement('strong');
          title.textContent = 'Contrat ' + item.number;
          const detail = document.createElement('small');
          detail.textContent = item.client + ' · retour ' + item.returnDate;
          content.append(title, detail);
          button.append(icon, content);
          form.appendChild(button);
          notificationItems.appendChild(form);
        });
      }

      if (count > notifications.length) {
        const viewAll = document.createElement('a');
        viewAll.className = 'avatar-notifications-empty';
        viewAll.href = avatarMenu.dataset.contractIndexUrl;
        viewAll.textContent = 'Voir tous les contrats';
        notificationItems.appendChild(viewAll);
      }
    }

    async function pollContractNotifications() {
      if (!contractNotificationToggle
        || document.documentElement.dataset.contractNotifications === 'off'
        || document.hidden
        || notificationPollInProgress) return;

      notificationPollInProgress = true;

      try {
        const response = await fetch(avatarMenu.dataset.notificationStatusUrl, {
          headers: { Accept: 'application/json' },
          cache: 'no-store',
          credentials: 'same-origin',
        });

        if (!response.ok) return;

        const status = await response.json();
        const nextCount = Math.max(0, Number(status.count) || 0);
        const increased = nextCount > previousNotificationCount;

        notificationCount = nextCount;
        avatarMenu.dataset.notificationCount = String(nextCount);
        notificationCountDisplay.textContent = String(nextCount);
        readAllForm.hidden = nextCount === 0;
        updateNotificationBadge(nextCount);
        renderNotificationItems(status.notifications || [], nextCount);

        if (increased) playNotificationChime();

        previousNotificationCount = nextCount;
        localStorage.setItem(notificationCountKey, String(nextCount));
      } catch (error) {
        // Keep the last known count if the notification check cannot reach the server.
      } finally {
        notificationPollInProgress = false;
      }
    }

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.add('open');
      document.body.classList.add('sidebar-open');
      menuBtn.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
      document.body.classList.remove('sidebar-open');
      menuBtn.setAttribute('aria-expanded', 'false');
    }

    menuBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
    closeBtn.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && sidebar.classList.contains('open')) {
        closeSidebar();
        menuBtn.focus();
      }
    });
    themeMenuToggle.addEventListener('click', function () {
      const expanded = themeMenuToggle.getAttribute('aria-expanded') === 'true';
      themeMenuToggle.setAttribute('aria-expanded', String(!expanded));
      themeOptions.hidden = expanded;
    });
    themeSubmenuToggle.addEventListener('click', function () {
      const expanded = themeSubmenuToggle.getAttribute('aria-expanded') === 'true';
      themeSubmenuToggle.setAttribute('aria-expanded', String(!expanded));
      themeSubmenuOptions.hidden = expanded;
    });
    sidebarTextColorMenuToggle.addEventListener('click', function () {
      const expanded = sidebarTextColorMenuToggle.getAttribute('aria-expanded') === 'true';
      sidebarTextColorMenuToggle.setAttribute('aria-expanded', String(!expanded));
      sidebarTextColorOptions.hidden = expanded;
    });
    notificationSettingsToggle?.addEventListener('click', function () {
      const expanded = notificationSettingsToggle.getAttribute('aria-expanded') === 'true';
      notificationSettingsToggle.setAttribute('aria-expanded', String(!expanded));
      notificationSettingsOptions.hidden = expanded;
    });
    avatarThemeMenuToggle.addEventListener('click', function () {
      const expanded = avatarThemeMenuToggle.getAttribute('aria-expanded') === 'true';
      avatarThemeMenuToggle.setAttribute('aria-expanded', String(!expanded));
      avatarThemeOptions.hidden = expanded;
    });
    avatarTextColorMenuToggle.addEventListener('click', function () {
      const expanded = avatarTextColorMenuToggle.getAttribute('aria-expanded') === 'true';
      avatarTextColorMenuToggle.setAttribute('aria-expanded', String(!expanded));
      avatarTextColorOptions.hidden = expanded;
    });
    helpMenuToggle.addEventListener('click', function () {
      const expanded = helpMenuToggle.getAttribute('aria-expanded') === 'true';
      helpMenuToggle.setAttribute('aria-expanded', String(!expanded));
      helpOptions.hidden = expanded;
    });
    helpProblemsToggle.addEventListener('click', function () {
      const expanded = helpProblemsToggle.getAttribute('aria-expanded') === 'true';
      helpProblemsToggle.setAttribute('aria-expanded', String(!expanded));
      helpProblemsOptions.hidden = expanded;
    });
    avatarMenuToggle.addEventListener('click', function () {
      const expanded = avatarMenuToggle.getAttribute('aria-expanded') === 'true';
      avatarMenuToggle.setAttribute('aria-expanded', String(!expanded));
      avatarMenu.hidden = expanded;
    });
    avatarNotificationToggle?.addEventListener('click', function () {
      const expanded = avatarNotificationToggle.getAttribute('aria-expanded') === 'true';
      avatarNotificationToggle.setAttribute('aria-expanded', String(!expanded));
      avatarNotificationContent.hidden = expanded;
    });
    avatarAccountsToggle.addEventListener('click', function () {
      const expanded = avatarAccountsToggle.getAttribute('aria-expanded') === 'true';
      avatarAccountsToggle.setAttribute('aria-expanded', String(!expanded));
      avatarAccountOptions.hidden = expanded;
    });
    avatarAddAccountToggle.addEventListener('click', function () {
      const expanded = avatarAddAccountToggle.getAttribute('aria-expanded') === 'true';
      avatarAddAccountToggle.setAttribute('aria-expanded', String(!expanded));
      avatarAddAccountForm.hidden = expanded;
    });
    document.addEventListener('click', function (event) {
      if (!avatarMenu.hidden
        && !avatarMenu.contains(event.target)
        && !avatarMenuToggle.contains(event.target)) {
        avatarMenu.hidden = true;
        avatarMenuToggle.setAttribute('aria-expanded', 'false');
      }
    });
    themeChoices.forEach(function (choice) {
      choice.addEventListener('click', function () {
        setTheme(choice.dataset.themeChoice);
      });
    });
    appTextColorChoices.forEach(function (choice) {
      choice.addEventListener('click', function () {
        setAppTextColor(choice.dataset.appTextColorChoice);
      });
    });
    if (contractNotificationToggle) {
      contractNotificationToggle.checked = document.documentElement.dataset.contractNotifications !== 'off';
      contractNotificationToggle.addEventListener('change', function () {
        const enabled = contractNotificationToggle.checked;
        document.documentElement.dataset.contractNotifications = enabled ? 'on' : 'off';
        localStorage.setItem('car-manager-contract-notifications', enabled ? 'on' : 'off');
        if (enabled) pollContractNotifications();
      });
    }
    avatarUploadButton?.addEventListener('click', function () {
      avatarUploadInput?.click();
    });
    avatarUploadInput?.addEventListener('change', function () {
      if (avatarUploadInput.files.length > 0) avatarUploadInput.form.requestSubmit();
    });
    avatarIconMenuToggle?.addEventListener('click', function () {
      const expanded = avatarIconMenuToggle.getAttribute('aria-expanded') === 'true';
      avatarIconMenuToggle.setAttribute('aria-expanded', String(!expanded));
      avatarIconOptions.hidden = expanded;
    });
    window.addEventListener('pointerdown', unlockNotificationSound);
    window.addEventListener('keydown', unlockNotificationSound);

    document.querySelectorAll('.logout-form').forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (form.dataset.submitting === 'true') return;

        event.preventDefault();
        form.dataset.submitting = 'true';
        playLogoutChime();
        window.setTimeout(function () {
          HTMLFormElement.prototype.submit.call(form);
        }, 450);
      });
    });

    if (loginSucceeded) playLoginChime();

    if (!loginSucceeded && document.documentElement.dataset.contractNotifications !== 'off'
      && notificationCount > previousNotificationCount) {
      playNotificationChime();
    }
    localStorage.setItem(notificationCountKey, String(notificationCount));
    previousNotificationCount = notificationCount;
    pollContractNotifications();
    window.setInterval(pollContractNotifications, 30000);

    systemTheme.addEventListener('change', function () {
      if (localStorage.getItem('car-manager-theme') === 'system') setTheme('system');
    });
    setTheme(localStorage.getItem('car-manager-theme') || 'system');
    const savedAppTextColor = localStorage.getItem('car-manager-text-color')
      || localStorage.getItem('car-manager-login-text-color')
      || 'default';
    setAppTextColor(savedAppTextColor);

    window.addEventListener('resize', function () {
      if (window.innerWidth > 992) closeSidebar();
    });
  })();
</script>
@stack('scripts')
</body>
</html>
