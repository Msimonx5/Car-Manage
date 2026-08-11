<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'numero',

        'client_id',

        'vehicle_id',

        'second_driver_id',

        'date_depart',

        'heure_depart',

        'date_retour',

        'heure_retour',

        'km_depart',

        'km_retour',

        'tarif_jour',

        'nombre_jours',

        'avance',

        'caution',

        'total_ht',

        'tva',

        'total_ttc',

        'mode_paiement',

        'statut',

        'observation'

    ];

    protected $casts=[

        'date_depart'=>'date',

        'date_retour'=>'date',

        'tarif_jour'=>'decimal:2',

        'avance'=>'decimal:2',

        'caution'=>'decimal:2',

        'total_ht'=>'decimal:2',

        'tva'=>'decimal:2',

        'total_ttc'=>'decimal:2',

        'statut'=>ContractStatus::class,

    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function secondDriver()
    {
        return $this->belongsTo(
            Client::class,
            'second_driver_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getClientFullNameAttribute(): string
    {
        return $this->client
            ? $this->client->nom.' '.$this->client->prenom
            : '-';
    }

    public function getVehicleNameAttribute(): string
    {
        return $this->vehicle
            ? $this->vehicle->marque.' '.$this->vehicle->modele
            : '-';
    }

    public function getDurationAttribute(): int
    {
        return $this->date_depart
            ->diffInDays($this->date_retour) + 1;
    }

    public function getIsExpiredAttribute(): bool
    {
        return now()->greaterThan(
            $this->date_retour
        );
    }

    public function getRemainingDaysAttribute(): int
    {
        if ($this->is_expired) {
            return 0;
        }

        return now()->diffInDays(
            $this->date_retour,
            false
        );
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->statut->value){

            'en_attente'=>'warning',

            'en_cours'=>'primary',

            'termine'=>'success',

            'annule'=>'danger',

            default=>'secondary'

        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format(
            $this->total_ttc,
            2,
            ',',
            ' '
        ).' DH';
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format(
            $this->balance,
            2,
            ',',
            ' '
        ).' DH';
    }

    public function isFinished(): bool
    {
        return $this->statut->value === 'termine';
    }

    public function isRunning(): bool
    {
        return $this->statut->value === 'en_cours';
    }

    public function isCanceled(): bool
    {
        return $this->statut->value === 'annule';
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Contrats dont la date de retour est dépassée
     * mais qui n'ont jamais été clôturés.
     */
    public function scopeExpirable(Builder $query): Builder
    {
        return $query
            ->whereIn('statut', [
                ContractStatus::EN_ATTENTE,
                ContractStatus::EN_COURS,
            ])
            ->whereDate('date_retour', '<', now()->toDateString());
    }

    /**
     * Clôture les contrats expirés et libère leurs véhicules.
     */
    public static function releaseExpired(): void
    {
        static::query()
            ->expirable()
            ->with('vehicle')
            ->get()
            ->each(function (self $contract) {

                DB::transaction(function () use ($contract) {

                    $contract->update([
                        'statut' => ContractStatus::TERMINE,
                    ]);

                    $contract->vehicle?->update([
                        'statut' => VehicleStatus::DISPONIBLE,
                    ]);

                });

            });
    }
}