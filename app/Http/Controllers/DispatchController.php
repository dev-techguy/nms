<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Coordinates;
use App\Http\Helpers\Tracker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Spatie\Geocoder\Facades\Geocoder;

class DispatchController extends Controller
{

    protected $helper;
    protected $tracker;

    public function __construct()
    {
        $this->helper = new Coordinates();
        $this->tracker = new Tracker();
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
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

        return view('dispatch.index', compact('vehicleList'));
    }

    public function listView(Request $request)
    {
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

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $address = $request->autocomplete;

        if (!$latitude || !$longitude || !$address) {
            $defaultLocation = Geocoder::getCoordinatesForAddress('Nairobi, Kenya');
            //dd($defaultLocation);
            $latitude = $defaultLocation['lat'];
            $longitude = $defaultLocation['lng'];
            $address = $defaultLocation['formatted_address'];
        }

        $vehicleData = [];

        if ($vehicleList) {
            foreach ($vehicleList as $item) {
                //Get distance
                $coordinate1 = new Coordinate($latitude, $longitude);
                $coordinate2 = new Coordinate($item['lat'], $item['long']);

                $distance_m = $coordinate1->getDistance($coordinate2, new Vincenty());

                $distance_km = $distance_m ? $distance_m / 1000 : 0;

                $vehicleData[] = ['data' => $item, 'distance' => $distance_km];
            }
        }

        usort($vehicleData, function ($a, $b) {
            return ($a['distance'] < $b['distance']) ? -1 : 1;
        });

        //dd($vehicleData);

        return view('dispatch.list', compact('vehicleData', 'latitude', 'longitude', 'address'));
    }
}
