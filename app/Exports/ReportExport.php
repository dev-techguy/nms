<?php

namespace App\Exports;

use App\Models\Incident;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    /**
     * set data ro receive here
     * @param string $id
     * @param string|Date $from_date
     * @param string|Date $to_date
     */
    public function __construct(
        private string      $id,
        private string|Date $from_date,
        private string|Date $to_date
    )
    {
    }

    public function view(): View
    {
        return view('reports.general', [
            'reports' => Incident::query()
                ->latest()
                ->where(function ($query) {
                    $query->orWhere('watcher_id', $this->id)
                        ->orWhere('dispatcher_id', $this->id);
                })
                ->where('status', '!=', 'draft')
                ->whereDate('updated_at', '>=', date('Y-m-d', strtotime($this->from_date)))
                ->whereDate('updated_at', '<=', date('Y-m-d', strtotime($this->to_date)))
                ->get()
        ]);
    }
}
