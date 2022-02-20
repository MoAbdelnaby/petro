<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailUserBranch extends Mailable
{
    use  SerializesModels;

    public $branch_name;
    public $minutes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($branch_name,$time)
    {
        $this->branch_name = $branch_name;
        $this->minutes = $time;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $branch_name = $this->branch_name;
        $time = $this->minutes;
        return $this->view('mails.branchUserMail',compact('branch_name','time'));
    }
}
