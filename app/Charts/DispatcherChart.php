<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Incident;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class DispatcherChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $days = [];

        $query = new Incident();

        // get the days in names like Monday,Tuesday and so on...
        for ($i = 0; $i < 7; $i++) {
            $days[] = Carbon::now()->subDays($i)->format('d');
        }

        $resolved = $query
            ->latest()
            ->select('updated_at')
            ->where('dispatcher_id', auth()->id())
            ->where("status", 'resolved')
            ->whereDate('updated_at', '>=', today()->subDays(6)->format('Y-m-d'))
            ->whereDate('updated_at', '<=', today()->format('Y-m-d'))
            ->get()
            ->groupBy(fn($val) => Carbon::parse($val->updated_at)->format('d'));

        $un_resolved = $query
            ->latest()
            ->select('updated_at')
            ->where('dispatcher_id', auth()->id())
            ->where("status", 'draft')
            ->whereDate('updated_at', '>=', today()->subDays(6)->format('Y-m-d'))
            ->whereDate('updated_at', '<=', today()->format('Y-m-d'))
            ->get()
            ->groupBy(fn($val) => Carbon::parse($val->updated_at)->format('d'));

        return Chartisan::build()
            ->labels(['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'])
            ->dataset('Resolved Cases', [
                isset($resolved[$days[6]]) ? count($resolved[$days[6]]) : 0,
                isset($resolved[$days[5]]) ? count($resolved[$days[5]]) : 0,
                isset($resolved[$days[4]]) ? count($resolved[$days[4]]) : 0,
                isset($resolved[$days[3]]) ? count($resolved[$days[3]]) : 0,
                isset($resolved[$days[2]]) ? count($resolved[$days[2]]) : 0,
                isset($resolved[$days[1]]) ? count($resolved[$days[1]]) : 0,
                isset($resolved[$days[0]]) ? count($resolved[$days[0]]) : 0
            ])
            ->dataset('Unsolved Cases', [
                isset($un_resolved[$days[6]]) ? count($un_resolved[$days[6]]) : 0,
                isset($un_resolved[$days[5]]) ? count($un_resolved[$days[5]]) : 0,
                isset($un_resolved[$days[4]]) ? count($un_resolved[$days[4]]) : 0,
                isset($un_resolved[$days[3]]) ? count($un_resolved[$days[3]]) : 0,
                isset($un_resolved[$days[2]]) ? count($un_resolved[$days[2]]) : 0,
                isset($un_resolved[$days[1]]) ? count($un_resolved[$days[1]]) : 0,
                isset($un_resolved[$days[0]]) ? count($un_resolved[$days[0]]) : 0
            ]);
    }
}
