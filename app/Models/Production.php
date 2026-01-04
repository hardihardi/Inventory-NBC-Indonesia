<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'batch_number',
        'item_id',
        'qty_planned',
        'qty_actual',
        'waste_qty',
        'waste_reason',
        'machine_name',
        'total_cost',
        'status',
        'start_date',
        'end_date',
        'notes',
        'user_id'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Item yang diproduksi (Finished Good)
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * User pembuat (PIC)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bahan baku yang digunakan
     */
    public function materials()
    {
        return $this->hasMany(ProductionMaterial::class);
    }
}
