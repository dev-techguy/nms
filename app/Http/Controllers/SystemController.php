<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class SystemController extends Controller
{
    /**
     * returns the elapsed time
     * @param $time
     * @return string
     */
    public static function elapsedTime($time): string
    {
        return Carbon::parse($time)->diffForHumans();
    }
}
