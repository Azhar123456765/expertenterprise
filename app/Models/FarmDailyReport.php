<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmDailyReport extends Model
{
    use HasFactory;
    protected $table = 'farm_daily_reports';
    function user()
    {
        return $this->hasOne(users::class, 'user_id', 'user_id');
    }
    function farms()
    {
        return $this->hasOne(Farm::class, 'id', 'farm');
    }
    public function farmingPeriod()
    {
        return $this->belongsTo(FarmingPeriod::class, 'farm', 'id');
    }
}
