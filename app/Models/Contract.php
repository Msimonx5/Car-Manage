<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

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

// NEW — add this method anywhere in the class, e.g. right after getVehicleNameAttribute()
        public static function calculateDays($depart, $retour): int
        {
            $depart = \Illuminate\Support\Carbon::parse($depart)->startOfDay();
            $retour = \Illuminate\Support\Carbon::parse($retour)->startOfDay();

            return max(1, $depart->diffInDays($retour));
        }

        // MODIFIED — replace your existing getDurationAttribute()
        public function getDurationAttribute(): int
        {
            return static::calculateDays($this->date_depart, $this->date_retour);
        }

    /**
     * Instant exact de retour prévu (date + heure).
     * Source unique utilisée pour tout calcul d'expiration.
     */
    public function getReturnDeadlineAttribute(): \Illuminate\Support\Carbon
    {
        return $this->date_retour->copy()->setTimeFromTimeString(
            $this->heure_retour ?? '23:59:59'
        );
    }

    public function getIsExpiredAttribute(): bool
    {
        return now()->greaterThan(
            $this->return_deadline
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
    | Statut véhicule
    |--------------------------------------------------------------------------
    */

    /**
     * Aligne le statut du véhicule sur l'état réel du contrat.
     * Source unique utilisée par le contrôleur ET par releaseExpired().
     *
     * Loué  = contrat actif (en_attente / en_cours) ET pas encore expiré.
     * Sinon = disponible (terminé, annulé, ou en_cours mais expiré).
     */
    public function syncVehicleStatus(): void
    {
        $loue = in_array($this->statut, [
            ContractStatus::EN_ATTENTE,
            ContractStatus::EN_COURS,
        ], true) && ! $this->is_expired;

        $this->vehicle?->update([
            'statut' => $loue
                ? VehicleStatus::LOUE
                : VehicleStatus::DISPONIBLE,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Contrats dont la date/heure de retour est dépassée
     * mais qui n'ont jamais été clôturés.
     */
    public function scopeExpirable(Builder $query): Builder
    {
        return $query
            ->whereIn('statut', [
                ContractStatus::EN_ATTENTE,
                ContractStatus::EN_COURS,
            ])
            ->where(function (Builder $q) {

                $q->whereDate('date_retour', '<', now()->toDateString())
                  ->orWhere(function (Builder $q2) {

                      $q2->whereDate('date_retour', now()->toDateString())
                         ->where(function (Builder $q3) {

                             $q3->whereNull('heure_retour')
                                ->orWhere('heure_retour', '<=', now()->toTimeString());

                         });

                  });

            });
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

                    $contract->syncVehicleStatus();

                });

            });
    }

    public function infractions()
    {
        return $this->hasMany(Infraction::class);
    }
}