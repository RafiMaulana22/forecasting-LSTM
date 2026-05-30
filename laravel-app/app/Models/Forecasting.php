<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecasting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_prediksi' => 'date',
        'hasil_prediksi' => 'decimal:2',
    ];
}
