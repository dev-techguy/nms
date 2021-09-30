<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Incident;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class DispatcherPieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $load = new Incident();
        $query = $load->where('dispatcher_id', auth()->id());

        return Chartisan::build()
            ->labels(['Dispatched', 'Resolved', 'Unresolved', 'Pending'])
            ->dataset('Cases Occurrences', [
                $query->whereIn("status", ['dispatched', 'resolved', 'responders_handling'])->count(),
                $query->where("status", 'resolved')->count(),
                $query->whereNotIn("status", ['resolved'])->count(),
                $query->where("status", "dispatch_handling")->count()
            ]);
    }
}
