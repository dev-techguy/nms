<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Coordinates;
use App\Http\Helpers\Tracker;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;

    protected $coordinates;
    protected $tracker;

    public function __construct()
    {
        $this->coordinates = new Coordinates();
        $this->tracker = new Tracker();
    }

    public function listVehicles(Request $request)
    {
        //Get tracking data
        $vehicleList = [];
        $strCookie = session()->getId();
        //dd($strCookie);
        $timestamp = time();
        $trackerLogin = $this->tracker->login($timestamp, $strCookie);

        //dd($trackerLogin);
        if ($trackerLogin == 'ok') {
            $vehicleList = $this->tracker->vehicleListApi($timestamp, $strCookie);
            //dd($vehicleList);
        }

        if (empty($vehicleList)) {
            $success['status'] = $this->notFoundStatus;
            $success['message'] = "No vehicles online";
            return response()->json(['success' => $success], $this->notFoundStatus);
        }

        $success['status'] = $this->successStatus;
        $success['vehicleList'] = $vehicleList;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
