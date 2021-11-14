<?php

namespace App\Jobs;

use App\Models\Carprofile;
use App\Models\Customer;
use App\Models\FailedMessage;
use App\Services\CustomerPhone;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendWelcomeMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $plate;
    public $branch_id;
    public $rowid;


    public function __construct($plate, $branch_id, $rowid)
    {
        $this->plate = str_replace(' ', '', $plate);
        $this->branch_id = $branch_id;
        $this->rowid = $rowid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//        Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
//            'template_id' => '0',
//            'phone' => 'whatsapp:+201093565730',
//        ]);
        $contacts = (new CustomerPhone($this->plate))->handle();

//        Log::info('phone',$contacts);

        if (!empty($contacts)) {
            $contacts = array_unique($contacts);
            $sent = false;
            foreach ($contacts as $phone) {
                if (!is_null($phone)) {
                    $message = Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
                        'template_id' => '0',
                        'phone' => $phone,
                    ]);
                    if ($message['success'] === true) {
                        $sent = true;
                    }
                }
            }
            if ($sent === false) {
                FailedMessage::updateOrCreate([
                    'plateNumber' => $this->plate,
                    'carprofile_id' => $this->rowid
                ], [
                    'branch_id' => $this->branch_id,
                    'status' => 'twillo'
                ]);
            } else {
                $carprofile = Carprofile::find($this->rowid);
                if ($carprofile) {
                    $carprofile->update([
                        'welcome' => Carbon::now(),
                    ]);
                }
            }


        } else {
            FailedMessage::updateOrCreate([
                'plateNumber' => $this->plate,
                'carprofile_id' => $this->rowid
            ], [
                'branch_id' => $this->branch_id,
                'status' => 'noNumber'
            ]);
        }

    }
}
