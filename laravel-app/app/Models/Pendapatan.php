<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'pendapatan' => 'decimal:2',
    ];
}
