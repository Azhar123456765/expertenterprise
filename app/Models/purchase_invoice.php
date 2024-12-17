<?php

namespace App\Models;

use App\Http\Controllers\product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'purchase_invoice';

    function supplier()
    {
        return $this->hasOne(seller::class, 'seller_id', 'company');
    }

    function product()
    {
        return $this->belongsTo(products::class, 'item');
    }
}
