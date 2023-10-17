<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEquity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'symbol',
        'percentage_stage',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'refreshed_at'
    ];

    protected $hidden = ['id'];

    protected $casts = [
        'refreshed_at' => 'datetime'
    ];
}
