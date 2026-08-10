<?php

namespace App\Enums;

enum OilChangeStatus:string
{
    case OK='success';

    case WARNING='warning';

    case DANGER='danger';

    case UNKNOWN='secondary';

    public function label():string
    {
        return match($this){

            self::OK=>"OK",

            self::WARNING=>"Bientôt",

            self::DANGER=>"Urgente",

            self::UNKNOWN=>"Non définie"

        };
    }
}