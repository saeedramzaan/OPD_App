<?php

namespace App\Http\Controllers;

use App\Models\time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $times = time::all();
        return view('viewTime', compact('times'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createTime');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $patient = new time();
        $patient->start_time = $request->start_time;
        $patient->end_time = $request->end_time;
        $patient->duration = $request->duration;
        $patient->day = $request->day;

        $patient->save();

        return redirect()->back()->with('success', 'Data successfully entered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $time = time::find($id);
        return view('updateTime', compact('time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $patient = time::find($id);
        $patient->start_time = $request->start_time;
        $patient->end_time = $request->end_time;
        $patient->duration = $request->duration;
        $patient->day = $request->day;

        $patient->save();

        return redirect('/time')->with('success', 'Data Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function delete($id)
    {
        $user = time::find($id);
        $user->delete();
        return redirect('/time')->with('success', 'Data Successfully Deleted');
    }
}
