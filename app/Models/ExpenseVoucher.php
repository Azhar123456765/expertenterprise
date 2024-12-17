<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseVoucher extends Model
{
    use HasFactory;
    function supplier()
    {
        return $this->hasOne(seller::class, 'seller_id', 'seller');
    }
    function customer()
    {
        return $this->hasOne(buyer::class, 'buyer_id', "buyer");
    }

    function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', "sales_officer");
    }
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', "farm");
    }
    function asset_accounts()
    {
        return $this->hasOne(accounts::class, 'id', "buyer");
    }
    function accounts()
    {
        return $this->hasOne(accounts::class, 'id', "cash_bank");
    }
}
