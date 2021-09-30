<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverVehicle;
use App\Models\DriverVehicleHistory;
use App\Models\User;
use App\Models\Vehicle;
use DB;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/* use App\Http\Controllers\Users\EmailController;
  use App\Http\Helpers\Common;
  use App\Models\ActivityLog;
  use App\Models\EmailTemplate;
  use App\Models\Preference;
  use App\Models\Setting;
  use App\Models\VerifyUser;
  use App\Models\Wallet;
  use Carbon\Carbon; */

class LoginController extends Controller
{

    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;
    //protected $helper;
    public $email;

    public function __construct()
    {
        //$this->helper = new Common();
        //$this->email  = new EmailController();
    }

    public function getOTP(Request $request)
    {
        $phone = $request->phone;

        if (!$phone) {
            $success['status'] = $this->unauthorisedStatus;
            $success['messsage'] = 'User not authorized';
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }

        //Format phone
        $formattedphone = formatPhone($phone);

        $user = User::where('phone', $formattedphone)->first();
        if (!$user) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "Invalid phone";
            return response()->json(['success' => $success], $this->unauthorisedStatus);
        }
        //Generate otp
        $otp = new Otp();
        $getotp = $otp->generate($user->phone, 6, 15);

        if ((isset($getotp->token))) {
            $token = $getotp->token;
            //Send sms
            //$message = "Dear user, your One Time Password(OTP) is $token. Enter this to login";
            $sendsms = sendSms($user->phone, $token);

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

    public function login(Request $request)
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

        if (!$user->hasRole('Driver')) {
            $success['status'] = $this->unauthorisedStatus;
            $success['message'] = "User is not a driver";
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

        //Check In Driver

        //Check if driver has another vehicle or vehicle has another driver
        $user_id = $user->id;

        /*$driver = DriverVehicle::where('driver_id', $user_id)
                ->orWhere('vehicle_id', $vehicle->id)
                ->first();

        if ($driver) {


            if (!$driver->check_out) {
                $driver->check_out = date('Y-m-d H:i:s');
                $driver->save();
            }
        }*/

        DriverVehicle::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);

        DriverVehicleHistory::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);

        DriverVehicle::where('vehicle_id', $vehicle->id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);


        DriverVehicleHistory::where('vehicle_id', $vehicle->id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);


