<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $table = 'product_category';
    public $id = 'id';
    function product()
    {
        return $this->hasOne(products::class, 'category', 'product_category_id');
    }
}
