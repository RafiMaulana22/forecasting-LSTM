<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'mae' => 'float',
        'rmse' => 'float',
        'mape' => 'float',
        'loss' => 'float',
    ];
}
