<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infraction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'infractions';

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | Relations
        |--------------------------------------------------------------------------
        */

        'contract_id',
        'client_id',
        'vehicle_id',

        /*
        |--------------------------------------------------------------------------
        | Informations client
        |--------------------------------------------------------------------------
        */

        'nom',
        'prenom',
        'cin',
        'numero_permis',
        'adresse',
        'ville',
        'code_postal',
        'telephone',
        'email',

        /*
        |--------------------------------------------------------------------------
        | Informations véhicule
        |--------------------------------------------------------------------------
        */

        'immatriculation',
        'marque',
        'modele',

        /*
        |--------------------------------------------------------------------------
        | Informations contrat
        |--------------------------------------------------------------------------
        */

        'numero_contrat',
        'date_depart',
        'heure_depart',
        'date_retour',
        'heure_retour',
    ];

    protected $casts = [

        'date_depart' => 'date',
        'date_retour' => 'date',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
