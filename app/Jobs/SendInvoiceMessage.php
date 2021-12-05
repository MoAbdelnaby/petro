<?php

namespace App\Jobs;

use App\Models\Carprofile;
use App\Models\InvoiceLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class SendInvoiceMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $invoice_id;
    public function __construct($invoice_id)
    {
        $this->invoice_id=$invoice_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = InvoiceLog::find($this->invoice_id);

        $phone = phoneHandeler($invoice->phone);
        $PlateNumber = str_replace(' ', '', $invoice->PlateNumber);
        $file = $invoice->invoice;

            if (!empty($file)) {

                $carprofile = Carprofile::where('plate_status', 'success')->whereNotNull('plate_en')->whereDate('created_at', Carbon::today())->latest()->first();
                if($carprofile){
                    $path =  "/invoices/". $carprofile->branch_id."/".$carprofile->created_at->format('Y')."/".$carprofile->created_at->format('M') ."/". $carprofile->created_at->format('d')."/";

                }else{
                    $path =  "/invoices/nobranch/".$carprofile->created_at->format('Y')."/".$carprofile->created_at->format('M') ."/". $carprofile->created_at->format('d')."/";
                }
                $base64data = base64_decode($file, true);
                $filename =  'invoice' . time() . '.pdf';
                $filepath = $path.$filename;
                Storage::disk('azure')->put($filepath, $base64data);


//                if($carprofile) {
//                    $carprofile->update([
//                        "invoice" => Carbon::now(),
//                        "screenshot" => $path . $filename
//                    ]);
//                }

            }




    }
}
