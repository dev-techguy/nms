<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverVehicle;
use App\Models\DriverVehicleHistory;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;


    public function checkIn(Request $request)
    {

        $request->validate([
            'vehicleName' => 'required',
            'phone' => 'nullable',
        ]);

        //Format phone
        $formattedphone = formatPhone($request->phone);

        //get vehicle from DB
        $regslug = regSlug($request->vehicleName);

        $vehicle = Vehicle::where('slug', $regslug)->first();
        if (!$vehicle) {
            //Save vehicle
            $vehicle = Vehicle::create([
                'registration_number' => strtoupper($request->vehicleName),
                'slug' => $regslug,
            ]);
        }

        //Check if driver has another vehicle
        $user_id = $request->user()->id;

        $driver = DriverVehicle::where('driver_id', $user_id)->first();

        if ($driver && ($driver->vehicle_id != $vehicle->id)) {
            if (!$driver->check_out) {
                $success['status'] = $this->notAllowedStatus;
                $success['message'] = "You are checked in in another vehicle, " . $driver->vehicle->registration_number . ". Please checkout first";
                return response()->json(['success' => $success], $this->notAllowedStatus);
            }
        }

        //Check if vehicle has another driver
        if ($vehicle->driver && ($vehicle->driver->driver_id != $user_id)) {
            if (!$vehicle->driver->check_out) {
                $success['status'] = $this->notAllowedStatus;
                $success['message'] = "Vehicle has another driver checked in, "
                    . $vehicle->driver->driver->name . ". Please call 0800111111 for help";
                return response()->json(['success' => $success], $this->notAllowedStatus);
            }
        }

        //Check in the driver
        DriverVehicle::updateOrCreate(
            ['vehicle_id' => $vehicle->id],
            ['driver_id' => $user_id, 'phone' => $formattedphone,
                'check_in' => date('Y-m-d H:i:s'),
                'check_out' => NULL]
        );

        //Check in History
        $driverVehicleHistory = DriverVehicleHistory::where('vehicle_id', $vehicle->id)
            ->where('driver_id', $user_id)
            ->whereNull('check_out')
            ->first();

        if (!$driverVehicleHistory) {
            DriverVehicleHistory::create([
                'vehicle_id' => $vehicle->id,
                'driver_id' => $user_id,
                'phone' => $formattedphone,
                'check_in' => date('Y-m-d H:i:s')
            ]);
        }

        $success['status'] = $this->successStatus;
        $success['message'] = 'You have successfully checked in';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function checkOut(Request $request)
    {
        $user_id = $request->user()->id;

        $driver = DriverVehicle::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->first();

        if (!$driver) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "You are not checked in in any vehicle";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $driver->check_out = date('Y-m-d H:i:s');
        $driver->save();

        $driverHistory = DriverVehicleHistory::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->first();

        $driverHistory->check_out = date('Y-m-d H:i:s');
        $driverHistory->save();

        $success['status'] = $this->successStatus;
        $success['message'] = 'You have successfully checked out';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function saveFCM(Request $request)
    {

        $request->validate([
            'fcm_token' => 'required',
        ]);

        $fcm_token = $request->fcm_token;

        $user_id = $request->user()->id;

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User not found";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        $user->fcm_token = $fcm_token;
        $user->save();

        $success['status'] = $this->successStatus;
        $success['message'] = "FCM Token saved successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }
}
