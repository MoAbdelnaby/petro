<?php

namespace App\Jobs;

use App\Models\Carprofile;
use App\Models\FailedMessage;
use App\Models\MessageLog;
use App\Services\CustomerPhone;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

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

        $whatsapp_url = $_ENV['WHATSAPP_TEMPLATE_URL'] ?? 'https://whatsapp-wakeb.azurewebsites.net/api/petro_template';

        $carprofile = Carprofile::find($this->rowid);

        if (!empty($contacts)) {
            $contacts = array_unique($contacts);
            foreach ($contacts as $phone) {
                if (!is_null($phone)) {
                    $message = Http::post($whatsapp_url, [
                        'template_id' => '0',
                        'phone' => $phone,
                    ]);

                    if ($message['success'] === false) {
                        FailedMessage::updateOrCreate([
                            'plateNumber' => $this->plate,
                            'carprofile_id' => $this->rowid
                        ], [
                            'branch_id' => $this->branch_id,
                            'status' => 'twillo'
                        ]);
                        MessageLog::create([
                            'PlateNumber' => $this->plate,
                            'type' => 'welcome',
                            'branch_id' => $this->branch_id,
                            'message' => WELCOME,
                            'phone' => str_replace('whatsapp:+', '', $phone),
                            'status' => 'failed',
                            'error_reason' => 'Twillo Error'
                        ]);

                        if ($carprofile) {
                            $carprofile->increment('tries');
                        }

                    } else {
                        if ($carprofile) {
                            $carprofile->update([
                                'welcome' => Carbon::now(),
                            ]);
                        }

                        MessageLog::create([
                            'PlateNumber' => $this->plate,
                            'type' => 'welcome',
                            'message' => WELCOME,
                            'status' => 'sent',
                            'phone' => str_replace('whatsapp:+', '', $phone),
                            'branch_id' => $this->branch_id
                        ]);
                    }
                }
            }
        } else {
            if ($carprofile) {
                $carprofile->increment('tries');
            }

            FailedMessage::updateOrCreate([
                'plateNumber' => $this->plate,
                'carprofile_id' => $this->rowid
            ], [
                'branch_id' => $this->branch_id,
                'status' => 'noNumber'
            ]);

            MessageLog::create([
                'PlateNumber' => $this->plate,
                'type'=> 'welcome',
                'branch_id'=> $this->branch_id,
                'message'=> WELCOME,
                'status'=>'failed',
                'error_reason'=>'No Number'
            ]);
        }
    }
}
