<?php

namespace App\Console\Commands;

use App\Models\AreaDuration;
use App\Models\AreaStatus;
use App\Models\BranchFiles;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use App\Services\AreaDurationTotal;
use App\Services\ExportBranchMessage;
use App\Services\ExportFileFactory;
use App\Services\ExportModelsFiles;
use App\Services\ExportPlacesFiles;
use App\Services\ExportPlatesFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExportModelsFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporting file by model type';

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

            $files = BranchFiles::where('status', 0)->whereNull('url')->get();

            $factory= new ExportFileFactory();

            foreach ($files as $file) {
                if($object = $factory->handle($file->model_type)){
                    $object->export($file);
                }
            }

            $this->info('Successfully Exported wating files');

            $time = $start->floatDiffInSeconds(now());

            $this->comment("Processed in " . round($time, 3) . " seconds");

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
