<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    use HasFactory;
    public $table = 'accounts';
    public $table_id = 'id';

    public function sub_head()
    {
        return $this->belongsTo(SubHeadAccount::class, 'account_category', 'id'); // 'account_category' is the foreign key in 'accounts', 'id' is the primary key in 'sub_heads'
    }
}
