<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function supplier(){

        return $this->belongsTo(Supplier::class);
    }

    public function orderDetails(){
    
        return $this->hasMany(OrderDetail::class);
    }
}
