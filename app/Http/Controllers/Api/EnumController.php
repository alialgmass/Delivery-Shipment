<?php

namespace App\Http\Controllers\Api;

use App\Enums\CurrencyEnum;

class EnumController extends ApiController
{
    public function __invoke()
    {

        return self::apiBody([
            'currencies' => CurrencyEnum::toArray(),
        ])->apiResponse();
    }
}
