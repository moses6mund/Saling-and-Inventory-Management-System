<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected  $table ='companies';
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_fax'
    ];
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
