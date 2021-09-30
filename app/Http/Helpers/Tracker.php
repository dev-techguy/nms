<?php

namespace App\Http\Helpers;

use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;

class Tracker
{

    public function login($timestamp, $strCookie)
    {
        $iduser = 'nms';
        $idpass = '12345';
        $timezone = 'Nairobi';
        $lang = 'en';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://m.anbtek.com/login.ajax.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('iduser' => $iduser, 'idpass' => $idpass, 'timezone' => $timezone, 't' => $timestamp, 'lang' => $lang),
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=' . $strCookie
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function vehicleList($timestamp, $strCookie)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://m.anbtek.com/devlist.ajax.php?start=0&t=' . $timestamp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: PHPSESSID=' . $strCookie
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = [];

        if ($response) {
            $response_json = json_decode($response, true);
            //dd($response_json);
            if (!empty($response_json)) {
                if (isset($response_json['data']) && !empty($response_json['data'])) {
                    foreach ($response_json['data'] as $data_item) {
                        if (isset($data_item['item']) && !empty($data_item['item'])) {
                            foreach ($data_item['item'] as $single_item) {
                                if ($single_item['on'] == 1) {
                                    //Get Driver
                                    $regslug = regSlug($single_item['c']);
                                    $vehicle_id = '';
                                    $driver = [];
                                    $emt = [];
                                    $nurse = [];
                                    $vehicle = Vehicle::where('slug', $regslug)
                                        ->where('status', 'active')
                                        ->first();
                                    $available = false;
                                    if ($vehicle) {
                                        $available = true;
                                        /*$driver = DriverVehicle::where('vehicle_id', $vehicle->id)
                                            ->whereNull('check_out')
                                            ->first();*/
                                        $vehicle_id = $vehicle->id;
                                        $driver = User::role('Driver')
                                            ->whereHas('vehicles', function (Builder $query) use ($vehicle_id) {
                                                $query->where('vehicle_id', $vehicle_id)
                                                    ->whereNull('check_out');
                                            })->first();
                                        $emt = User::role('EMT')
                                            ->whereHas('vehicles', function (Builder $query) use ($vehicle_id) {
                                                $query->where('vehicle_id', $vehicle_id)
                                                    ->whereNull('check_out');
                                            })->first();
                                        $nurse = User::role('Nurse')
                                            ->whereHas('vehicles', function (Builder $query) use ($vehicle_id) {
                                                $query->where('vehicle_id', $vehicle_id)
                                                    ->whereNull('check_out');
                                            })->first();

                                        $pending_task = Task::where('vehicle_id', $vehicle_id)
                                            ->where('status', 'accepted')
                                            ->first();
                                        if ($pending_task)
                                            $available = false;
                                    }
                                    $driver_name = '';
                                    $driver_phone = '';
                                    $driver_id = '';
                                    if (!empty($driver)) {
                                        $driver_name = $driver->name;
                                        $driver_phone = isset($vehicle->phone) ? $vehicle->phone : $driver->phone;
                                        $driver_id = $driver->id;
                                    }
                                    $emt_name = '';
                                    $emt_id = '';
                                    if (!empty($emt)) {
                                        $emt_name = $emt->name;
                                        $emt_id = $emt->id;
                                    }
                                    $nurse_name = '';
                                    $nurse_id = '';
                                    if (!empty($nurse)) {
                                        $nurse_name = $nurse->name;
                                        $nurse_id = $nurse->id;
                                    }

                                    $data[] = ['id' => $single_item['n'],
                                        'vehicle_name' => $single_item['c'],
                                        'long' => ($single_item['x'] ? $single_item['x'] / 1000000 : 0),
                                        'lat' => ($single_item['y'] ? $single_item['y'] / 1000000 : 0),
                                        'driver_name' => $driver_name,
                                        'driver_id' => $driver_id,
                                        'emt_name' => $emt_name,
                                        'emt_id' => $emt_id,
                                        'nurse_name' => $nurse_name,
                                        'nurse_id' => $nurse_id,
                                        'driver_phone' => $driver_phone,
                                        'vehicle_id' => $vehicle_id,
                                        'available' => $available];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function vehicleListApi($timestamp, $strCookie)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://m.anbtek.com/devlist.ajax.php?start=0&t=' . $timestamp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: PHPSESSID=' . $strCookie
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = [];

        if ($response) {
            $response_json = json_decode($response, true);
            if (!empty($response_json)) {
                if (isset($response_json['data']) && !empty($response_json['data'])) {
                    foreach ($response_json['data'] as $data_item) {
                        if (isset($data_item['item']) && !empty($data_item['item'])) {
                            foreach ($data_item['item'] as $single_item) {
                                if ($single_item['on'] == 1) {
                                    $data[] = ['id' => $single_item['n'],
                                        'vehicle_name' => $single_item['c'],
                                        'long' => ($single_item['x'] ? $single_item['x'] / 1000000 : 0),
                                        'lat' => ($single_item['y'] ? $single_item['y'] / 1000000 : 0)];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

}
