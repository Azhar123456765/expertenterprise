<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\users;
use Illuminate\Http\Request;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = users::where('role', 'farm_user')->get();
        $farms = Farm::all();

        return view('farms', compact('users', 'farms'));
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
        $farm = new Farm;
        $farm->name = $request->input('name');
        $farm->user_id = $request->input('user');
        $farm->save();

        return redirect()->back()->with('message', 'Farm Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function show(Farm $farm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function edit(Farm $farm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm)
    {
        $farm = Farm::find($farm->id);
        $farm->name = $request->input('name');
        $farm->user_id = $request->input('user');
        $farm->save();

        return redirect()->back()->with('message', 'Farm Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farm $farm)
    {
        try {
            Farm::destroy($farm->id);
            return redirect()->back()->with('message', 'Farm Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('something_wrong', 'This Farm May Also In Other Module Or Something Went Wrong');

        }
    }
}
