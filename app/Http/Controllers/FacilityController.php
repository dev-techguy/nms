<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allData = Facility::all();
        return view('facilities.index', compact('allData'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('facilities.create');
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
            'title' => 'unique:facilities',
            'contact' => 'unique:facilities',
        ]);
        //dd($request);
        $facility = new Facility();
        $facility->title = $request->title;
        $facility->keph_level = $request->keph_level;
        $facility->type = $request->type;
        $facility->category = $request->category;
        $facility->ownership = $request->ownership;
        $facility->regulatory_body = $request->regulatory_body;
        $facility->contact = $request->contact;
        $facility->county = $request->county;
        $facility->constituency = $request->constituency;
        $facility->ward = $request->ward;
        $facility->location = $request->location;
        $facility->latitude = $request->latitude;
        $facility->longitude = $request->longitude;
        $facility->open_whole_day = $request->open_whole_day;
        $facility->open_late_night = $request->open_late_night;
        $facility->open_weekends = $request->open_weekends;
        $facility->open_public_holiday = $request->open_public_holiday;
        $facility->status = $request->status;
        $facility->approved = $request->approved;
        $facility->emergency_dpt = $request->emergency_dpt;
        $facility->primary_response = $request->primary_response;
        $facility->inter_facility_transfer = $request->inter_facility_transfer;
        $facility->trauma_care = $request->trauma_care;
        $facility->stroke_care = $request->stroke_care;
        $facility->heart_attacks = $request->heart_attacks;
        $facility->theater_stats = $request->theater_stats;
        $facility->x_ray_stats = $request->x_ray_stats;
        $facility->CT_stats = $request->CT_stats;
        $facility->ultra_sound_stats = $request->ultra_sound_stats;
        $facility->orthopedics_surgeons = $request->orthopedics_surgeons;
        $facility->neurosurgeons = $request->neurosurgeons;
        $facility->save();

        //Redirect to the facilities.index view and display message
        return redirect()->route('facilities.index')
            ->with('success',
                'Facility successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Facility $facility
     * @return Response
     */
    public function show(Facility $facility)
    {
        //dd($facility);
        $showData = $facility;
        return view('facilities.show', compact('showData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Facility $facility
     * @return Response
     */
    public function edit(Facility $facility)
    {
        $editData = $facility;
        return view('facilities.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Facility $facility
     * @return Response
     */
    public function update(Request $request, Facility $facility)
    {

        $facility->title = $request->title;
        $facility->keph_level = $request->keph_level;
        $facility->type = $request->type;
        $facility->category = $request->category;
        $facility->ownership = $request->ownership;
        $facility->regulatory_body = $request->regulatory_body;
        $facility->contact = $request->contact;
        $facility->county = $request->county;
        $facility->constituency = $request->constituency;
        $facility->ward = $request->ward;
        $facility->location = $request->location;
        $facility->latitude = $request->latitude;
        $facility->longitude = $request->longitude;
        $facility->open_whole_day = $request->open_whole_day;
        $facility->open_late_night = $request->open_late_night;
        $facility->open_weekends = $request->open_weekends;
        $facility->open_public_holiday = $request->open_public_holiday;
        $facility->status = $request->status;
        $facility->approved = $request->approved;
        $facility->emergency_dpt = $request->emergency_dpt;
        $facility->primary_response = $request->primary_response;
        $facility->inter_facility_transfer = $request->inter_facility_transfer;
        $facility->trauma_care = $request->trauma_care;
        $facility->stroke_care = $request->stroke_care;
        $facility->heart_attacks = $request->heart_attacks;
        $facility->theater_stats = $request->theater_stats;
        $facility->x_ray_stats = $request->x_ray_stats;
        $facility->CT_stats = $request->CT_stats;
        $facility->ultra_sound_stats = $request->ultra_sound_stats;
        $facility->orthopedics_surgeons = $request->orthopedics_surgeons;
        $facility->neurosurgeons = $request->neurosurgeons;
        $facility->save();

        return redirect()->route('facilities.index')
            ->with('success',
                'Facility successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Facility $facility
     * @return Response
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()->route('facilities.index')
            ->with('success',
                'Facility successfully deleted.');

    }
}

