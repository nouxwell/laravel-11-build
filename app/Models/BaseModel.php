<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
            $model->updated_at = now();
            $model->created_by = Auth::user()->name ?? null;
        });

        static::updating(function ($model) {
            $model->updated_at = now();
            $model->updated_by = Auth::user()->name ?? null;
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::user()->name ?? null;
        });
    }
}
