<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderMessage;
use App\Jobs\SendWelcomeMessage;
use App\Models\Carprofile;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendReminderMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send reminder message';

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
            $reminder =  Reminder::first();
            if($reminder){

                $current = Carbon::now()->subDays($reminder->day);
                $query =  Carprofile::where('status','completed')
                    ->whereIn('plate_status', ['success','modified'])->whereNotNull('welcome')
                    ->whereDate('welcome', '>=', $current)
                    ->get();

                if(count($query) > 0) {
                    foreach ($query as $row) {
                        dispatch(new SendReminderMessage($row->plate_en,$row->id));
                    }
                }

            }


        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }
}
