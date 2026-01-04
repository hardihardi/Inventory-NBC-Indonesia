<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'category',
    ];

    /**
     * Get the list of predefined customer categories.
     */
    public static function getCategories()
    {
        return [
            'Factory'        => 'Pabrik / Garment (Factory)',
            'Distributor'    => 'Distributor / Retailer',
            'Brand'          => 'Brand Fashion',
            'Small Business' => 'Konveksi / UMKM',
            'Exporter'       => 'Eksportir (Exporter)',
            'Butik'          => 'Butik (Boutique)',
            'Designer'       => 'Desainer (Designer)',
            'Other'          => 'Lainnya',
        ];
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
