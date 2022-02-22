<?php

namespace App\Jobs;

use App\Mail\mailUserBranch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBranchStatusMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $branch_name;
    public $branch_code;
    public $minutes;
    public $email;
    public $name;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$minutes,$email,$name)
    {
        $this->branch_name = $data->name;
        $this->branch_code = $data->branch_code;
        $this->minutes = $minutes;
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
        $time = $this->minutes;
        $username = $this->name;
        Mail::to($this->email)->send(new mailUserBranch($branch_name ,$code,$time,$username));
    }
}
