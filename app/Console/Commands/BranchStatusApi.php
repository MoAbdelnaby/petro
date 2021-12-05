<?php

namespace App\Console\Commands;

use App\BranchNetWork;
use App\BranchStatus;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchStatusApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch-status-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'call back function every 15 min check on status of branches';

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
        $res = array();
        $data = array();
//        get last branches
        $now = Carbon::now();
        $branches = DB::table("last_error_branch_views as branchError")
            ->join("branches as branch","branchError.branch_code","=","branch.code")
            ->select("branch.id as id","branch.name as name","branchError.*")
            ->get();

        // check if online before 15 min
        foreach ($branches as $key => $branch) {
            $branchStatus =  BranchStatus::where('branch_code',$branch->branch_code)->first();
            if ( $now->subMinutes(15) < $branch->created_at) {
                $data['status'] = 'online';
                $data['last_error'] = $branch->error;
            } else {
                $data['status'] = 'offline';
                $data['last_error'] = null;
                $data['last_connected'] = $now->diffForHumans($branch->created_at,true);
            }
            $data['branch_code'] = $branch->branch_code;
            $data['branch_name'] = $branch->name;
            if ($branchStatus) {
                $res[] = $branchStatus->update($data);
            } else {
                $res[] = BranchStatus::create($data);
            }
//            if ($branchStatus)
//            else
//                $res[] = BranchStatus::create($data);
        }
        return $res;
    }
}
