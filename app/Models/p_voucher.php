<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class p_voucher extends Model
{
    use HasFactory;
    protected $table = 'payment_voucher';

    function supplier()
    {
        return $this->hasOne(buyer::class, 'buyer_id', 'company');
    }
    function customer()
    {
        return $this->hasOne(buyer::class, 'buyer_id', "company");
    }
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', "farm");
    }
    function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', "sales_officer");
    }
    function accounts()
    {
        return $this->hasOne(accounts::class, 'id', "cash_bank");
    }
}
