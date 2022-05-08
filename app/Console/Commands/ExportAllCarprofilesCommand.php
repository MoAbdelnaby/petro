<?php

namespace App\Console\Commands;

use App\Exports\AllPlatesExcelExport;
use App\Models\Carprofile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Excel;
class ExportAllCarprofilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carprofiles:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $this->comment('Processing');
            $start = date('Y-m-d h:i:s', strtotime('2022-03-1' . ' 00:00:00'));
            $end = date('Y-m-d h:i:s', strtotime('2022-03-20'. ' 00:00:00'));
            try{
                $query = Carprofile::
                    join('branches', 'branches.id', '=', 'carprofiles.branch_id')
                    ->select('carprofiles.*','branches.code as branch_code','branches.name as branch_name')
                    ->where('plate_status', 'success')
                    ->whereNotNull('invoice')
                    ->where('status', 'completed')
                    ->orderBy('branch_id');

                if ($start) {
                    $query = $query->whereDate('carprofiles.checkInDate', '>=', $start);
                }

                if ($end) {
                    $query = $query->whereDate('carprofiles.checkInDate', '<=', $end);
                }

                $result = [];
                $query->chunk(500, function ($plates) use (&$result) {
                    $result = array_merge($result, $plates->toArray());
                });

            }catch (\Exception $e) {
                $this->comment($e->getMessage());
            }


            $path = "alldata/plates";

            if (!is_dir(storage_path("/app/public/".$path))) {
                \File::makeDirectory(storage_path("/app/public/".$path), 0777, true, true);
            }

            $file_path = $path . '/' . '1-3-2020 to 20-2020.xls';

            $check = false;
            $check = Excel::store(new AllPlatesExcelExport($result), 'public/' . $file_path);

            $this->comment('finish');

            return true;

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
        return true;
    }
}
