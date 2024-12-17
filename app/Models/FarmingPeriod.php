<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingPeriod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    function farm()
    {
        return $this->hasOne(Farm::class, 'id', 'farm_id');
    }
    function user()
    {
        return $this->hasOne(users::class, 'user_id', 'assign_user_id');
    }
    public function dailyReports()
    {
        return $this->hasMany(FarmDailyReport::class, 'farm_id', 'farm_id');
    }
}
