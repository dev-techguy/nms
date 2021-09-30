<?php

namespace App\Http\Controllers\Watchers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Reports\WatcherCasesReport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $report = auth()->user()->load('report')->report;

        return view('watchers.reports.index', [
            'report' => $report
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function cases()
    {
        $report = new WatcherCasesReport;
        $report->run();

        return view('watchers.reports.cases', compact('report'));
    }


    public function casesPDF(Request $request)
    {
        /*$fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $sortBy = $request->input('sort_by');*/

        $title = $request->user()->name . ' Cases Report'; // Report title

        $meta = [ // For displaying filters description on header
            //'Registered on' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        $queryBuilder = Incident::select(['case_number', 'created_at', 'alert_mode', 'location', 'sub_county', 'alert_nature',
            'status']) // Do some querying..
        ->where('watcher_id', $request->user()->id)
            ->orderBy('id', 'desc');

        $columns = [ // Set Column to be displayed
            'Case ID' => 'case_number',
            'Date Received' => 'created_at',
            'Alert Mode', // if no column_name specified, this will automatically seach for snake_case of column name (will be alert_mode) column from query result
            'Location',
            'Sub County',
            'Alert Nature',
            'Status'
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Date Received', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function ($result) {
                    return $result->created_at->format('Y-m-d H:i:s');
                },
                'class' => 'left'
            ])
            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function casesExcel(Request $request)
    {
        /*$fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $sortBy = $request->input('sort_by');*/

        $title = $request->user()->name . ' Cases Report'; // Report title

        $meta = [ // For displaying filters description on header
            //'Registered on' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        $queryBuilder = Incident::select(['case_number', 'created_at', 'alert_mode', 'location', 'sub_county', 'alert_nature',
            'status']) // Do some querying..
        ->where('watcher_id', $request->user()->id)
            ->orderBy('id', 'desc');

        $columns = [ // Set Column to be displayed
            'Case ID' => 'case_number',
            'Date Received' => 'created_at',
            'Alert Mode', // if no column_name specified, this will automatically seach for snake_case of column name (will be alert_mode) column from query result
            'Location',
            'Sub County',
            'Alert Nature',
            'Status'
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return ExcelReport::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Date Received', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function ($result) {
                    return $result->created_at->format('Y-m-d H:i:s');
                },
                'class' => 'left'
            ])
            ->download($title); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

}
