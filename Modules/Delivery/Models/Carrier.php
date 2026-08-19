<?php

namespace Modules\Delivery\Models;

use App\Support\Traits\HasCreatedByColumn;
use App\Support\Traits\HasOrderBy;
use App\Support\Traits\HasUpdatedByColumn;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Delivery\Databases\Factories\CarrierFactory;

class Carrier extends Model
{
    use HasCreatedByColumn;
    use HasFactory;
    use HasOrderBy;
    use HasUpdatedByColumn;

    protected $fillable = [
        'name',
        'phone',
        'vehicle_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): Factory
    {
        return CarrierFactory::new();
    }
}
