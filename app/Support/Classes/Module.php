<?php

namespace App\Support\Classes;

class Module
{
    public static function registered(): array
    {

        return [
            'Admin',
            'Auth',
            'Country',
            'Delivery',
            'Shipment',
            'User',
        ];
    }
}
