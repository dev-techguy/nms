<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Response;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Vehicle::orderBy('updated_at', 'desc')->groupBy('registration_number')->get();
        return view('vehicles.index', compact('data'));
    }
}
