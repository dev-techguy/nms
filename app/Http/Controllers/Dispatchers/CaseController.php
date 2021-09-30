<?php

namespace App\Http\Controllers\Dispatchers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Coordinates;
use App\Http\Helpers\Tracker;
use App\Models\Facility;
use App\Models\Incident;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Spatie\Activitylog\Models\Activity;
use Spatie\Geocoder\Facades\Geocoder;

class CaseController extends Controller
{

    protected $helper;
    protected $tracker;

    public function __construct()
    {
        $this->helper = new Coordinates();
        $this->tracker = new Tracker();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $data = Incident::where('dispatcher_id', $user_id)->orderBy('id', 'desc')->get();
        return view('dispatchers.cases.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function allCases(Request $request)
    {
        $data = Incident::where('status', '!=', 'draft')->orderBy('id', 'desc')->get();
        return view('dispatchers.cases.allcases', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function realtime(Request $request)
    {
        return view('dispatchers.cases.realtime');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function realtimeTable(Request $request)
    {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        $data = Incident::whereBetween("updated_at", [$startDate, $endDate])->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'html' => view('dispatchers.cases.realtime-table', compact('data'))->render()
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function show(Incident $case)
    {

        return view('dispatchers.cases.show', compact('case'));
    }

    /**
     * Manage
     *
     * @param int $incident
     * @return Response
     */
    public function manage(Request $request, Incident $case)
    {
        $user_id = $request->user()->id;

        //Check if having a pending case
        $pending_cases = Incident::where('dispatcher_id', $user_id)
            ->where('status', 'dispatch_handling')
            ->count();

        if ($pending_cases) {
            return redirect()->route('cases.index')
                ->with('error',
                    'You still have a dispatch pending');
        }

        $case->dispatcher_id = $user_id;
        $case->status = 'dispatch_handling';
        $case->save();

        //Log Activity
        activity('case')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Assigned Dispatcher');

        return redirect()->route('cases.index')
            ->with('success',
                'Case taken up successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function details(Incident $case)
    {

        return view('dispatchers.single.details', compact('case'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function hospitalLevel(Incident $case)
    {
        $facilities = Facility::groupBy('keph_level')->orderBy('keph_level', 'asc')->get();

        return view('dispatchers.single.hospital-level', compact('case', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $case
     * @return Response
     */
    public function storeHospitalLevel(Request $request, Incident $case)
    {
        //Validate fields
        $this->validate($request, [
            'hospital_level' => 'required',
            'pre_hospital_management' => 'required',
        ]);

        $input = $request->only(['hospital_level', 'pre_hospital_management']);

        $case->fill($input)->save();

        //Log Activity
        activity('case')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Hospital Level Selected');


        //Redirect
        return redirect()->route('cases.dispatch.hospital', $case)
            ->with('success',
                'Hospital Level successfully updated.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function hospital(Incident $case)
    {

        /*$hospital_level = $case->hospital_level;

        if (!$hospital_level) {
            return redirect()->route('cases.dispatch.hospital-level', $case)
                ->with('error',
                 'Please select the Hospital Level');
        }*/

        //$facilities= Facility::where('keph_level', $hospital_level)->orderBy('title', 'asc')->get();
        $allFacilities = Facility::orderBy('title', 'asc')->get();

        //dd(Geocoder::getCoordinatesForAddress('Agha Khan University Hospital, 3rd Avenue  parklands'));

        $incident_lat = $case->location_lat;
        $incident_long = $case->location_long;

        if (!$incident_lat || !$incident_long) {
            $caseAddress = $case->location;
            $caseLocation = Geocoder::getCoordinatesForAddress($caseAddress);

            if ($caseLocation['lat'] && $caseLocation['lng']) {
                $incident_lat = $caseLocation['lat'];
                $incident_long = $caseLocation['lng'];

                $case->location_lat = $incident_lat;
                $case->location_long = $incident_long;

                $case->save();
            }


        }

        $allFacilities->map(function ($item) use ($incident_lat, $incident_long) {
            $facility_lat = $item->latitude;
            $facility_long = $item->longitude;

            if (!$facility_lat || !$facility_long) {
                $address = $item->title . ', ' . $item->location;
                $defaultLocation = Geocoder::getCoordinatesForAddress($address);
                /*if(!$defaultLocation['lat'] || !$defaultLocation['lng']){
                    $defaultLocation = Geocoder::getCoordinatesForAddress('Nairobi, Kenya');
                }*/

                if ($defaultLocation['lat'] && $defaultLocation['lng']) {
                    $facility_lat = $defaultLocation['lat'];
                    $facility_long = $defaultLocation['lng'];

                    $item->latitude = $facility_lat;
                    $item->longitude = $facility_long;

                    $item->save();
                }

            }

            //Get distance
            $item['distance'] = 0;

            if ($facility_lat && $facility_long) {
                $coordinate1 = new Coordinate($incident_lat, $incident_long);
                $coordinate2 = new Coordinate($facility_lat, $facility_long);

                $distance_m = $coordinate1->getDistance($coordinate2, new Vincenty());

                $distance_km = $distance_m ? round($distance_m / 1000, 2) : 0;

                $item['distance'] = $distance_km;
            }
            return $item;
        });

        $facilities = $allFacilities->sortBy('distance');

        $hospital_levels = Facility::groupBy('keph_level')->orderBy('keph_level', 'asc')->get();

        return view('dispatchers.single.hospital', compact('case', 'facilities', 'hospital_levels'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $case
     * @return Response
     */
    public function storeHospital(Request $request, Incident $case)
    {
        //Validate fields
        $this->validate($request, [
            'facility_id' => 'required',
            'hospital_level' => 'required',
            'pre_hospital_management' => 'required',
        ]);

        $input = $request->only(['facility_id', 'pre_hospital_management']);

        $case->fill($input)->save();

        $case->hospital_level = $case->facility->keph_level;
        $case->save();

        //Log Activity
        activity('case')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Hospital Selected');


        //Redirect
        return redirect()->route('cases.dispatch.responders', $case)
            ->with('success',
                'Hospital successfully updated.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function responders(Incident $case)
    {

        $facility_id = $case->facility_id;

        if (!$facility_id) {
            return redirect()->route('cases.dispatch.hospital', $case)
                ->with('error',
                    'Please select the Hospital');
        }

        //Get tracking data
        $vehicleList = [];
        $strCookie = session()->getId();
        //dd($strCookie);
        $timestamp = time();
        $trackerLogin = $this->tracker->login($timestamp, $strCookie);

        //dd($trackerLogin);
        if ($trackerLogin == 'ok') {
            $vehicleList = $this->tracker->vehicleList($timestamp, $strCookie);
            //dd($vehicleList);
        }


        return view('dispatchers.single.responders', compact('case', 'vehicleList'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function tasks(Incident $case)
    {

        $facility_id = $case->facility_id;

        if (!$facility_id) {
            return redirect()->route('cases.dispatch.hospital', $case)
                ->with('error',
                    'Please select the Hospital');
        }

        /*if ($case->status != 'responders_handling') {
            return redirect()->route('cases.dispatch.responders', $case)
                ->with('error',
                 'Please assign task to a responder');
        }*/


        return view('dispatchers.single.tasks', compact('case'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $task
     * @return Response
     */
    public function taskShow(Incident $case, Task $task)
    {
        $activities = Activity::where('subject_id', $task->id)
            ->where('log_name', 'task')
            ->orderBy('id', 'desc')
            ->get();

        return view('dispatchers.tasks.show', compact('case', 'task', 'activities'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function report(Incident $case)
    {

        return view('dispatchers.single.report', compact('case'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $case
     * @return Response
     */
    public function storeReport(Request $request, Incident $case)
    {
        //Validate fields
        $this->validate($request, [
            'dispatcher_challenges' => 'required',
            'dispatcher_comments' => 'required',
        ]);

        $input = $request->only(['dispatcher_challenges', 'dispatcher_comments']);

        $case->fill($input)->save();

        //Log Activity
        activity('case')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Report Filed');


        //Redirect
        return redirect()->route('cases.dispatch.report', $case)
            ->with('success',
                'Report successfully filed.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function AlternateHospital(Incident $case)
    {
        return view('dispatchers.single.alternate-hospital', compact('case'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $case
     * @return Response
     */
    public function storeAlternateHospital(Request $request, Incident $case)
    {
        //Validate fields
        $this->validate($request, [
            'alternative_health_facility' => 'required',
        ]);

        $input = $request->only(['alternative_health_facility']);

        $case->fill($input)->save();

        //Log Activity
        activity('case')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Alternative Hospital Selected');


        //Redirect
        return redirect()->route('cases.dispatch.alternate-hospital', $case)
            ->with('success',
                'Alternative Hospital successfully updated.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $case
     * @return Response
     */
    public function resolveCase(Incident $case)
    {

        return view('dispatchers.cases.resolve', compact('case'));
    }


    /**
     * Resolve
     *
     * @param int $incident
     * @return Response
     */
    public function resolve(Request $request, Incident $case)
    {

        //Validate fields
        $this->validate($request, [
            'dispatcher_comments' => 'required',
        ]);

        $case->dispatcher_comments = $request->dispatcher_comments;
        $case->status = 'resolved';
        $case->save();

        //Log Activity
        activity('incident')
            ->performedOn($case)
            ->causedBy($request->user())
            ->log('Case Resolved');

        return redirect()->route('cases.index')
            ->with('success',
                'Case Resolved');
    }


}
