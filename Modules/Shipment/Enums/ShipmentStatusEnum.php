<?php

namespace Modules\Shipment\Enums;

use App\Support\Traits\EnumCommonTrait;

enum ShipmentStatusEnum: string
{
    use EnumCommonTrait;

    case Pending = 'pending';
    case PickedUp = 'picked_up';
    case InTransit = 'in_transit';
    case OutForDelivery = 'out_for_delivery';
    case Delivered = 'delivered';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function allowedTransitions(): array
    {
        return [
            self::Pending->value => [self::PickedUp, self::Cancelled],
            self::PickedUp->value => [self::InTransit, self::Cancelled],
            self::InTransit->value => [self::OutForDelivery],
            self::OutForDelivery->value => [self::Delivered, self::Failed],
            self::Delivered->value => [],
            self::Failed->value => [],
            self::Cancelled->value => [],
        ];
    }

    public static function canTransition(string $from, string $to): bool
    {
        $allowed = self::allowedTransitions()[$from] ?? [];

        return in_array($to, array_map(fn (self $status) => $status->value, $allowed), true);
    }
}
