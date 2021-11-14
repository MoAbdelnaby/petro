<?php

namespace App\Console\Commands;
use App\Models\PlaceMaintenance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadPlaceImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'place-images:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Place Images to separated disk';

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
        // Log::info('hello');

        $results =  PlaceMaintenance::with('usermodelbranch.branch')->where('disk','local')->latest()->get();

        try {
            foreach($results as $res) {
                // Log::info(json_encode($res));
                $branch_id = $res->usermodelbranch->branch->id;
                $path =  "/places/". $branch_id."/".$res->created_at->format('Y')."/".$res->created_at->format('M') ."/". $res->created_at->format('d')."/";
                $filename =  basename($res->screenshot);
                $oldpath = storage_path("app/public".$res->screenshot);

                if (\File::exists($oldpath)) {

                    Storage::disk('azure')->putFileAs("/storage" . $path, $oldpath, $filename);
                    \File::delete($oldpath);

                    $res->update([
                        "disk" => "azure",
                        "screenshot" => $path . $filename
                    ]);
                }

            }


        }catch (\Exception $e) {
            // Log::info($e->getMessage());
        }

    }
}
