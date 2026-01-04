<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'is_default',
    ];

    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function transfersFrom()
    {
        return $this->hasMany(StockTransfer::class, 'from_warehouse_id');
    }

    public function transfersTo()
    {
        return $this->hasMany(StockTransfer::class, 'to_warehouse_id');
    }

    public function adjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function ledgers()
    {
        return $this->hasMany(StockLedger::class);
    }
}
