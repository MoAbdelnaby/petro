<?php

namespace App\Jobs;

use App\Mail\mailUserBranch;
use App\Mail\OnlineMailUserBranch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBranchOnlineMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $branch_name;
    public $branch_code;
    public $email;
    public $name;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$email,$name)
    {
        $this->branch_name = $data->name;
        $this->branch_code = $data->code;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $branch_name = $this->branch_name;
        $code = $this->branch_code;
        $username = $this->name;
        Mail::to($this->email)->send(new OnlineMailUserBranch($branch_name ,$code,$username));
    }
}
