<?php

namespace App\Console\Commands;

use App\Services\InserBranchData;
use Illuminate\Console\Command;

class BranchInsertDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Branch Data';

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
        $startTime = now();
        $this->comment('Processing');
        $insertObject = new InserBranchData();
        $insertObject->handle();
        $this->info('Successfully updated Branch Data');
        $time = $startTime->floatDiffInSeconds(now());
        $this->comment("Processed in " . round($time, 3) . " seconds");
    }
}
