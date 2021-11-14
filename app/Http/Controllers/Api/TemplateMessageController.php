<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Storage;

class TemplateMessageController extends Controller
{

    public function SendTemplateToUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'template_id' => 'required|string',
            'PlateNumber' => 'required|string',
            'distance' => 'required|string'
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $request->invoice)) {
                $validator->errors()->add('invoice', 'The file is not base64 !');
            }
        });

        if ($validator->errors()->count()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }
        $phone = phoneHandeler($request->phone);
        $PlateNumber = str_replace(' ', '', $request->PlateNumber);

        if ($request->invoice && $request->has('invoice')) {
            $file = $request->invoice;

            if (!empty($file)) {
                if (strpos($file, ',') !== false) {
                    @list($encode, $file) = explode(',', $file);
                }
                $base64data = base64_decode($file, true);

                $f = finfo_open();
                $mime_type = finfo_buffer($f, $base64data, FILEINFO_MIME_TYPE);

                if ($mime_type!= "application/pdf") {
                    return response()->json(['message' => 'Not a PDF File'], 400);
                }

                $filename =  'invoice' . time() . '.pdf';

                $filepath = 'invoices/' . $filename;

                if (!is_dir(storage_path("/app/public/invoices"))) {
                    \File::makeDirectory(storage_path("/app/public/invoices"), 777);
                }

                Storage::disk('public')->put($filepath, $base64data);

                $newpath = storage_path("/app/public/" . $filepath);



            }

            Customer::updateOrCreate([
                'PlateNumber' => $PlateNumber,
            ],
                [
                    'CustomerPhoneNumber' => 'whatsapp:+' . $phone,
                ]);

            Invoice::create([
                'PlateNumber' => $PlateNumber,
                'CustomerPhoneNumber' => 'whatsapp:+' . $phone,
                'invoice' => $filepath,
                'distance' => $request->distance
            ]);
        }

        try {

            if ($request->has('template_id') && $request->template_id == '1') {
                $invoice =   Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
                    'template_id' => '1',
                    'phone' => 'whatsapp:+' . $phone,
                    'invoice' => url('storage/'.$filepath),
                    'distance' => $request->distance
                ]);

                if($invoice['success'] === false ) {
                    return response()->json(['success'=>false,'message' => 'SomeThing went wrong !'], 500);
                }
            }

            return response()->json(['success'=>true,'message' => 'Message Sent Successfully'], 200);
        } catch (\Exception $exception){
            return response()->json(['success'=>false,'message' => $exception->getMessage()], 500);
        }

    }

}
