<?php

namespace App\Http\Controllers;

use App\Models\Ambulance;
use App\Models\DispatchCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AmbulanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allData = Ambulance::all();
        return view('ambulances.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = DispatchCenter::all();
        return view('ambulances.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $this->validate($request, [
            'dispatch_center_id' => 'required',
            'basic_stats' => 'required',
            'advanced_stats' => 'required',
            'gps_enabled' => 'required',
            'EMTs_stats' => 'required',
            'driver_stats' => 'required',
            'shift_stats' => 'required',
            'staff_per_shift_stats' => 'required',
        ]);


        $ambulance = new Ambulance();
        $ambulance->dispatch_center_id = $request->dispatch_center_id;
        $ambulance->basic_stats = $request->basic_stats;
        $ambulance->advanced_stats = $request->advanced_stats;
        $ambulance->gps_enabled = $request->gps_enabled;
        $ambulance->EMTs_stats = $request->EMTs_stats;
        $ambulance->driver_stats = $request->driver_stats;
        $ambulance->shift_stats = $request->shift_stats;
        $ambulance->staff_per_shift_stats = $request->staff_per_shift_stats;
        $ambulance->save();
        Session()->flash('success', 'Created successfully');

        return redirect()->route('ambulances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ambulance $ambulance
     * @return Response
     */
    public function show(Ambulance $ambulance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ambulance $ambulance
     * @return Response
     */
    public function edit(Ambulance $ambulance)
    {
        $data = DispatchCenter::all();
        $editData = $ambulance;
        return view('ambulances.edit', compact('data', 'editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Ambulance $ambulance
     * @return Response
     */
    public function update(Request $request, Ambulance $ambulance)
    {
        $this->validate($request, [
            'dispatch_center_id' => 'required',
            'basic_stats' => 'required',
            'advanced_stats' => 'required',
            'gps_enabled' => 'required',
            'EMTs_stats' => 'required',
            'driver_stats' => 'required',
            'shift_stats' => 'required',
            'staff_per_shift_stats' => 'required',
        ]);


        $ambulance->dispatch_center_id = $request->dispatch_center_id;
        $ambulance->basic_stats = $request->basic_stats;
        $ambulance->advanced_stats = $request->advanced_stats;
        $ambulance->gps_enabled = $request->gps_enabled;
        $ambulance->EMTs_stats = $request->EMTs_stats;
        $ambulance->driver_stats = $request->driver_stats;
        $ambulance->shift_stats = $request->shift_stats;
        $ambulance->staff_per_shift_stats = $request->staff_per_shift_stats;
        $ambulance->save();
        Session()->flash('success', 'Update successfully');

        return redirect()->route('ambulances.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ambulance $ambulance
     * @return Response
     */
    public function destroy(Ambulance $ambulance)
    {
        $ambulance->delete();
        Session()->flash('success', 'Deleted successfully');
        return redirect()->route('ambulances.index');
    }

}
