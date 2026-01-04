<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    protected $fillable = [
        'item_id',
        'warehouse_id',
        'qty_change',
        'qty_after',
        'type',
        'reference_type',
        'reference_id',
        'notes',
        'user_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log stock movement
     */
    public static function log($itemId, $warehouseId, $qtyChange, $qtyAfter, $type, $refId = null, $refType = null, $notes = null)
    {
        return self::create([
            'item_id' => $itemId,
            'warehouse_id' => $warehouseId,
            'qty_change' => $qtyChange,
            'qty_after' => $qtyAfter,
            'type' => $type,
            'reference_id' => $refId,
            'reference_type' => $refType,
            'notes' => $notes,
            'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
        ]);
    }
}
