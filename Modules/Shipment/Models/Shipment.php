<?php

namespace Modules\Shipment\Models;

use App\Models\User;
use App\Support\Traits\Filterable;
use App\Support\Traits\HasCreatedByColumn;
use App\Support\Traits\HasOrderBy;
use App\Support\Traits\HasUpdatedByColumn;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Delivery\Models\Carrier;
use Modules\Shipment\Databases\Factories\ShipmentFactory;
use Modules\Shipment\Enums\ShipmentStatusEnum;

class Shipment extends Model
{
    use Filterable;
    use HasCreatedByColumn;
    use HasFactory;
    use HasOrderBy;
    use HasUpdatedByColumn;

    protected $fillable = [
        'tracking_code',
        'customer_id',
        'carrier_id',
        'sender_address',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'weight_kg',
        'cod_amount',
        'description',
        'status',
        'picked_up_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'weight_kg' => 'decimal:2',
            'cod_amount' => 'decimal:2',
            'status' => ShipmentStatusEnum::class,
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    protected static function newFactory(): Factory
    {
        return ShipmentFactory::new();
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ShipmentStatusHistory::class);
    }
}
