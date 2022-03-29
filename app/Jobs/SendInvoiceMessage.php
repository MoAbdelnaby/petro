<?php

namespace App\Jobs;

use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\InvoiceLog;
use App\Models\MessageLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use Illuminate\Support\Facades\Http;

class SendInvoiceMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $invoice_id;
    public $messageLog_id;

    public function __construct($invoice_id,$messageLog_id)
    {
        $this->invoice_id = $invoice_id;
        $this->messageLog_id = $messageLog_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = InvoiceLog::find($this->invoice_id);
        $file = $invoice->invoice;

        if (!empty($file)) {

            $branch = Branch::where('code', $invoice->branch_code)->first();
            if ($branch) {
                $path = "/invoices/" . $branch->id . "/" . $invoice->created_at->format('Y') . "/" . $invoice->created_at->format('M') . "/" . $invoice->created_at->format('d') . "/";
            } else {
                $path = "/invoices/nobranch/" . $invoice->created_at->format('Y') . "/" . $invoice->created_at->format('M') . "/" . $invoice->created_at->format('d') . "/";
            }

            $base64data = base64_decode($file, true);
            $filename = 'invoice' . time() . '.pdf';
            $filepath = $path . $filename;
            Storage::disk('azure')->put($filepath, $base64data);
            $azurepath = config('app.azure_storage') . config('app.azure_container') . $filepath;

            $whatsapp_url = $_ENV['WHATSAPP_TEMPLATE_URL'] ?? 'https://whatsapp-wakeb.azurewebsites.net/api/petro_template';
            $whatsapp = Http::post($whatsapp_url, [
                'template_id' => '1',
                'phone' => 'whatsapp:+' . $invoice->phone,
                'invoice' => $azurepath,
                'distance' => $invoice->distance
            ]);

            $plate_en = implode(' ',str_split($invoice->PlateNumber));
            $carprofile = Carprofile::where('plate_status', 'success')
                ->where('plate_en', $plate_en)
                ->where('branch_id', $branch->id)
                ->whereDate('created_at', Carbon::today())
                ->latest()->first();

             MessageLog::where('id',$this->messageLog_id)
            ->update(
                [
                    'carprofile_id' => $carprofile ? $carprofile->id : null,
                    'invoiceUrl' => $filepath,
                    'status' => $whatsapp['success'] === false ? 'failed':'sent',
                    'error_reason' => $whatsapp['success'] === false ? 'twillo error' : null
                ]
            );

//               MessageLog::updateOrCreate(
//                    [
//                        'PlateNumber' => $invoice->PlateNumber,
//                        'branch_id' => $branch->id,
//                        'created_at' => Carbon::today()->toDateString(),
//                    ],
//                    [
//                        'type' => 'invoice',
//                        'message' => str_replace(['{{1}}', '{{2}}'], $invoice->distance, NOTIFY),
//                        'phone' => $invoice->phone,
//                        'carprofile_id' => $carprofile ? $carprofile->id : null,
//                        'invoiceUrl' => $filepath,
//                        'status' => $whatsapp['success'] === false ? 'failed':'sent',
//                        'error_reason' => $whatsapp['success'] === false ? 'twillo error' : null
//                    ]
//                );


            if ($carprofile) {
                $carprofile->update([
                    'invoice' => Carbon::now()
                ]);
            }

            if (Storage::disk('azure')->exists($filepath))
            {
                $invoice->delete();
            }


        }


    }
}
