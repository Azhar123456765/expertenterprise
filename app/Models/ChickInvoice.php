<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChickInvoice extends Model
{
    use HasFactory;
    function product()
    {
        return $this->hasOne(products::class, 'product_id', 'item');
    }
    function customer()
    {
        return $this->hasOne(buyer::class, 'buyer_id', 'buyer');
    }
    function supplier()
    {
        return $this->hasOne(buyer::class, 'buyer_id', 'seller');
    }
       function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', 'sales_officer');
    }
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', "farm");
    }
}
