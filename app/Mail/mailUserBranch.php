<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailUserBranch extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $branch_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->branch_name = $data->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $branch_name = $this->branch_name;
        return $this->view('mails.branchUserMail',compact('branch_name'));
    }
}
