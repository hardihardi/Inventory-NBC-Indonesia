<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * PERBAIKAN: Menambahkan 'purchase_price' ke fillable.
     * Semua kolom spesifik juga dimasukkan agar bisa diisi.
     */
    protected $fillable = [
        'category_id',
        'color_id',
        'unit_id',
        'name',
        'product_code',
        'barcode',
        'sku',
        'price',            // Ini akan jadi Harga Jual
        'purchase_price',   // PERBAIKAN: Ini Harga Modal untuk semua barang
        'stock',
        'min_stock',
        'description',
        'image',
        // Bidang spesifik untuk Cat
        'color_name',
        'color_code',
        'paint_type',
        'volume',
        // Bidang spesifik untuk Keramik
        'size',
        'texture',
        'motif',
        'grade',
        'finish_type',
        // Bidang spesifik untuk Tekstil (Benang/Kain)
        'composition',
        'technical_spec',
        'gsm',
        'width',
        'brand',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    // Tambahkan accessor ini jika Anda ingin memastikan nilainya selalu numerik
    public function getPurchasePriceAttribute($value)
    {
        return $value ?? 0;
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PembelianItem::class);
    }

    public function warehouseStocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }
}