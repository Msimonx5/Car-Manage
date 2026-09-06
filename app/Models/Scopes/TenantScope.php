<?php

namespace App\Models\Scopes;

use App\Support\Tenancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Restreint automatiquement toute requete au tenant de l'utilisateur connecte.
 */
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! Tenancy::restricted()) {
            return;
        }

        $tenantId = Tenancy::currentId();

        // Compte sans agence : on ne renvoie rien, au lieu de tout renvoyer.
        if ($tenantId === null) {
            $builder->whereRaw('1 = 0');

            return;
        }

        $builder->where($model->qualifyColumn('tenant_id'), $tenantId);
    }
}
