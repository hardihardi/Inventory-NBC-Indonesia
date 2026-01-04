<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class YarnItemsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $category;

    public function __construct()
    {
        $this->category = Category::where('type', 'yarn')->first();
        if (!$this->category) {
            throw new \Exception("Kategori dengan tipe 'yarn' tidak ditemukan.");
        }
    }

    public function model(array $row)
    {
        return new Item([
            'category_id'    => $this->category->id,
            'name'           => $row['nama'],
            'composition'    => $row['komposisi'] ?? null,
            'technical_spec' => $row['spec'] ?? null,
            'brand'          => $row['brand'] ?? null,
            'color_name'     => $row['warna'] ?? null,
            'color_code'     => $row['kode_warna'] ?? null,
            'purchase_price' => $row['harga_modal'] ?? 0,
            'price'          => $row['harga_jual'] ?? 0,
            'stock'          => $row['stok'] ?? 0,
            'unit'           => $row['satuan'] ?? 'kg',
            'description'    => $row['deskripsi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama'        => 'required|string|max:255',
            'komposisi'   => 'nullable|string|max:255',
            'spec'        => 'nullable|string|max:255',
            'brand'       => 'nullable|string|max:255',
            'warna'       => 'nullable|string|max:255',
            'kode_warna'  => 'nullable|string|max:50',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|numeric|min:0',
            'satuan'      => 'required|string|max:50',
        ];
    }
}
