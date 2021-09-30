<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;


    public function register(Request $request)
    {
        $phone = $request->phone;
        $registration_number = $request->registration_number;
        $device_id = $request->device_id;

        if (!$phone) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'Missing phone number';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        if (!$registration_number) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'Missing vehicle registration number';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        if (!$device_id) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'Missing Device ID';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        //Format phone
        $formattedphone = formatPhone($phone);


        //Check if vehicle is already setup
        $regslug = regSlug($registration_number);

        $vehicle = Vehicle::where('slug', $regslug)
            ->where('status', 'active')
            ->first();

        if ($vehicle) {
            if (($vehicle->phone == $formattedphone) && ($vehicle->device_id == $device_id)) {
                /*$success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Device already registered";
                return response()->json(['success' => $success], $this->unauthorisedStatus);*/
            } else {

                //Deactivate the vehicle
                $vehicle->status = 'inactive';
                $vehicle->save();
            }
        }

        $vehiclePhone = Vehicle::where('phone', $formattedphone)
            ->where('status', 'active')
            ->first();

        if ($vehiclePhone) {
            if (($vehiclePhone->slug == $regslug) && ($vehiclePhone->device_id == $device_id)) {
                /*$success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Device already registered";
                return response()->json(['success' => $success], $this->unauthorisedStatus);*/
            } else {

                //Deactivate the vehicle
                $vehiclePhone->status = 'inactive';
                $vehiclePhone->save();
            }
        }

        $vehicleDevice = Vehicle::where('device_id', $device_id)
            ->where('status', 'active')
            ->first();

        if ($vehicleDevice) {
            if (($vehicleDevice->slug == $regslug) && ($vehicleDevice->phone == $formattedphone)) {
                /*$success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Device already registered";
                return response()->json(['success' => $success], $this->unauthorisedStatus);*/
            } else {

                //Deactivate the vehicle
                $vehicleDevice->status = 'inactive';
                $vehicleDevice->save();
            }
        }

        //Save vehicle
        /*$vehicleNew = Vehicle::create([
            'registration_number' => strtoupper($registration_number),
            'slug' => $regslug,
            'phone' => $formattedphone,
            'device_id' => $device_id,
            'status' => 'validation',
        ]);*/

        $vehicleNew = Vehicle::updateOrCreate(
            ['slug' => $regslug, 'phone' => $formattedphone, 'device_id' => $device_id],
            ['registration_number' => strtoupper($registration_number),
                'status' => 'validation']
        );


        //Generate otp
        $otp = new Otp();
        $getotp = $otp->generate($vehicleNew->phone, 6, 15);

        if ((isset($getotp->token))) {
            $token = $getotp->token;
            //Send sms
            //$message = "Dear user, your One Time Password(OTP) is $token. Enter this to login";
            $sendsms = sendSms($vehicleNew->phone, $token);

            Log::info($token);

            if ($sendsms) {
                $success['status'] = $this->successStatus;
                $success['message'] = "OTP sent via sms";
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = $this->unauthorisedStatus;
                $success['message'] = "OTP not sent via sms";
                return response()->json(['success' => $success], $this->unauthorisedStatus);
            }
        } else {

            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "OTP not generated";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }
    }

    public function validateOTP(Request $request)
    {

        $request->validate([
            'otp' => 'required',
            'device_id' => 'required',
        ]);

        $token = $request->otp;
        $device_id = $request->device_id;

        //Get vehicle
        $vehicle = Vehicle::where('device_id', $device_id)
            ->where('status', 'validation')
            ->first();

        if (!$vehicle) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Device Setup details not found";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        //Validate OTP
        $otp = new Otp();
        $validateotp = $otp->validate($vehicle->phone, $token);

        if (!$validateotp->status) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = $validateotp->message;
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        //Activate the vehicle
        $vehicle->status = 'active';
        $vehicle->save();


        $success['status'] = $this->successStatus;
        $success['message'] = "Device setup successful";
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function verify(Request $request)
    {

        $device_id = $request->device_id;

        if (!$device_id) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Missing Device ID";
            return response()->json(['success' => $success], $this->notAllowedStatus);
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

        $success['status'] = $this->successStatus;
        $success['message'] = "Device is setup";
        $success['vehicle'] = $vehicle->registration_number;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
