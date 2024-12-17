<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\users;

class isuserOnline
{
    public function handle($request, Closure $next)
    {
        // if (session()->has("user_id")) {
        //     $userId = session()->get('user_id')['user_id'];
        //     $expireAt = Carbon::now()->addMinutes(1);

        //     Cache::put("user_id", $userId, $expireAt);
        //     Cache::put("last_seen", $expireAt, $expireAt);

        //     users::where('user_id', $userId)->update([
        //         'last_seen' => $expireAt
        //     ]);
        // } else {
        //     // Update the last_seen field to null for users who are not present in the session
        //     $id = cache::get('user_id');
        //     $last_seen = cache::get('last_seen');

        //     users::where('user_id', $id)->where('last_seen', $last_seen)->whereNotNull('last_seen')->update([
        //         'last_seen' => null
        //     ]);
        //     users::whereNotNull('last_seen')->update([
        //         'last_seen' => null
        //     ]);

        //     Cache::forget('user_id');
        //     Cache::forget('last_seen');
        // }

        return $next($request);
    }
}
