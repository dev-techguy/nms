<?php

namespace App\Http\Controllers\Dispatchers;

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
     * @return Application|Factory|View|Response
     */
    public function __invoke(Request $request): View|Factory|Response|Application
    {
        $user_id = $request->user()->id;

        $cases = Incident::query()
            ->where('dispatcher_id', $user_id)->orderBy('id', 'desc')
            ->get();
        $new_cases = Incident::query()
            ->whereNull('dispatcher_id')
            ->where("status", "submitted")
            ->orderBy('id', 'desc')
            ->get();

        //Stats
        //$monthFirst = date('Y-m-d', strtotime("first day of this month"));
        //$monthLast = date('Y-m-d', strtotime("last day of this month"));
        $monthFirst = date('Y-m-d', strtotime("yesterday"));
        $monthLast = date('Y-m-d', strtotime("today"));
        $stats['month_handled'] = $cases->whereBetween("created_at", [$monthFirst, $monthLast])->count();
        $stats['dispatched'] = $cases->whereIn("status", ['dispatched', 'resolved', 'responders_handling'])->count();
        $stats['pending'] = $cases->where("status", "dispatch_handling")->count();
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
        $data_new_cases = $new_cases->take(10);

        //$chunk->all();

        //dd($data);

        return view('dispatchers.dashboard', compact('stats', 'data', 'data_new_cases'));
    }
}
