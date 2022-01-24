<?php

namespace App\Console\Commands;

use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\Carprofile;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use App\Services\AreaDurationDaily;
use App\Services\AreaDurationTotal;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleOldCheckoutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle Old Checkout Max 2 Hour';

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
            $startTime = now();
            $this->comment('Processing');

            Carprofile::where('status', 'completed')->chunk(500, function ($profiles) {
                foreach ($profiles as $record) {
                    $start = \Carbon\Carbon::parse($record->checkInDate);
                    $end = Carbon::parse($record->checkOutDate);
                    if ($end->diffInMinutes($start) > 120) {
                        $record->checkOutDate = $start->addMinutes(30);
                        $record->save();
                    }
                }
            });

            $this->info('Successfully update Checkout');
            $time = $startTime->floatDiffInSeconds(now());
            $this->comment("Processed in " . round($time, 3) . " seconds");

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }
}
