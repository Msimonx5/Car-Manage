<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Concerns\BelongsToCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use BelongsToTenant, BelongsToCreator, HasFactory, SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'type',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'ville',
        'code_postal',
        'cin',
        'nationalite',
        'numero_permis',
        'numero_passeport',
        'adresse_etranger',
        'telephone',
        'email',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function principalContracts()
    {
        return $this->hasMany(Contract::class, 'client_principal_id');
    }

    public function secondaryContracts()
    {
        return $this->hasMany(Contract::class, 'client_secondaire_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    public function infractions()
    {
        return $this->hasMany(Infraction::class);
    }
}
