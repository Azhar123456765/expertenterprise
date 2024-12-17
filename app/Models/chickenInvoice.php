<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chickenInvoice extends Model
{
    use HasFactory;
    public function scopeGrouped($query){
        return $query->whereIn('chicken_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('chicken_invoices')
                ->groupBy('unique_id');
        });
    }
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
