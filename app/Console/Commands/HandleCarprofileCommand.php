<?php

namespace App\Console\Commands;

use App\Models\AreaStatus;
use App\Models\Carprofile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HandleCarprofileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete semi-completed rows and complete pending rows ';

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
        DB::table('area_statuses')->update([
            'status' => 0
        ]);
        $pendings = Carprofile::whereIn('status',['pending','semi-completed'])->get();

        foreach ($pendings as $row) {
            if(!is_null($row->plate_en)){
                $row->update([
                    'checkOutDate' => Carbon::now('Asia/Riyadh'),
                    'status' => 'completed'
                ]);
            } else {
                $row->delete();
            }
        }

    }

}
