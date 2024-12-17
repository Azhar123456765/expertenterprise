<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products'; // Specify the table name

    protected $primaryKey = 'product_id'; // Specify the custom primary key field name
    function companies()
    {
        return $this->hasOne(product_company::class, 'product_company_id', "company");
    }
    function categories()
    {
        return $this->hasOne(product_category::class, 'product_category_id', "category");
    }
    function types()
    {
        return $this->hasOne(product_type::class, 'product_type_id', "product_type");
    }
}
