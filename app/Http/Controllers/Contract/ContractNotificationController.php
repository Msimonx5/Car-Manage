<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContractNotificationController extends Controller
{
    public function status(): JsonResponse
    {
        $readIds = DB::table('contract_notification_reads')
            ->where('user_id', Auth::id())
            ->pluck('contract_id')
            ->all();
        $unreadContracts = Contract::query()->expired();

        if ($readIds !== []) {
            $unreadContracts->whereNotIn('id', $readIds);
        }

        $count = (clone $unreadContracts)->count();
        $notifications = $unreadContracts
            ->with(['client:id,nom,prenom'])
            ->latest('date_retour')
            ->latest('heure_retour')
            ->limit(5)
            ->get()
            ->map(fn (Contract $contract): array => [
                'id' => $contract->getKey(),
                'number' => $contract->numero,
                'client' => $contract->client_full_name,
                'returnDate' => $contract->date_retour->format('d/m/Y'),
            ])
            ->values();

        return response()->json([
            'count' => $count,
            'notifications' => $notifications,
        ]);
    }

    public function read(Contract $contract): RedirectResponse
    {
        abort_unless(
            Contract::query()->expired()->whereKey($contract->getKey())->exists(),
            404
        );

        $expiredContractIds = Contract::query()->expired()->pluck('id')->all();
        $this->storeReadIds($expiredContractIds);

        return redirect()->route('contracts.show', $contract);
    }

    public function readAll(): RedirectResponse
    {
        $contractIds = Contract::query()->expired()->pluck('id')->all();
        $this->storeReadIds($contractIds);

        return back();
    }

    private function storeReadIds(array $contractIds): void
    {
        $now = now();
        $records = array_map(
            fn (int $contractId): array => [
                'user_id' => Auth::id(),
                'contract_id' => $contractId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            array_values(array_unique(array_map('intval', $contractIds)))
        );

        if ($records !== []) {
            DB::table('contract_notification_reads')->insertOrIgnore($records);
        }
    }
}