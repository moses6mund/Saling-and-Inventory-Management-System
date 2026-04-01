<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select([
            'id',
            'product_name',
            'description',
            'brand',
            'price',
            'cost_price',
            'quantity',
            'alert_stock',
            'created_at',
            'updated_at'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'PRODUCT NAME',
            'DESCRIPTION',
            'BRAND',
            'SELLING PRICE',
            'BUYING PRICE',
            'QUANTITY',
            'STOCK STATUS',
            'CREATED TIME',
            'UPDATED TIME',
        ];
    }
}