<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'item_id',
        'qty_needed',
        'qty_used'
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    /**
     * Item bahan baku
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
