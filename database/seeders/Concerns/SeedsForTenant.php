<?php

namespace Database\Seeders\Concerns;

use App\Models\Tenant;

/**
 * Les seeders s'executent hors session HTTP : le rattachement automatique a
 * l'agence connectee ne s'applique pas. Sans tenant_id explicite, les lignes
 * creees ne seraient visibles par aucun compte.
 */
trait SeedsForTenant
{
    protected function tenantId(): int
    {
        return Tenant::updateOrCreate(
            ['slug' => 'agence-principale'],
            ['name' => 'Task manager']
        )->id;
    }
}
