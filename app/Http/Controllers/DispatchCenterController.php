<?php

namespace App\Http\Controllers;

use App\Models\DispatchCenter;
use App\Models\EmergencyCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DispatchCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allData = DispatchCenter::all();
        return view('dispatch_centers.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = EmergencyCenter::all();
        return view('dispatch_centers.create', compact('data'));
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
            'contact' => 'required|unique:dispatch_centers',
        ]);

        //dd($request);
        $dispatch = new DispatchCenter();
        $dispatch->emergency_center_id = $request->emergency_center_id;
        $dispatch->contact = $request->contact;
        $dispatch->open_whole_day = $request->open_whole_day;
        $dispatch->open_late_night = $request->open_late_night;
        $dispatch->open_weekends = $request->open_weekends;
        $dispatch->open_public_holiday = $request->open_public_holiday;
        $dispatch->county = $request->county;
        $dispatch->sub_county = $request->sub_county;
        $dispatch->constituency = $request->constituency;
        $dispatch->ward = $request->ward;
        $dispatch->location = $request->location;
        $dispatch->latitude = $request->latitude;
        $dispatch->longitude = $request->longitude;
        $dispatch->save();
        Session()->flash('success', 'Created successfully');

        return redirect()->route('dispatch_centers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\DispatchCenter $dispatchCenter
     * @return Response
     */
    public function show(DispatchCenter $dispatchCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\DispatchCenter $dispatchCenter
     * @return Response
     */
    public function edit(DispatchCenter $dispatchCenter)
    {
        $editData = $dispatchCenter;
        $eccs = EmergencyCenter::all();

        return view('dispatch_centers.edit', compact('editData', 'eccs'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\DispatchCenter $dispatchCenter
     * @return Response
     */
    public function update(Request $request, DispatchCenter $dispatchCenter)
    {

        $dispatchCenter->emergency_center_id = $request->emergency_center_id;
        $dispatchCenter->contact = $request->contact;
        $dispatchCenter->open_whole_day = $request->open_whole_day;
        $dispatchCenter->open_late_night = $request->open_late_night;
        $dispatchCenter->open_weekends = $request->open_weekends;
        $dispatchCenter->open_public_holiday = $request->open_public_holiday;
        $dispatchCenter->county = $request->county;
        $dispatchCenter->sub_county = $request->sub_county;
        $dispatchCenter->constituency = $request->constituency;
        $dispatchCenter->ward = $request->ward;
        $dispatchCenter->location = $request->location;
        $dispatchCenter->latitude = $request->latitude;
        $dispatchCenter->longitude = $request->longitude;
        $dispatchCenter->save();
        Session()->flash('success', 'Updated successfully');

        return redirect()->route('dispatch_centers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\DispatchCenter $dispatchCenter
     * @return Response
     */
    public function destroy(DispatchCenter $dispatchCenter)
    {
        $dispatchCenter->delete();
        Session()->flash('success', 'Deleted successfully');
        return redirect()->route('dispatch_centers.index');
    }
}

