<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenericExport implements FromCollection, WithHeadings
{
    protected $model;
    protected $columns;
    protected $headings;

    public function __construct($model, array $columns, array $headings)
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->headings = $headings;
    }

    public function collection()
    {
        return $this->model::select($this->columns)->get();
    }

    public function headings(): array
    {
        return $this->headings;
    }
}