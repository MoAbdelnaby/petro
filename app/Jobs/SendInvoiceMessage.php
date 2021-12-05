<?php

namespace App\Jobs;

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

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
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

            $plate_en = implode(' ',str_split($invoice->PlateNumber));

            $carprofile = Carprofile::where('plate_status', 'success')
                ->where('plate_en', $plate_en)
                ->whereDate('created_at', Carbon::today())
                ->latest()->first();
            if ($carprofile) {
                $path = "/invoices/" . $carprofile->branch_id . "/" . $carprofile->created_at->format('Y') . "/" . $carprofile->created_at->format('M') . "/" . $carprofile->created_at->format('d') . "/";
            } else {
                $path = "/invoices/nobranch/" . $invoice->created_at->format('Y') . "/" . $invoice->created_at->format('M') . "/" . $invoice->created_at->format('d') . "/";
            }
            $base64data = base64_decode($file, true);
            $filename = 'invoice' . time() . '.pdf';
            $filepath = $path . $filename;
            Storage::disk('azure')->put($filepath, $base64data);
            $azurepath = config('app.azure_storage') . config('app.azure_container') . "/storage" . $filepath;
            $invoice->update([
                'storage' => 'azure'
            ]);

            $whatsapp = Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
                'template_id' => '1',
                'phone' => 'whatsapp:+' . $phone,
                'invoice' => $azurepath,
                'distance' => $invoice->distance
            ]);

            if ($whatsapp['success'] === false) {
                MessageLog::create([
                    'PlateNumber' => $PlateNumber,
                    'type' => 'invoice',
                    'message' => str_replace(['{{1}}', '{{2}}'], $invoice->distance, NOTIFY),
                    'phone' => $phone,
                    'branch_id' => $carprofile->branch_id ?? null,
                    'invoiceUrl' => $filepath,
                    'status' => 'failed',
                    'error_reason' => 'twillo error'
                ]);
            }

            MessageLog::create([
                'PlateNumber' => $PlateNumber,
                'type' => 'invoice',
                'message' => str_replace(['{{1}}', '{{2}}'], $invoice->distance, NOTIFY),
                'phone' => $phone,
                'branch_id' => $carprofile->branch_id ?? null,
                'invoiceUrl' => $filepath
            ]);

            if ($carprofile) {
                $carprofile->update([
                    'invoice' => Carbon::now()
                ]);
            }


        }


    }
}
