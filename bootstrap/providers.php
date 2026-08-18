<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FortifyServiceProvider;
use Modules\Admin\Providers\AdminServiceProvider;
use Modules\Admin\Providers\EventServiceProvider as AdminEventServiceProvider;
use Modules\Admin\Providers\RouteServiceProvider as AdminRouteServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Auth\Providers\EventServiceProvider as AuthEventServiceProvider;
use Modules\Auth\Providers\RouteServiceProvider as AuthRouteServiceProvider;
use Modules\Country\Providers\CountryServiceProvider;
use Modules\Country\Providers\EventServiceProvider as CountryEventServiceProvider;
use Modules\Country\Providers\RouteServiceProvider as CountryRouteServiceProvider;
use Modules\Delivery\Providers\DeliveryServiceProvider;
use Modules\Delivery\Providers\EventServiceProvider as DeliveryEventServiceProvider;
use Modules\Delivery\Providers\RouteServiceProvider as DeliveryRouteServiceProvider;
use Modules\Shipment\Providers\ShipmentServiceProvider;
use Modules\Shipment\Providers\EventServiceProvider as ShipmentEventServiceProvider;
use Modules\Shipment\Providers\RouteServiceProvider as ShipmentRouteServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\User\Providers\EventServiceProvider as UserEventServiceProvider;
use Modules\User\Providers\RouteServiceProvider as UserRouteServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    AdminPanelProvider::class,
    AdminServiceProvider::class,
    AdminEventServiceProvider::class,
    AdminRouteServiceProvider::class,
    AuthServiceProvider::class,
    AuthEventServiceProvider::class,
    AuthRouteServiceProvider::class,
    CountryServiceProvider::class,
    CountryEventServiceProvider::class,
    CountryRouteServiceProvider::class,
    DeliveryServiceProvider::class,
    DeliveryEventServiceProvider::class,
    DeliveryRouteServiceProvider::class,
    ShipmentServiceProvider::class,
    ShipmentEventServiceProvider::class,
    ShipmentRouteServiceProvider::class,
    UserServiceProvider::class,
    UserEventServiceProvider::class,
    UserRouteServiceProvider::class,
];
