<?php

namespace App\Http\Controllers\Watchers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request): Application|Factory|View
    {
        $user_id = $request->user()->id;

        $cases = Incident::query()
            ->where('watcher_id', $user_id)
            ->latest()
            ->get();

        //Stats
        //$monthFirst = date('Y-m-d', strtotime("first day of this month"));
        //$monthLast = date('Y-m-d', strtotime("last day of this month"));
        $monthFirst = date('Y-m-d', strtotime("yesterday"));
        $monthLast = date('Y-m-d', strtotime("today"));
        $stats['month_new'] = $cases->whereBetween("created_at", [$monthFirst, $monthLast])->count();
        $stats['submitted'] = $cases->whereIn("status", ['submitted', 'dispatched', 'resolved', 'dispatch_handling', 'responders_handling'])->count();
        $stats['draft'] = $cases->where("status", 'draft')->count();
        $stats['total'] = $cases->count();
        $stats['month_resolved'] = $cases
            ->whereBetween("updated_at", [$monthFirst, $monthLast])
            ->where("status", 'resolved')
            ->count();
        $stats['month_unresolved'] = $cases
            ->whereBetween("updated_at", [$monthFirst, $monthLast])
            ->whereNotIn("status", ['resolved'])
            ->count();
        $stats['total_resolved'] = $cases
            ->where("status", 'resolved')
            ->count();
        $stats['total_unresolved'] = $cases
            ->whereNotIn("status", ['resolved'])
            ->count();

        $data = $cases->take(10);

        //$chunk->all();

        //dd($data);

        return view('watchers.dashboard', compact('stats', 'data'));
    }
}
