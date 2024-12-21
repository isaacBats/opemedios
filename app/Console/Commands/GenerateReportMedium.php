<?php

namespace App\Console\Commands;

use App\Http\Controllers\ReportController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateReportMedium extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generatemedium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate report medium';

    protected $reportController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ReportController $reportController)
    {
        parent::__construct();
        $this->reportController = $reportController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d H:i:s');
        Log::info("Generate report medium {$date}");

        try{
            $this->reportController->generate_reports_bd('medium');
        } catch (Exception $e) {
            Log::info("Error al generar el reporte: {$e->getMessage()}");
        }
        return 0;
    }
}
