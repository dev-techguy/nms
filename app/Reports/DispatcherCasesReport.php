<?php

namespace App\Reports;

use App\Models\Incident;
use koolreport\KoolReport;
use koolreport\laravel\Friendship;


class DispatcherCasesReport extends KoolReport
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
        //$user = Auth::user();
        $this->src("elo")->query(
            Incident::where('status', '!=', 'draft')
                ->orderBy('id', 'desc')
                ->take(10)
        )
            ->pipe($this->dataStore("incidents"));
    }
}
