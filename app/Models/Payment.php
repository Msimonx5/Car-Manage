<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Concerns\BelongsToCreator;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use BelongsToTenant, BelongsToCreator;
}
