<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptVoucher extends Model
{
    use HasFactory;
    protected $table = 'receipt_vouchers';

    function Invoice()
    {
        return $this->belongsTo(SaleInvoice::class, "invoice_no", 'unique_id');
    }
    function supplier()
    {
        return $this->hasOne(seller::class, 'seller_id', 'company');
    }
    function customer()
    {
        return $this->hasOne(buyer::class, 'buyer_id', "company");
    }
    function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', "sales_officer");
    }

    function accounts()
    {
        return $this->hasOne(accounts::class, 'id', "cash_bank");
    }
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', "farm");
    }
}
