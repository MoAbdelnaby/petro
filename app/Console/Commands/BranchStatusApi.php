<?php

namespace App\Console\Commands;

use App\BranchStatus;
use App\Mail\mailUserBranch;
use App\Models\Branch;
use App\Models\BranchSetting;
use App\Notifications\branchConnectionNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mail;

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
     * @return array
     */
    public function handle(): array
    {
        $res = [];
        $data = [];
        $minutes = 0;

        $now = Carbon::now();
        $branches = DB::table("last_error_branch_views as branchError")
            ->join("branches as branch", "branchError.branch_code", "=", "branch.code")
            ->select("branch.id as br_id", "branch.name as name", "branchError.*")
            ->get();

        //Check If Online Before 15 Min
        foreach ($branches as $branch) {
            $branchStatus = BranchStatus::where('branch_code', $branch->branch_code)->first();
            $data['last_connected'] = $now->diffForHumans($branch->created_at, true);

            if ($now->subMinutes() < $branch->created_at) {
                $data['status'] = 'online';
                $data['last_error'] = $branch->error;
            } else {
                $data['status'] = 'offline';
                $data['last_error'] = null;

//                $current = Branch::with('users')->find($branch->br_id);
//                $users = $current->users;
//                if (count($users) > 0) {
//                    $this->sendErrotToAdmin($branch, $data,$users);
//                }
            }

            $data['branch_code'] = $branch->branch_code;
            $data['branch_name'] = $branch->name;

            if ($branchStatus) {
                $res[] = $branchStatus->update($data);
            } else {
                $res[] = BranchStatus::create($data);
            }
        }

        return $res;
    }

    /**
     * @param $branch
     * @param $data
     * @param $users
     */
    protected function sendErrotToAdmin($branch, $data, $users): void
    {
        $now = now();
        $branchSetting = BranchSetting::find(1);
        if ($branchSetting->type == 'hours') {
            $minutes = $branchSetting->duration * 60;
        } else {
            $minutes = $branchSetting->duration;
        }

        if ($now->subMinute($minutes) > $branch->created_at) {
            foreach (User::where('type', 'customer')->get() as $admin) {
                $admin->notify(new branchConnectionNotification($branch, $data, $minutes, 'schedule'));
            }
            foreach ($users as $key => $user) {
                Mail::to($user->email)->send(new mailUserBranch($branch));
                DB::table("last_error_branch_views")->when("branch_code", $branch->branch_code)->update(['sending', 1]);
            }
        }

    }
}
