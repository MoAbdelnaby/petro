<?php

namespace App\Console\Commands;

use App\Models\AreaDuration;
use App\Models\AreaStatus;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use App\Services\AreaDurationTotal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaDurationTotalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'area:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcluate area duration (work and minute) by minute for all total areas';

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

            $start = now();
            $this->comment('Processing');

            (new AreaDurationTotal())->calculate();

//            Log::info('success');

            $this->info('Successfully update duration time in each area');
            $time = $start->floatDiffInSeconds(now());
            $this->comment("Processed in " . round($time, 3) . " seconds");


        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
