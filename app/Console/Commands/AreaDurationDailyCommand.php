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
    protected $signature = 'area:duration-daily';

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

            if($_ENV['AREA_STATUS_FIRST_UPDATE']){
                $start = Carprofile::first();
                if ($start) {
                    $start = $start->checkInDate;
                    $begin = new \DateTime($start);
                    $end = new \DateTime();

                    $areaDurationService = new AreaDurationDaily();

                    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                        $areaDurationService->calculate($i->format("Y-m-d"));
                    }
                }
            }else{
                (new AreaDurationDaily())->calculate(Carbon::now()->subDays(1)->toDateString());
            }

            $this->info('Successfully update duration time in each area');
            $time = $startTime->floatDiffInSeconds(now());
            $this->comment("Processed in " . round($time, 3) . " seconds");

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }
}