        //Check in the driver
        DriverVehicle::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'driver_id' => $user_id],
            ['phone' => $user->phone,
                'check_in' => date('Y-m-d H:i:s'),
                'check_out' => NULL]
        );

        //Check in History
        /*$driverVehicleHistory = DriverVehicleHistory::where('vehicle_id', $vehicle->id)
                ->where('driver_id', $user_id)
                ->whereNull('check_out')
                ->first();

        if(!$driverVehicleHistory){
            DriverVehicleHistory::create([
                'vehicle_id' => $vehicle->id,
                'driver_id' => $user_id,
                'phone' => $user->phone,
                'check_in' => date('Y-m-d H:i:s')
            ]);
        }*/
        DriverVehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'driver_id' => $user_id,
            'phone' => $user->phone,
            'check_in' => date('Y-m-d H:i:s')
        ]);


        $success['status'] = $this->successStatus;
        $success['token'] = $user->createToken($device_id)->plainTextToken;
        $success['vehicle'] = $vehicle->registration_number;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getPreferenceSettings()
    {
        $preference = Preference::where(['category' => 'preference'])->whereIn('field', ['thousand_separator', 'decimal_format_amount', 'money_format'])->get(['field', 'value'])->toArray();
        $preference = Common::key_value('field', 'value', $preference);
        $thousand_separator = $preference['thousand_separator'];
        $decimal_format_amount = $preference['decimal_format_amount'];
        $money_format = $preference['money_format'];
        return response()->json([
            'status' => $this->successStatus,
            'thousand_separator' => $thousand_separator,
            'decimal_format_amount' => $decimal_format_amount,
            'money_format' => $money_format,
        ]);
    }

    public function loginOld(Request $request)
    {
        //Login Vaia - starts
        $loginVia = Setting::where('name', 'login_via')->first(['value'])->value;
        if ((isset($loginVia) && $loginVia == 'phone_only')) {
            //phone only
            //to remove leading '0' (zero) - bangladeshi number
            $formattedRequest = ltrim($request->email, '0');
            $phnUser = User::where(['phone' => $formattedRequest])->orWhere(['formattedPhone' => $formattedRequest])->first(['email']);
            if (!$phnUser) {
                $success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Invalid email & credentials";
                return response()->json(['success' => $success], $this->unauthorisedStatus);
            }
            $request->email = $phnUser->email;
        } else if (isset($loginVia) && $loginVia == 'email_or_phone') {
            //phone or email
            if (strpos($request->email, '@') !== false) {
                $user = User::where(['email' => $request->email])->first(['email']);
                if (!$user) {
                    $success['status'] = $this->unauthorisedStatus;
                    $success['message'] = "Invalid email & credentials";
                    return response()->json(['success' => $success], $this->unauthorisedStatus);
                }
                $request->email = $user->email;
            } else {
                $formattedRequest = ltrim($request->email, '0'); //to remove leading '0' (zero) - bangladeshi number
                $phoneOrEmailUser = User::where(['phone' => $formattedRequest])->orWhere(['formattedPhone' => $formattedRequest])->first(['email']);
                if (!$phoneOrEmailUser) {
                    $success['status'] = $this->unauthorisedStatus;
                    $success['message'] = "Invalid email & credentials";
                    return response()->json(['success' => $success], $this->unauthorisedStatus);
                }
                $request->email = $phoneOrEmailUser->email;
            }
        } else {
            //email only
            $user = User::where(['email' => $request->email])->first(['email']);
            if (!$user) {
                $success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Invalid email & credentials";
                return response()->json(['success' => $success], $this->unauthorisedStatus);
            }
            $request->email = $user->email;
        }
        //Login Via - ends

        $checkUserVerificationStatus = $this->checkUserVerificationStatusApi($request->email);
        if ($checkUserVerificationStatus == true) {
            DB::commit();
            $success['status'] = $this->unverifiedUser;
            $success['message'] = 'We sent you an activation code. Check your email and click on the link to verify.';
            return response()->json(['response' => $success], $this->unverifiedUser);
        } else {
            //Auth attempt - starts
            if (Auth::attempt(['email' => $request->email, 'password' => request('password')])) {
                $user = Auth::user();
                $default_currency = Setting::where('name', 'default_currency')->first(['value']);
                $chkWallet = Wallet::where(['user_id' => $user->id, 'currency_id' => $default_currency->value])->first();
                try {
                    DB::beginTransaction();

                    if (empty($chkWallet)) {
                        $wallet = new Wallet();
                        $wallet->user_id = $user->id;
                        $wallet->currency_id = $default_currency->value;
                        $wallet->balance = 0.00;
                        $wallet->is_default = 'No';
                        $wallet->save();
                    }

                    $log = [];
                    $log['user_id'] = Auth::check() ? $user->id : null;
                    $log['type'] = 'User';
                    $log['ip_address'] = $request->ip();
                    $log['browser_agent'] = $request->header('user-agent');
                    $log['created_at'] = DB::raw('CURRENT_TIMESTAMP');
                    ActivityLog::create($log);

                    //user_detail - adding last_login_at and last_login_ip
                    $user->user_detail()->update([
                        'last_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => $request->getClientIp(),
                    ]);
                    DB::commit();

                    $success['user_id'] = $user->id;
                    $success['first_name'] = $user->first_name;
                    $success['last_name'] = $user->last_name;
                    $success['email'] = $user->email;
                    $success['formattedPhone'] = $user->formattedPhone;
                    $success['picture'] = $user->picture;

                    $fullName = $user->first_name . ' ' . $user->last_name;
                    $success['token'] = $user->createToken($fullName)->accessToken;

                    //Get Money Format from Preferences Table
                    // $success['thousand_separator']    = Preference::where(['category' => 'preference', 'field' => 'thousand_separator'])->first(['value'])->value;
                    // $success['decimal_format_amount'] = Preference::where(['category' => 'preference', 'field' => 'decimal_format_amount'])->first(['value'])->value;
                    // $success['money_format']          = Preference::where(['category' => 'preference', 'field' => 'money_format'])->first(['value'])->value;

                    $success['status'] = $this->successStatus;
                    return response()->json(['response' => $success], $this->successStatus);
                } catch (Exception $e) {
                    DB::rollBack();
                    $success['status'] = $this->unauthorisedStatus;
                    $success['message'] = $e->getMessage();
                    return response()->json(['response' => $success], $this->unauthorisedStatus);
                }
            } else {
                //d($request->all(),1);
                $success['status'] = $this->unauthorisedStatus;
                $success['message'] = "Invalid email & credentials";
                return response()->json(['response' => $success], $this->unauthorisedStatus);
            }
            //Auth attempt - ends
        }
    }

    //Check User Verification Status
    protected function checkUserVerificationStatusApi($userEmail)
    {
        $checkLoginDataOfUser = User::where(['email' => $userEmail])->first(['id', 'first_name', 'last_name', 'email']);
        if (checkVerificationMailStatus() == 'Enabled' && $checkLoginDataOfUser->user_detail->email_verification == 0) {
            $verifyUser = VerifyUser::where(['user_id' => $checkLoginDataOfUser->id])->first(['id']);
            try {
                DB::beginTransaction();
                if (empty($verifyUser)) {
                    $verifyUserNewRecord = new VerifyUser();
                    $verifyUserNewRecord->user_id = $checkLoginDataOfUser->id;
                    $verifyUserNewRecord->token = str_random(40);
                    $verifyUserNewRecord->save();
                }
                $englishUserVerificationEmailTempInfo = EmailTemplate::where(['temp_id' => 17, 'lang' => 'en', 'type' => 'email'])->select('subject', 'body')->first();
                $userVerificationEmailTempInfo = EmailTemplate::where([
                    'temp_id' => 17,
                    'language_id' => getDefaultLanguage(),
                    'type' => 'email',
                ])->select('subject', 'body')->first();

                if (!empty($userVerificationEmailTempInfo->subject) && !empty($userVerificationEmailTempInfo->body)) {
                    $userVerificationEmailTempInfo_sub = $userVerificationEmailTempInfo->subject;
                    $userVerificationEmailTempInfo_msg = str_replace('{user}', $checkLoginDataOfUser->first_name . ' ' . $checkLoginDataOfUser->last_name, $userVerificationEmailTempInfo->body);
                } else {
                    $userVerificationEmailTempInfo_sub = $englishUserVerificationEmailTempInfo->subject;
                    $userVerificationEmailTempInfo_msg = str_replace('{user}', $checkLoginDataOfUser->first_name . ' ' . $checkLoginDataOfUser->last_name, $englishUserVerificationEmailTempInfo->body);
                }
                $userVerificationEmailTempInfo_msg = str_replace('{email}', $checkLoginDataOfUser->email, $userVerificationEmailTempInfo_msg);
                $userVerificationEmailTempInfo_msg = str_replace('{verification_url}', url('user/verify', $checkLoginDataOfUser->verifyUser->token), $userVerificationEmailTempInfo_msg);
                $userVerificationEmailTempInfo_msg = str_replace('{soft_name}', getCompanyName(), $userVerificationEmailTempInfo_msg);

                if (checkAppMailEnvironment()) {
                    try {
                        $this->email->sendEmail($checkLoginDataOfUser->email, $userVerificationEmailTempInfo_sub, $userVerificationEmailTempInfo_msg);
                        return true;
                    } catch (Exception $e) {
                        DB::rollBack();
                        $success['status'] = $this->unauthorisedStatus;
                        $success['message'] = $e->getMessage();
                        return response()->json(['success' => $success], $this->unauthorisedStatus);
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                $success['status'] = $this->unauthorisedStatus;
                $success['message'] = $e->getMessage();
                return response()->json(['response' => $success], $this->unauthorisedStatus);
            }
        }
    }

    public function logout(Request $request)
    {
        /*$request->validate([
            'token' => 'required',
        ]);*/

        //Checkout
        $user_id = $request->user()->id;

        DriverVehicle::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);


        DriverVehicleHistory::where('driver_id', $user_id)
            ->whereNull('check_out')
            ->update(['check_out' => date('Y-m-d H:i:s')]);


        $request->user()->currentAccessToken()->delete();


        $response['status'] = $this->successStatus;
        $response['message'] = "You have successfully logged out!";
        return response()->json(['response' => $response], $this->successStatus);
    }

}
