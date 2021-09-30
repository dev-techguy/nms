<?php

namespace App\Http\Controllers;

use App\Models\DispatchCenter;
use App\Models\EmergencyCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmergencyCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allData = EmergencyCenter::all();
        return view('emergency_centers.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('emergency_centers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:emergency_centers',
        ]);
        $ecc = new EmergencyCenter();
        $ecc->name = $request->name;
        $ecc->save();
        Session()->flash('success', 'Created successfully');

        return redirect()->route('emergency_centers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\EmergencyCenter $emergencyCenter
     * @return Response
     */
    public function show($emergencyCenter)
    {
        $dispatch_centers = DispatchCenter::where('emergency_center_id', $emergencyCenter)->get();

        return view('emergency_centers.show', compact('dispatch_centers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EmergencyCenter $emergencyCenter
     * @return Response
     */
    public function edit(EmergencyCenter $emergencyCenter)
    {

        $editData = $emergencyCenter;
        return view('emergency_centers.edit', compact('editData'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\EmergencyCenter $emergencyCenter
     * @return Response
     */
    public function update(Request $request, EmergencyCenter $emergencyCenter)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $emergencyCenter->name = $request->name;
        $emergencyCenter->save();
        Session()->flash('success', 'Updated successfully');

        return redirect()->route('emergency_centers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EmergencyCenter $emergencyCenter
     * @return Response
     */
    public function destroy(EmergencyCenter $emergencyCenter)
    {
        $emergencyCenter->delete();
        Session()->flash('success', 'Deleted successfully');
        return redirect()->route('emergency_centers.index');

    }
}
