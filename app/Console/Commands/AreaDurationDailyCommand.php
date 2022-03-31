<?php

namespace App\Console\Commands;

use App\Models\Carprofile;
use App\Services\AreaDurationDaily;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AreaDurationDailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'area:duration-daily {day?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcluate area duration (work and minute) per minute daily';

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

            if($this->argument('day') == 'today'){
                $this->comment("today");
                (new AreaDurationDaily())->calculate(Carbon::now()->toDateString());
            } else{
                $this->comment("yesterday");
                (new AreaDurationDaily())->calculate(Carbon::now()->subDays(1)->toDateString());
            }
            $this->comment("finish");
            $this->comment('Successfully update duration time in each area');
            $time = $startTime->floatDiffInSeconds(now());
            $this->comment("Processed in " . round($time, 3) . " seconds");

        } catch (\Exception $e) {
//            Log::error($e->getMessage() . $e->getLine());
        }
    }
}
