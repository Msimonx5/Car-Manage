<?php

namespace App\Enums;

enum ContractStatus:string
{
    case EN_ATTENTE='en_attente';

    case EN_COURS='en_cours';

    case TERMINE='termine';

    case ANNULE='annule';

    public function label():string
    {
        return match($this){

            self::EN_ATTENTE=>'En attente',

            self::EN_COURS=>'En cours',

            self::TERMINE=>'Terminé',

            self::ANNULE=>'Annulé',

        };
    }

    public function color():string
    {
        return match($this){

            self::EN_ATTENTE=>'warning',

            self::EN_COURS=>'primary',

            self::TERMINE=>'success',

            self::ANNULE=>'danger',

        };
    }
}