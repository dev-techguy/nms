<?php

namespace App\Reports;

use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use koolreport\KoolReport;
use koolreport\laravel\Friendship;


class WatcherCasesReport extends KoolReport
{
    use Friendship;

    function settings()
    {
        return array(
            "dataSources" => array(
                "elo" => array(
                    "class" => '\koolreport\laravel\Eloquent', // This is important
                )
            )
        );
    }

    function setup()
    {
        //Now you can use Eloquent inside query() like you normally do
        $user = Auth::user();
        $this->src("elo")->query(
            Incident::where('watcher_id', $user->id)
                ->orderBy('id', 'desc')
                ->take(10)
        )
            ->pipe($this->dataStore("incidents"));
    }
}
