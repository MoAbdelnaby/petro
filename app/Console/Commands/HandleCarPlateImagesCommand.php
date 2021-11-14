<?php

namespace App\Console\Commands;

use App\Models\CarPLates;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HandleCarPlateImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carplate:images-handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove un wanted images from car plate table';

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
                $data = CarPLates::whereDate('created_at', \Carbon\Carbon::today()->subDay(1))->chunk(100,function ($plates){
                    foreach ($plates as $plate) {

                        $oldpath = storage_path("app/public" . $plate->screenshot);
                        if (\File::exists($oldpath)) {
                            // Log::info($oldpath);
                            \File::delete($oldpath);
                        }
                    }
                });



            }catch (\Exception $e){
                // Log::info($e->getMessage());
            }
    }
}
