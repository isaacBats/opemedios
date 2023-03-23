<?php

namespace App\Jobs;

use App\Exports\ReportsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @param array $data
     * @param string $fileName
     */
    public function __construct(array $data, string $fileName)
    {
        $this->data = $data;

        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::store(new ReportsExport($this->data), $this->fileName, 'public');
    }
}
