<?php

namespace App\Http\Controllers\Dispatchers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Reports\DispatcherCasesReport;
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
    public function index(): View|Factory|Application
    {
        $report = auth()->user()->load('report')->report;

        return view('dispatchers.reports.index', [
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
        $report = new DispatcherCasesReport;
        $report->run();

        return view('dispatchers.reports.cases', compact('report'));
    }


    public function casesPDF(Request $request)
    {
        /*$fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $sortBy = $request->input('sort_by');*/

        $title = 'All Cases Report'; // Report title

        $meta = [ // For displaying filters description on header
            //'Registered on' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        $queryBuilder = Incident::select(['case_number', 'created_at', 'alert_mode', 'location', 'sub_county', 'alert_nature',
            'status']) // Do some querying..
        ->where('status', '!=', 'draft')
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

        $title = 'All Cases Report'; // Report title

        $meta = [ // For displaying filters description on header
            //'Registered on' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        $queryBuilder = Incident::select(['case_number', 'created_at', 'chief_complaint', 'location',
            'location_lat', 'location_long', 'sub_county', 'alert_mode', 'channel', 'notifier_phone',
            'alert_nature', 'estate_health_facility', 'patient_name', 'patient_age',
            'patient_gender', 'patient_nhif_insurance_data', 'patient_contact',
            'patient_next_of_kin', 'status', 'mass_casualty_incident', 'watcher_comments',
            'facility_id', 'hospital_level', 'pre_hospital_management',
            'alternative_health_facility', 'dispatcher_challenges', 'dispatcher_comments']) // Do some querying..
        ->where('status', '!=', 'draft')
            ->orderBy('id', 'desc');

        $columns = [ // Set Column to be displayed
            'Case ID' => 'case_number',
            'Date Received' => 'created_at',
            'Chief Complaint', // if no column_name specified, this will automatically seach for snake_case of column name (will be alert_mode) column from query result
            'Location',
            'Sub County',
            'Alert Mode',
            'Channel',
            'Notifier Phone',
            'Alert Nature',
            'Estate Health Facility',
            'Patient Name',
            'Patient Age',
            'Patient Gender',
            'Patient Nhif Insurance_data',
            'Patient Contact',
            'Patient Next Of Kin',
            'Status',
            'Mass Casualty Incident',
            'Watcher Comments',
            'Hospital Level',
            'Pre Hospital Management',
            'Alternative Health Facility',
            'Dispatcher Challenges',
            'Dispatcher Comments',
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
