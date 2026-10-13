<?php

namespace App\Enums;

enum VehicleStatus:string
{
    case DISPONIBLE = 'disponible';

    case INDISPONIBLE = 'indisponible';

    case LOUE = 'loue';

    case MAINTENANCE = 'maintenance';

    case RESERVE = 'reserve';

    case HORS_SERVICE = 'hors_service';

    public function label(): string
    {
        return match($this){

            self::DISPONIBLE => 'Disponible',

            self::INDISPONIBLE => 'Indisponible',

            self::LOUE => 'Loué',

            self::MAINTENANCE => 'Maintenance',

            self::RESERVE => 'Réservé',

            self::HORS_SERVICE => 'Hors service',

        };
    }

    public function color(): string
    {
        return match($this){

            self::DISPONIBLE => 'success',

            self::INDISPONIBLE => 'danger',

            self::LOUE => 'primary',

            self::MAINTENANCE => 'warning',

            self::RESERVE => 'info',

            self::HORS_SERVICE => 'danger',

        };
    }
}
