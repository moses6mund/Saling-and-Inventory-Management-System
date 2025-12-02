<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'order_id',
        'paid_amount', 
        'balance',
        'transac_date',
        'transac_amount',
        'payment_method'
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    public function supplier() 
    {
        return $this->belongsTo(Supplier::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
