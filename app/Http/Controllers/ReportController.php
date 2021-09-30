<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Jobs\ReportGeneratingJob;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * create controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * generate report
     * @param ReportRequest $request
     * @return RedirectResponse
     */
    public function report(ReportRequest $request): RedirectResponse
    {
        $user = auth()->user()->load('report');

        // check if user has a report
        if (!$user->report) {
            // create a report here
            Report::query()->create([
                'user_id' => $user->id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'path_name' => 'shops-report-' . date('Y-m-d', strtotime($request->from_date)) . '-to-' . date('Y-m-d', strtotime($request->to_date)) . '-' . Str::slug(Str::lower(Str::random(6))) . '.xlsx',
            ]);
        } else {
            $user->report->update([
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'is_ready' => false
            ]);
        }

        // dispatch job generating
        dispatch(new ReportGeneratingJob(
            $user->id,
            $request->from_date,
            $request->to_date
        ))->onQueue('reports')->delay(0.1);

        return redirect()->back()->with('success', 'Report for ' . date('F d, Y h:i a', strtotime($request->from_date)) . ' to ' . date('F d, Y h:i a', strtotime($request->to_date)) . ' is being generated.');
    }
}
