<?php

namespace App\Enums;

enum TechnicalInspectionStatus:string
{
    case VALID='success';

    case EXPIRE_SOON='warning';

    case EXPIRED='danger';

    case UNKNOWN='secondary';
}