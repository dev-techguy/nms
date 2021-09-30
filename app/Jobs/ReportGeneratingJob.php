<?php

namespace App\Jobs;

use App\Exports\ReportExport;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;

class ReportGeneratingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // fetch user here
        $user = User::query()
            ->with(['report'])
            ->findOrFail($this->id);

        $report = $user->report;
        $fileName = $report->path_name;

        // start the checks
        if (Storage::disk('public')->exists($fileName)) {
            Storage::disk('public')->delete($fileName);
            Log::error('Removed existing file ' . $fileName);
        } else {
            Log::info('No file was removed.');
        }

        // set new name of the file
        $fileName = 'transactions-report-' . date('Y-m-d', strtotime($this->from_date)) . '-to-' . date('Y-m-d', strtotime($this->to_date)) . '-' . Str::slug(Str::lower(Str::random(8))) . '.xlsx';


        // generate report and store
        Excel::store(new ReportExport(
            $this->id,
            $this->from_date,
            $this->to_date
        ), $fileName, 'public', ExcelFormat::XLSX, [
            'visibility' => 'public'
        ]);

        // update the report here to is ready to true
        $report->update([
            'path_name' => $fileName,
            'path' => Storage::disk('public')->url($fileName),
            'is_ready' => true,
        ]);
    }
}
