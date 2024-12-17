<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zone extends Model
{
    protected $guarded = [];
    public $table = 'zone';
    function customer()
    {
        return $this->hasOne(buyer::class, 'city', 'zone_id');
    }
   
    function supplier()
    {
        return $this->hasOne(seller::class, 'city', 'zone_id');
    }
}
