<?php

namespace App\Jobs;

use App\Models\Carprofile;
use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendReminderMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $plate;
    public $rowid;

    public function __construct($plate, $rowid)
    {
        $this->plate = str_replace(' ', '', $plate);
        $this->rowid = $rowid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $customer = Invoice::where('PlateNumber', $this->plate)->latest()->first();
        $query = Carprofile::where('status', 'completed')
            ->whereIn('plate_status', ['success', 'modified'])->whereNotNull('welcome');

        $message = Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
            'template_id' => '2',
            'phone' => $customer->CustomerPhoneNumber,
            'distance' => $customer->distance,
        ]);

        if ($message['success'] === true) {
            $carprofile = Carprofile::find($this->rowid);
            if ($carprofile) {
                $carprofile->update([
                    'welcome' => Null,
                ]);
            }
        }


    }
}
