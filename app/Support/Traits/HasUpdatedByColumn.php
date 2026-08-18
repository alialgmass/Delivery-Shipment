<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

trait HasUpdatedByColumn
{
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public static function bootHasUpdatedByColumn(): void
    {

        static::updating(function (Model $model) {
            $model->updated_by = user('id');
        });

    }
}
