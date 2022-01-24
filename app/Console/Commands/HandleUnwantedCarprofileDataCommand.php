<?php

namespace App\Console\Commands;

use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use App\Services\AreaDurationTotal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleUnwantedCarprofileDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unwanted:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'handle unwanted data from carprofile before 8 - 4 - 2021 ';

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

            DB::table('area_duration_days')->where('date','<','2021-04-08')->delete();

            $this->info('Successfully update duration time in each area');
            $time = $start->floatDiffInSeconds(now());
            $this->comment("Processed in " . round($time, 3) . " seconds");


        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
