<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Incident;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class WatcherPieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $load = new Incident();
        $query = $load->where('watcher_id', auth()->id());

        return Chartisan::build()
            ->labels(['Submitted', 'Resolved', 'Unresolved', 'Draft'])
            ->dataset('Cases Occurrences', [
                $query->whereIn("status", ['submitted', 'dispatched', 'resolved', 'dispatch_handling', 'responders_handling'])->count(),
                $query->where("status", 'resolved')->count(),
                $query->whereNotIn("status", ['resolved'])->count(),
                $query->where("status", 'draft')->count()
            ]);
    }
}
