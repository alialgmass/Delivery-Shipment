<?php

namespace Modules\Shipment\Models;

use App\Models\User;
use App\Support\Traits\HasCreatedByColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentStatusHistory extends Model
{
    use HasCreatedByColumn;

    protected $fillable = [
        'shipment_id',
        'status',
        'note',
        'location',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
