<?php

namespace App\Console\Commands;

use App\BranchStatus;
use App\Jobs\SendBranchStatusMailJob;
use App\Models\BranchSetting;
use App\Models\CarPLatesSetting;
use App\Models\Escalation;
use App\Models\EscalationBranch;
use App\Models\PlaceMaintenanceSetting;
use App\Models\UserModelBranch;
use App\Notifications\BranchStatusNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BranchStatusApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch-status:update';

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
        $AiValue = 15;

        $now = Carbon::now();
        $branches = DB::table("last_error_branch_views as branchError")
            ->join("branches as branch", "branchError.branch_code", "=", "branch.code")
            ->select("branch.id as br_id", "branch.name as name", "branchError.*")
            ->get();

        //Check If Online Before 15 Min
        foreach ($branches as $branch) {
            $branchStatus = BranchStatus::where('branch_code', $branch->branch_code)->first();
            $data['last_connected'] = $now->diffForHumans($branch->created_at, true);

            if ($now->subMinutes($AiValue) < $branch->created_at) {
                $data['status'] = 'online';
                $data['last_error'] = $branch->error;

                DB::table('branches_users')
                    ->where('branch_id', $branch->br_id)
                    ->update(['notified' => '0']);

                EscalationBranch::where('branch_id', $branch->br_id)->update(['time_minute' => 0, 'status' => 0]);

            } else {
                $data['status'] = 'offline';
                $data['last_error'] = $branch->error;

                $escalations = Escalation::orderBy('sort')->get();
                foreach ($escalations as $escalation) {
                    $escalationBranch = EscalationBranch::where('escalation_id', $escalation->id)->where('branch_id', $branch->br_id)->first();
                    if ($escalationBranch) {
                        //check escalation notification to stop when action
                        if ($escalationBranch->noticed == true) {
                            break;
                        }
                        if ($escalationBranch->status == true) {
                            if (($escalationBranch->time_minute + $AiValue) < $escalation->time_minute) {
                                $escalationBranch->time_minute += $AiValue;
                                $escalationBranch->save();
                                break;
                            }
                        } else {
                            $escalationBranch->status = true;
                            $escalationBranch->save();
                            $users = User::where('position_id', $escalation->position_id)->get();
                            if (count($users) > 0) {
                                $this->sendErrorToAdmin($branch, $users, $escalationBranch->id);
                            }
                            break;
                        }
                    } else {
                        $escalationBranch = EscalationBranch::create([
                            'escalation_id' => $escalation->id,
                            'branch_id' => $branch->br_id,
                            'status' => true,
                        ]);

                        $users = User::where('position_id', $escalation->position_id)->get();
                        if (count($users) > 0) {
                            $this->sendErrorToAdmin($branch, $users, $escalationBranch->id);
                        }
                        break;
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
        }

        return $res;
    }

    /**
     * @param $branch
     * @param $users
     * @param $escalationBranchId
     */
    protected function sendErrorToAdmin($branch, $users, $escalationBranchId): void
    {
        try {
            $branchSetting = BranchSetting::find(1);
            if ($branchSetting->type == 'hours') {
                $minutes = $branchSetting->duration * 60;
            } else {
                $minutes = $branchSetting->duration;
            }
            $userModelBranch = UserModelBranch::where('branch_id', $branch->br_id)->first();

            if ($userModelBranch) {
                $branch_work = PlaceMaintenanceSetting::where('user_model_branch_id', $userModelBranch->id)->where('active', 1)->first();
                if (!$branch_work) {
                    $branch_work = CarPLatesSetting::where('user_model_branch_id', $userModelBranch->id)->where('active', 1)->first();
                }

                if ($branch_work) {
                    $now = Carbon::now();
                    $start = Carbon::parse($branch_work->start_time);
                    $end = Carbon::parse($branch_work->end_time);
                    if ($now < $end && $now > $start) {
//                        if ($now->subMinutes($minutes) > $branch->created_at) {
                        $this->comment('Start');
                        foreach ($users as $user) {
                            $check = DB::table('branches_users')
                                ->where('user_id', $user->id)
                                ->where('branch_id', $branch->br_id)
                                ->first();

//                            $this->comment($branch->br_id, $check);

                            if ($check && $check->notified == '0' && $user->mail_notify == 'on') {

                                try {
                                    dispatch(new SendBranchStatusMailJob($branch, $minutes, $user->email, $user->name));
                                    $user->notify(new BranchStatusNotification($branch, $escalationBranchId));
                                }catch (\Exception $e){
                                    $this->comment($e->getMessage());
                                }

                                $this->comment('Email Sent');

                                DB::table('branches_users')
                                    ->where('user_id', $user->id)
                                    ->where('branch_id', $branch->br_id)
                                    ->update(['notified' => '1']);

                            }
                        }
//                        }
                    }
                }
            }
        } catch (\Exception $e) {

        }
    }
}
