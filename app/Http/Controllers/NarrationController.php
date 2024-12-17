<?php

namespace App\Http\Controllers;

use App\Models\Narration;
use Illuminate\Http\Request;

class NarrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $narrations = Narration::orderByDesc('id')->get();
        return view('narrations', compact('narrations'));
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
        $narration = new Narration;
        $narration->narration = $request->input('narration');
        $narration->save();
        return redirect()->route('narrations');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Narration  $narration
     * @return \Illuminate\Http\Response
     */
    public function show(Narration $narration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Narration  $narration
     * @return \Illuminate\Http\Response
     */
    public function edit(Narration $narration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Narration  $narration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $narration = Narration::find($id);
        $narration->narration = $request->input('narration');
        $narration->save();

        return redirect()->route('narrations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Narration  $narration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Narration $narration)
    {
        //
    }
}
