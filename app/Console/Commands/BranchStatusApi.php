<?php

namespace App\Console\Commands;

use App\BranchNetWork;
use App\BranchStatus;
use App\Mail\mailUserBranch;
use App\Models\Branch;
use App\Models\BranchSetting;
use App\Models\UserModelBranch;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $minutes = 0;
//        get last branches
        $now = Carbon::now();
        $branches = DB::table("last_error_branch_views as branchError")
            ->join("branches as branch","branchError.branch_code","=","branch.code")
            ->select("branch.id as br_id","branch.name as name","branchError.*")
            ->get();

        // check if online before 15 min
        foreach ($branches as $key => $branch) {
            $branchStatus =  BranchStatus::where('branch_code',$branch->branch_code)->first();
            if ( $now->subMinutes(1) < $branch->created_at) {
                $data['status'] = 'online';
                $data['last_error'] = $branch->error;
                $data['last_connected'] = $now->diffForHumans($branch->created_at,true);
            } else {
                $data['status'] = 'offline';
                $data['last_error'] = null;
                $data['last_connected'] = $now->diffForHumans($branch->created_at,true);

//                send mail for employees
                /*
                * get users email
                */
                /*user branch */
                $usersArr = array();
                // $users = DB::table("branches_users")
                //     ->join("users","branches_users.user_id","=","users.id")
                //     ->where("branches_users.branch_id","=",$branch->id)
                //     ->select("users.id as id","users.name","users.email")
                //     ->get();
                $current = Branch::with('users')->find($branch->br_id);
                $users=$current->users;
                if (count($users) > 0) {
                    /* setting of branch time */
                    $branchSetting = BranchSetting::find(1);
                    if ($branchSetting->type == 'hours') {
                        $minutes = $branchSetting->duration * 60;
                    } else {
                        $minutes = $branchSetting->duration;
                    }
                    if ( $now->subMinutes($minutes) < $branch->created_at && $branch->sending == 0) {
                        foreach ($users as $key => $user) {
                            $send = Mail::to($user->email)->send(new mailUserBranch($branch));
                            $updateBranchView = DB::table("last_error_branch_views")
                                ->when("branch_code",$branch->branch_code)
                                ->update(['sending',1]);
                        }
                    }
                }

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
