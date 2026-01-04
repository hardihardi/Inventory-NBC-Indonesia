<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockAdjustment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'adjustment_no',
        'warehouse_id',
        'item_id',
        'qty_before',
        'qty_adjustment',
        'qty_after',
        'reason',
        'status',
        'created_by',
        'level_1_approved_by',
        'level_1_approved_at',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'level_1_approved_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function level1Approver()
    {
        return $this->belongsTo(User::class, 'level_1_approved_by');
    }

    public function finalApprover()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
