<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverVehicle;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;


    public function index(Request $request)
    {

        //$user_id = $request->user()->id;

        $profileData = [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone,
            'id_number' => $request->user()->id_number,
        ];


        $success['status'] = $this->successStatus;
        $success['profileData'] = $profileData;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getEMTProfile(Request $request)
    {

        $driver_id = $request->user()->id;

        $vehicle = DriverVehicle::where('driver_id', $driver_id)
            ->whereNull('check_out')
            ->first();

        $vehicle_id = $vehicle->vehicle_id;

        $user = User::role('EMT')
            ->whereHas('vehicles', function (Builder $query) use ($vehicle_id) {
                $query->where('vehicle_id', $vehicle_id)
                    ->whereNull('check_out');
            })->first();

        if (!$user) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'EMT not checked in';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        $profileData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'id_number' => $user->id_number,
        ];


        $success['status'] = $this->successStatus;
        $success['profileData'] = $profileData;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getNurseProfile(Request $request)
    {

        $driver_id = $request->user()->id;

        $vehicle = DriverVehicle::where('driver_id', $driver_id)
            ->whereNull('check_out')
            ->first();

        $vehicle_id = $vehicle->vehicle_id;

        $user = User::role('Nurse')
            ->whereHas('vehicles', function (Builder $query) use ($vehicle_id) {
                $query->where('vehicle_id', $vehicle_id)
                    ->whereNull('check_out');
            })->first();

        if (!$user) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'Nurse not checked in';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        $profileData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'id_number' => $user->id_number,
        ];


        $success['status'] = $this->successStatus;
        $success['profileData'] = $profileData;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function logs(Request $request)
    {
        $user_id = $request->user()->id;

        $activities = Activity::where('causer_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();

        $data = $activities->take(10);

        $logList = [];

        if ($data) {
            foreach ($data as $item) {
                $logList[] = [
                    'id' => $item->id,
                    'type' => $item->log_name,
                    'description' => $item->description,
                    'caused_by' => $item->causer->name,
                    'date' => $item->created_at->format('Y-m-d H:i:s'),
                ];
            }
        }


        $success['status'] = $this->successStatus;
        $success['logList'] = $logList;
        return response()->json(['success' => $success], $this->successStatus);
    }


}
