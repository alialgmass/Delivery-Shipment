<?php

namespace Modules\Country\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Country\Databases\Factories\CountryFactory;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = [
        'name',
        'code',
        'phone_code',
        'is_active',
    ];

    public array $translatable = ['name'];

    protected static function newFactory()
    {
        return CountryFactory::new();
    }
}
