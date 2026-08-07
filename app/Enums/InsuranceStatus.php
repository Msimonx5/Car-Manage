<?php

namespace App\Enums;

enum InsuranceStatus:string
{
    case VALID='success';

    case EXPIRE_SOON='warning';

    case EXPIRED='danger';

    case UNKNOWN='secondary';
}