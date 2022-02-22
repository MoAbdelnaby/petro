<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailUserBranch extends Mailable
{
    use  SerializesModels;

    public $branch_name;
    public $minutes;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($branch_name,$code,$time)
    {
        $this->branch_name = $branch_name;
        $this->code = $code;
        $this->minutes = $time;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result =  MailTemplate::where('key', 'branchError')->value('value');
        $content = str_replace([
            '[[branch]]',
            '[[code]]',
            '[[downtime]]'
        ], [
            $this->code,
            $this->minutes,
            $this->branch_name,
        ], $result);

        return $this->view('mails.mailtemplate',compact('content'));
    }
}
