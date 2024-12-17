<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales_officer extends Model
{
    use HasFactory;
    protected $table = 'sales_officer';
    protected $primaryKey = 'buyer_id'; // Specify the custom primary key field name

}
