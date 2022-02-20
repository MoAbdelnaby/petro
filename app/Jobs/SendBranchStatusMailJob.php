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
    public $minutes;
    public $email;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$minutes,$email)
    {
        $this->branch_name = $data->name;
        $this->minutes = $minutes;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $branch_name = $this->branch_name;
        $time = $this->minutes;
        Mail::to($this->email)->send(new mailUserBranch($branch_name ,$time));
    }
}
