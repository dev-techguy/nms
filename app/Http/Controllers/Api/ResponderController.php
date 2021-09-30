<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverVehicle;
use App\Models\DriverVehicleHistory;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResponderController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;


    public function checkInEMTNurse(Request $request)
    {

        $request->validate([
            'id_number' => 'required',
            'password' => 'required',
            'device_id' => 'required',
        ]);

        $id_number = $request->id_number;
        $password = $request->password;
        $device_id = $request->device_id;


        $user = User::where('id_number', $id_number)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User not found";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        if (!$user->hasRole(['EMT', 'Nurse'])) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User is not an EMT or Nurse";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        //Get vehicle
        $vehicle = Vehicle::where('device_id', $device_id)
            ->where('status', 'active')
            ->first();

        if (!$vehicle) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Device details not found";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        //Get driver
        $driver_id = $request->user()->id;

        $driver = DriverVehicle::where('driver_id', $driver_id)
            ->whereNull('check_out')
            ->first();

        if (!$driver) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Driver not logged in";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        //Check In EMT

        //Check if EMT has another vehicle
        $user_id = $user->id;

        DriverVehicle::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);

        DriverVehicleHistory::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);


        //Check in the emt
        DriverVehicle::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'driver_id' => $user_id],
            ['phone' => $user->phone,
                'check_in' => date('Y-m-d H:i:s'),
                'check_out' => NULL]
        );

        //Check in History
        DriverVehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'driver_id' => $user_id,
            'phone' => $user->phone,
            'check_in' => date('Y-m-d H:i:s')
        ]);

        $success['status'] = $this->successStatus;
        $success['message'] = 'You have successfully checked in';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function checkOutEMTNurse(Request $request)
    {
        $request->validate([
            'id_number' => 'required',
            'password' => 'required',
        ]);

        $id_number = $request->id_number;
        $password = $request->password;


        $user = User::where('id_number', $id_number)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User not found";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        if (!$user->hasRole(['EMT', 'Nurse'])) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User is not an EMT or Nurse";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        $user_id = $user->id;

        DriverVehicle::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);

        DriverVehicleHistory::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);

        $success['status'] = $this->successStatus;
        $success['message'] = 'You have successfully checked out';
        return response()->json(['success' => $success], $this->successStatus);
    }


}
