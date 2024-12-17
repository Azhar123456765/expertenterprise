<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer extends Model
{
    use HasFactory;
    protected $table = 'buyer';
    protected $id = 'buyer_id';

    function zone()
    {
        return $this->hasOne(zone::class, 'zone_id', 'city');
    }

}
