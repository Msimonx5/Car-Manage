<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\BelongsToTenant;
use App\Models\Concerns\BelongsToCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Enums\VehicleStatus;

class Vehicle extends Model
{
    use BelongsToTenant, BelongsToCreator, HasFactory, SoftDeletes;

    /**
     * Table
     */
    protected $table = 'vehicles';

    /**
     * Assignation massive
     */
    protected $fillable = [

        'marque',
        'modele',
        'annee',
        'couleur',

        'immatriculation',
        'numero_chassis',
        'numero_moteur',

        'carburant',
        'boite_vitesse',
        'nombre_places',

        'prix_jour',
        'caution',

        'kilometrage',

        'derniere_vidange_km',
        'derniere_vidange_date',
        'adblue_date',
        'prochaine_vidange_km',
        'filtre_air_date',
        'filtre_huile_date',
        'filtre_carburant_date',
        'filtre_habitacle_date',
        'pneus_date',
        'pneus_description',
        'pneus_quantite_remplacee',
        'plaquettes_frein_date',
        'plaquettes_frein_description',
        'plaquettes_frein_quantite_remplacee',

        'assurance_expiration',
        'visite_technique',

        'statut',

        'observation',

    ];

    /**
     * Casts
     */
    protected $casts=[

        'statut'=>VehicleStatus::class,

        'annee'=>'integer',

        'prix_jour'=>'decimal:2',

        'caution'=>'decimal:2',

        'kilometrage'=>'integer',

        'derniere_vidange_date'=>'date',
        'filtre_air_date' => 'date',
        'filtre_huile_date' => 'date',
        'filtre_carburant_date' => 'date',
        'filtre_habitacle_date' => 'date',
        'pneus_date' => 'date',
        'plaquettes_frein_date' => 'date',
        'pneus_quantite_remplacee' => 'integer',
        'plaquettes_frein_quantite_remplacee' => 'integer',

        'assurance_expiration'=>'date',

        'visite_technique'=>'date',

    ];

    /**
     * Attributs calculés
     */
    protected $appends = [

        'full_name',

        'remaining_oil_change',

        'oil_change_status',

        'insurance_status',

        'technical_status',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return "{$this->marque} {$this->modele}";
    }

    /**
     * Kilomètres restants avant vidange
     */
    public function getRemainingOilChangeAttribute(): ?int
    {
        if (!$this->prochaine_vidange_km) {
            return null;
        }

        return max(
            0,
            $this->prochaine_vidange_km - $this->kilometrage
        );
    }

    /**
     * Etat de la vidange
     */
    public function getOilChangeStatusAttribute(): string
    {
        if (!$this->prochaine_vidange_km) {

            return 'unknown';

        }

        $reste = $this->remaining_oil_change;

        if ($reste <= 0) {

            return 'danger';

        }

        if ($reste <= 1000) {

            return 'warning';

        }

        return 'success';
    }

    /**
     * Etat assurance
     */
    public function getInsuranceStatusAttribute(): string
    {
        if (!$this->assurance_expiration) {

            return 'unknown';

        }

        if ($this->assurance_expiration->isPast()) {

            return 'danger';

        }

        if (
            now()->diffInDays($this->assurance_expiration, false)
            <= 30
        ) {

            return 'warning';

        }

        return 'success';
    }

    /**
     * Etat visite technique
     */
    public function getTechnicalStatusAttribute(): string
    {
        if (!$this->visite_technique) {

            return 'unknown';

        }

        if ($this->visite_technique->isPast()) {

            return 'danger';

        }

        if (
            now()->diffInDays($this->visite_technique, false)
            <= 30
        ) {

            return 'warning';

        }

        return 'success';
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeDisponible(Builder $query): Builder
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeLoue(Builder $query): Builder
    {
        return $query->where('statut', 'loue');
    }

    public function scopeMaintenance(Builder $query): Builder
    {
        return $query->where('statut', 'maintenance');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isDisponible():bool
    {
        return $this->statut===VehicleStatus::DISPONIBLE;
    }

    public function isLoue(): bool
    {
        return $this->statut === VehicleStatus::LOUE;
    }

    public function isMaintenance(): bool
    {
        return $this->statut === VehicleStatus::MAINTENANCE;
    }

    public function infractions()
    {
        return $this->hasMany(Infraction::class);
    }

    public function getEffectiveStatusAttribute(): VehicleStatus
    {
        $status = $this->statut;

        if ($status !== VehicleStatus::DISPONIBLE) {
            return $status;
        }

        $hasActiveInfraction = $this->infractions()
            ->whereDate('date_depart', '<=', now()->toDateString())
            ->whereDate('date_retour', '>=', now()->toDateString())
            ->exists();

        return $hasActiveInfraction ? VehicleStatus::INDISPONIBLE : $status;
    }
}
