<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'status', 'date', 'created_at', 'updated_at'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscriptions::class, 'invoiceID');
    }
}
