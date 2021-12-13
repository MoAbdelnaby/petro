<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeMessage;
use App\Models\Carprofile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWelcomeMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Welcome Message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $data = Carprofile::where('status', 'pending')
                ->where('plate_status', 'success')
                ->whereNotNull('plate_en')
                ->whereIn('tries',[0,1,2])
                ->whereNull('welcome')->get();
            if (count($data) > 0) {
                foreach ($data as $row) {
                    dispatch(new SendWelcomeMessage($row->plate_en, $row->branch_id, $row->id));
                }
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }
}
