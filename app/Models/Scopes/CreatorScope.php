<?php

namespace App\Models\Scopes;

use App\Support\Tenancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

/**
 * Restreint les donnees personnelles au compte qui les a creees.
 *
 * Le filtre par tenant reste applique en parallele. Un administrateur de la
 * plateforme garde une vue globale, tandis qu'un owner et un gestionnaire ne
 * voient chacun que leurs propres clients.
 */
class CreatorScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! Tenancy::restricted()) {
            return;
        }

        $userId = Auth::id();

        if ($userId === null) {
            $builder->whereRaw('1 = 0');

            return;
        }

        $builder->where($model->qualifyColumn('created_by'), $userId);
    }
}
