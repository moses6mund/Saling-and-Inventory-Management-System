<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenericImport implements ToModel, WithHeadingRow
{
    

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function model($row)
    {
        return new $this->model($row);
    }
}