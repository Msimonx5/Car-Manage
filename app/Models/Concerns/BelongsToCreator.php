<?php

namespace App\Models\Concerns;

use App\Models\Scopes\CreatorScope;
use App\Models\User;
use App\Support\Tenancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Attribue automatiquement la ligne a son createur et filtre les lectures
 * pour que les comptes d'une meme agence ne partagent pas leurs clients.
 */
trait BelongsToCreator
{
    public static function bootBelongsToCreator(): void
    {
        static::addGlobalScope(new CreatorScope);

        static::creating(function (Model $model): void {
            if ($model->getAttribute('created_by') === null && Tenancy::restricted()) {
                $model->setAttribute('created_by', Auth::id());
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
