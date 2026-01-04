<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'notes',
        'total_amount',
        'paid_amount',
        'payment_method',
        'payment_status',
        'due_date',
        'user_id',
        'purchase_number',
        'invoice_number',
        'reference_number', 
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'due_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PembelianItem::class);
    }

    public function getTotalAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function cashFlows()
    {
        return $this->hasMany(CashFlow::class, 'reference_id')->where('reference_type', 'Pembelian');
    }
}