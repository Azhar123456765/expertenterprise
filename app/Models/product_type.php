<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_type extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $table = 'product_type';
    public $id = 'id';
    function product()
    {
        return $this->hasOne(products::class, 'product_type', 'product_type_id');
    }
}

