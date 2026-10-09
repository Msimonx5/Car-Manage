@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

@php
    $pillMap = [
        'en_attente' => ['attente', 'En attente'],
        'en_cours'   => ['cours', 'En cours'],
        'termine'    => ['termine', 'Terminé'],
        'annule'     => ['annule', 'Annulé'],
    ];
    $avatarColors = ['#4f46e5', '#0ea5e9', '#16a34a', '#f59e0b', '#8b5cf6', '#ef4444'];
@endphp

{{-- ===================== KPI ROW ===================== --}}
<div class="row g-3 mb-3">

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('clients.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-primary"><i class="bi bi-people"></i></div>
                <span class="trend {{ $newClientsThisMonth > 0 ? 'up' : 'flat' }}">
                    <i class="bi bi-arrow-up-short"></i>{{ $newClientsThisMonth }}
                </span>
            </div>
            <div class="val">{{ $totalClients }}</div>
            <div class="lbl">Clients enregistrés</div>
            <div class="sub">{{ $newClientsThisMonth }} nouveau(x) ce mois-ci</div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('vehicles.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-success"><i class="bi bi-car-front"></i></div>
                <span class="trend flat">{{ $fleetUtilization }}% util.</span>
            </div>
            <div class="val">{{ $totalVehicles }}</div>
            <div class="lbl">Véhicules — flotte</div>
            <div class="sub">
                <span style="color:var(--success);font-weight:600">{{ $availableVehicles }} disponibles</span>
                · {{ $rentedVehicles }} loués
            </div>
        </a>
    </div>

@can('view-contracts')
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('contracts.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-warning"><i class="bi bi-file-earmark-text"></i></div>
                <span class="trend flat">{{ $activeContracts }} actifs</span>
            </div>
            <div class="val">{{ $totalContracts }}</div>
            <div class="lbl">Contrats au total</div>
            <div class="sub">
                <span style="color:var(--info);font-weight:600">{{ $activeContracts }} en cours</span>
                · {{ $pendingContracts }} en attente
            </div>
        </a>
    </div>
@endcan

    <div class="col-xl-3 col-md-6">
        {{-- Le chiffre d'affaires vient des contrats : sans acces a ceux-ci,
             la carte reste affichee mais ne renvoie plus vers une page interdite. --}}
        <a href="{{ auth()->user()?->can('view-contracts') ? route('contracts.index') : route('dashboard') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-info"><i class="bi bi-cash-coin"></i></div>
                @if(is_null($revenueTrend))
                    <span class="trend flat">—</span>
                @elseif($revenueTrend >= 0)
                    <span class="trend up"><i class="bi bi-arrow-up-short"></i>{{ $revenueTrend }}%</span>
                @else
                    <span class="trend down"><i class="bi bi-arrow-down-short"></i>{{ abs($revenueTrend) }}%</span>
                @endif
            </div>
            <div class="val">{{ number_format($totalRevenue, 0, ',', ' ') }}
                <small style="font-size:14px;font-weight:600;color:var(--muted)">DH</small></div>
            <div class="lbl">{{ auth()->user()?->can('view-contracts') ? 'Chiffre d’affaires' : 'CA des infractions' }}</div>
            <div class="sub">{{ auth()->user()?->can('view-contracts') ? 'Ce mois' : 'Infractions ce mois' }} : <b>{{ number_format($monthlyRevenue, 0, ',', ' ') }} DH</b></div>
        </a>
    </div>

</div>

{{-- ===================== CHART + DOUGHNUT ===================== --}}
<div class="row g-3 mb-3">
    <div class="col-xl-8">
        <div class="card2 h-100">
            <div class="hd"><h5>Chiffre d'affaires</h5><span class="mut" style="font-size:12.5px">6 derniers mois</span></div>
            <div style="padding:8px 16px 16px"><canvas id="revChart" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card2 h-100">
            <div class="hd"><h5>État de la flotte</h5></div>
            <div style="padding:16px 20px 20px">
                <div style="max-width:200px;margin:0 auto 18px"><canvas id="fleetChart"></canvas></div>
                <div class="legend">
                    <div class="row2"><span class="dot" style="background:var(--success)"></span><span class="t">Disponibles</span><span class="n">{{ $availableVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--primary)"></span><span class="t">Loués</span><span class="n">{{ $rentedVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--warning)"></span><span class="t">Maintenance</span><span class="n">{{ $maintenanceVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--info)"></span><span class="t">Réservés</span><span class="n">{{ $reservedVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:#cbd5e1"></span><span class="t">Hors service</span><span class="n">{{ $outOfServiceVehicles }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== CONTRACT STATUS + ALERTS ===================== --}}
<div class="row g-3 mb-3">
@can('view-contracts')
    <div class="col-xl-8">
        <div class="card2 h-100">
            <div class="hd"><h5>État des contrats</h5><a href="{{ route('contracts.index') }}">Voir tous</a></div>
            <div style="padding:18px 20px 20px">
                <div class="row g-3">
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">🕓 En attente</div><div class="v" style="color:var(--warning)">{{ $pendingContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">🚗 En cours</div><div class="v" style="color:var(--info)">{{ $activeContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">✅ Terminés</div><div class="v" style="color:var(--success)">{{ $finishedContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">✖ Annulés</div><div class="v" style="color:var(--danger)">{{ $cancelledContracts }}</div></div></div>
                </div>
                @php $t = max($totalContracts, 1); @endphp
                <div style="margin-top:18px">
                    <div class="d-flex justify-content-between mb-2" style="font-size:12.5px;color:var(--muted)">
                        <span>Taux de conversion (hors annulés)</span>
                        <span style="font-weight:700;color:var(--ink)">{{ $conversionRate }}%</span>
                    </div>
                    <div style="height:10px;border-radius:20px;background:#eef0f4;overflow:hidden;display:flex">
                        <div style="width:{{ $pendingContracts / $t * 100 }}%;background:var(--warning)"></div>
                        <div style="width:{{ $activeContracts / $t * 100 }}%;background:var(--info)"></div>
                        <div style="width:{{ $finishedContracts / $t * 100 }}%;background:var(--success)"></div>
                        <div style="width:{{ $cancelledContracts / $t * 100 }}%;background:var(--danger)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
    <div class="col-xl-4">
        <div class="card2 h-100">
            <div class="hd"><h5>Alertes à traiter</h5>
                <span class="badge rounded-pill" style="background:var(--danger-tint);color:var(--danger)">{{ $alerts->count() }}</span>
            </div>
            <div style="padding:6px 20px 16px">
                @forelse($alerts as $a)
                    <div class="alert2">
                        <div class="ic tint-{{ $a['tint'] }}"><i class="bi {{ $a['icon'] }}"></i></div>
                        <div class="g"><b>{{ $a['title'] }}</b><div>{{ $a['detail'] }}</div></div>
                        <span class="pill {{ $a['class'] }}">{{ $a['badge'] }}</span>
                    </div>
                @empty
                    <div class="text-center py-4" style="color:var(--muted)">
                        <i class="bi bi-check-circle" style="font-size:2rem;color:var(--success)"></i>
                        <p class="mb-0 mt-2">Aucune alerte — tout est à jour ✅</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===================== RECENT CONTRACTS ===================== --}}
@can('view-contracts')
<div class="card2">
    <div class="hd"><h5>Derniers contrats</h5><a href="{{ route('contracts.index') }}">Voir tous <i class="bi bi-arrow-right"></i></a></div>
    <div style="padding:8px 4px 4px;overflow-x:auto">
        <table class="t2">
            <thead>
                <tr><th>N°</th><th>Client</th><th>Véhicule</th><th>Départ</th><th>Retour</th><th>Total</th><th>Statut</th></tr>
            </thead>
            <tbody>
                @forelse($recentContracts as $i => $contract)
                    @php
                        [$pillClass, $pillLabel] = $pillMap[$contract->statut->value] ?? ['cours', $contract->statut->value];
                        $prenom = $contract->client?->prenom ?? '';
                        $nom = $contract->client?->nom ?? '—';
                        $initials = strtoupper(mb_substr($prenom, 0, 1) . mb_substr($nom, 0, 1));
                        $color = $avatarColors[$i % count($avatarColors)];
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $contract->numero }}</td>
                        <td>
                            <div class="cust">
                                <span class="av" style="background:{{ $color }}">{{ $initials ?: '—' }}</span>
                                {{ trim($prenom . ' ' . $nom) ?: '—' }}
                            </div>
                        </td>
                        <td>
                            {{ $contract->vehicle?->full_name ?? '—' }}
                            <span class="mut">· {{ $contract->vehicle?->immatriculation }}</span>
                        </td>
                        <td>{{ $contract->date_depart?->format('d/m/Y') }}</td>
                        <td>{{ $contract->date_retour?->format('d/m/Y') }}</td>
                        <td class="fw-semibold nowrap">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</td>
                        <td><span class="pill {{ $pillClass }}">{{ $pillLabel }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 mut">Aucun contrat trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endcan

@endsection

@push('scripts')
<script>
  const _line = '#eceef2', _muted = '#6b7280';

  // Revenue area chart
  const rc = document.getElementById('revChart').getContext('2d');
  const grad = rc.createLinearGradient(0, 0, 0, 220);
  grad.addColorStop(0, 'rgba(79,70,229,.25)');
  grad.addColorStop(1, 'rgba(79,70,229,0)');
  new Chart(rc, {
    type: 'line',
    data: {
      labels: @json($revenueSeries->pluck('label')),
      datasets: [{
        data: @json($revenueSeries->pluck('value')),
        borderColor: '#4f46e5', backgroundColor: grad, fill: true,
        tension: .4, borderWidth: 2.5, pointRadius: 4, pointBackgroundColor: '#fff',
        pointBorderColor: '#4f46e5', pointBorderWidth: 2, pointHoverRadius: 6
      }]
    },
    options: {
      plugins: { legend: { display: false },
        tooltip: { callbacks: { label: c => ' ' + c.parsed.y.toLocaleString('fr') + ' DH' } } },
      scales: {
        y: { border: { display: false }, grid: { color: _line },
          ticks: { color: _muted, callback: v => (v / 1000) + 'k' } },
        x: { border: { display: false }, grid: { display: false }, ticks: { color: _muted } }
      }
    }
  });

  // Fleet doughnut
  new Chart(document.getElementById('fleetChart'), {
    type: 'doughnut',
    data: {
      labels: ['Disponibles', 'Loués', 'Maintenance', 'Réservés', 'Hors service'],
      datasets: [{
        data: [{{ $availableVehicles }}, {{ $rentedVehicles }}, {{ $maintenanceVehicles }}, {{ $reservedVehicles }}, {{ $outOfServiceVehicles }}],
        backgroundColor: ['#16a34a', '#4f46e5', '#f59e0b', '#0ea5e9', '#cbd5e1'],
        borderWidth: 0, cutout: '70%'
      }]
    },
    options: { plugins: { legend: { display: false } } }
  });
</script>
@endpush
