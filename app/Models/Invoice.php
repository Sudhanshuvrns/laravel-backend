<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'invoice_id',
        'invoice_number',
        'client_name',
        'total_amount',
        'template_id',
        'invoice_data',
    ];

    protected $casts = [
        'invoice_data' => 'array',
    ];
}
