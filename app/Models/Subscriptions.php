<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable  = [
        'service',
        'client_id',
        'renewal_date',
        'renewal_period',
        'renewal_price',
        'last_payed'
    ];
}
