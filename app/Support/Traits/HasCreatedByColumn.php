<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

trait HasCreatedByColumn
{
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function bootHasCreatedByColumn(): void
    {

        static::creating(function (Model $model) {
            $model->created_by = user('id');
        });

    }
}
