<?php

namespace App\Http\Controllers;

use App\Models\FarmDailyReport;
use App\Models\FarmingPeriod;
use App\Models\Farm;
use App\Models\users;
use Carbon\Carbon;

use Illuminate\Http\Request;

class FarmingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = users::where('role', 'farm_user')->get();
        $farming_pr = FarmingPeriod::all();

        return view('farming_periods', compact('users', 'farming_pr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $farm = FarmingPeriod::create($request->all());
        // dd($request->all());
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

        $daysCount = $startDate->diffInDays($endDate) + 1;

        for ($i = 0; $i < $daysCount; $i++) {
            $report = new FarmDailyReport();
            $report->farming_period = $farm->id;
            $report->hen_deaths = 0;
            $report->feed_consumed = 0;
            $report->water_consumed = 0;
            $report->user_id = $request->input('assign_user_id');
            $report->date = $startDate->toDateString();

            $report->farm = $request->input('farm_id');
            $report->save();

            // Move to the next day
            $startDate->addDay();
        }

        return redirect()->back()->with('message', 'Farming Perioad Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FarmingPeriod  $farmingPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(FarmingPeriod $farmingPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FarmingPeriod  $farmingPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(FarmingPeriod $farmingPeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FarmingPeriod  $farmingPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FarmingPeriod $farmingPeriod)
    {
        $FarmingPeriod = FarmingPeriod::find($farmingPeriod->id);
        $FarmingPeriod->update($request->all());
        FarmDailyReport::where('farming_period', $farmingPeriod->id)->where('status', 0)->delete();
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

        $daysCount = $startDate->diffInDays($endDate) + 1;


        for ($i = 0; $i < $daysCount; $i++) {
            $check = FarmDailyReport::where('user_id', $request->input('assign_user_id'))
                ->where('farm', $request->input('farm_id'))
                ->where('date', $startDate->toDateString())
                ->first();

            if ($check) {
                $startDate->addDay();
            } elseif (!$check) {
                $report = new FarmDailyReport();
                $report->farming_period = $farmingPeriod->id;
                $report->hen_deaths = 0;
                $report->feed_consumed = 0;
                $report->water_consumed = 0;
                $report->user_id = $request->input('assign_user_id');
                $report->date = $startDate->toDateString();

                $report->farm = $request->input('farm_id');
                $report->save();

                $startDate->addDay();
            }
        }
        return redirect()->back()->with('message', 'Farming Perioad Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FarmingPeriod  $farmingPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(FarmingPeriod $farmingPeriod)
    {
        try {
            FarmingPeriod::destroy($farmingPeriod->id);
            return redirect()->back()->with('message', 'Farming Period Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('something_wrong', 'This Farm May Also In Other Module Or Something Went Wrong');

        }
    }
}
