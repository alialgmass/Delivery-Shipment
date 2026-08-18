<?php

namespace App\Filament;

use Filament\Pages\SettingsPage;
use Illuminate\Support\Str;

abstract class BaseSettingsPage extends SettingsPage
{
    public static function repository(): string
    {
        return static::$settings ?? Str::of(class_basename(static::class))
            ->remove('Page')
            ->singular()
            ->camel()
            ->ucfirst()
            ->toString();
    }

    public static function getNavigationGroup(): string
    {
        $navigationGroup = static::$navigationGroup ?? static::$title ?? str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();

        return __("filament.groups.{$navigationGroup}");
    }

    public static function getTitleCasePluralModelLabel(): string
    {
        return Str::ucwords(__('filament.sidebar.'.static::getPluralModelLabel()));
    }

    public function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return Str::ucwords(__('filament.headers.'.parent::getTitle()));
    }

    public static function getNavigationLabel(): string
    {
        return Str::ucwords(__('filament.sidebar.'.parent::getNavigationLabel()));
    }
}
