<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'product_name' => $row['product_name'],
            'description' => $row['description'],
            'brand' => $row['brand'],
            'price' => $row['price'],
            'cost_price' => $row['cost_price'],
            'quantity' => $row['quantity'],
            'alert_stock' => $row['alert_stock'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ]);
    }
}
