<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsletterController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all newsletters';

    protected $newsletterController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NewsletterController $newsletterController)
    {
        parent::__construct();
        $this->newsletterController = $newsletterController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d H:i:s');
        Log::info("Send Newsletter {$date}");
        $this->newsletterController->sendMail();
    }
}
