<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'type',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'cin',
        'nationalite',
        'numero_permis',
        'numero_passeport',
        'adresse_etranger',
        'telephone',
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
}