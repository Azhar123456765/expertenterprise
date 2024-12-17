<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalVoucher extends Model
{
    use HasFactory;
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', "farm");
    }
    function officer()
    {
        return $this->hasOne(sales_officer::class, 'sales_officer_id', "sales_officer");
    }
    function fromAccount()
    {
        return $this->hasOne(accounts::class, 'id', "from_account");
    }
    function toAccount()
    {
        return $this->hasOne(accounts::class, 'id', "to_account");
    }
    // public function getAmountAttribute($value)
    // {
    //     return number_format($value, 2);
    // }
}
