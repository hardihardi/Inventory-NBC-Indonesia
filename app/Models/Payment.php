<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reference_type',
        'reference_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relatable()
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }
}
