<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ItemsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Resolve Category (Improved)
        $categoryName = trim($row['kategori'] ?? '');
        $category = Category::where('name', 'like', $categoryName)->first();
        
        // Resolve Unit (Improved)
        $unitName = trim($row['satuan'] ?? '');
        $unit = Unit::where('name', 'like', $unitName)
                    ->orWhere('short_name', 'like', $unitName)
                    ->first();

        return Item::updateOrCreate(
            ['sku' => trim($row['sku'])],
            [
                'name'           => $row['nama_barang'],
                'product_code'   => $row['kode_produk'] ?? trim($row['sku']),
                'category_id'    => $category->id ?? null,
                'unit_id'        => $unit->id ?? null,
                'purchase_price' => (float)($row['harga_beli'] ?? 0),
                'price'          => (float)($row['harga_jual'] ?? 0),
                'stock'          => (float)($row['stok'] ?? 0),
                'min_stock'      => (float)($row['stok_minimum'] ?? 0),
                'description'    => $row['deskripsi'] ?? null,
                'barcode'        => $row['barcode'] ?? null,
                'composition'    => $row['komposisi'] ?? null,
                'technical_spec' => $row['spec_teknis'] ?? null,
                'gsm'            => $row['gsm'] ?? null,
                'width'          => $row['lebar'] ?? null,
                'brand'          => $row['brand'] ?? null,
                'color_name'     => $row['warna'] ?? null,
                'color_code'     => $row['kode_warna'] ?? null,
                'paint_type'     => $row['tipe_cat'] ?? null,
                'volume'         => $row['volume'] ?? null,
                'size'           => $row['size'] ?? null,
                'texture'        => $row['texture'] ?? null,
                'motif'          => $row['motif'] ?? null,
                'grade'          => $row['grade'] ?? null,
                'finish_type'    => $row['tipe_finish'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string',
            'sku'         => 'required|string',
            'kategori'    => 'required|string',
            'satuan'      => 'required|string',
        ];
    }
}
