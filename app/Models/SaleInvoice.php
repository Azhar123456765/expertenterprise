<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    public function scopeGrouped($query){
        return $query->whereIn('sale_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('sale_invoices')
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
       function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', 'sales_officer');
    }
    function CashReceiveAccount()
    {
        return $this->hasOne(accounts::class, 'id', "cash_receive_account");
    }

}
