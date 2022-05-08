<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendInvoiceMessage;
use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\TemplateFileLog;
use App\Models\MessageLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateMessageController extends Controller
{

    public function SendTemplateToUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'template_id' => 'required|string',
            'PlateNumber' => 'required|string',
            'branch_code' => 'required|string',
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

        }
    }

        try {
            $phone = phoneHandeler($request->phone);
            $PlateNumber = str_replace(' ', '', $request->PlateNumber);
            $plate_en = implode(' ',str_split($request->PlateNumber));
            $branch = Branch::where('code', $request->branch_code)->first();
            $carprofile = Carprofile::where('plate_status', 'success')
                ->where('plate_en', $plate_en)
                ->where('branch_id', $branch->id)
                ->whereDate('created_at', Carbon::today())
                ->latest()->first();

          $message_log  =  MessageLog::create([
                'PlateNumber' => $PlateNumber,
                'type' => 'invoice',
                'message' => str_replace(['{{1}}', '{{2}}'], $request->distance, NOTIFY),
                'phone' => $phone,
                'branch_id' => $branch ? $branch->id : null,
                'carprofile_id' => $carprofile ? $carprofile->id : null,
                'status' => 'received',
            ]);


           $invoice = TemplateFileLog::create([
                'PlateNumber' => $PlateNumber,
                'invoice' => $request->invoice,
                'distance' => $request->distance,
                'branch_code' => $request->branch_code,
                'phone' => $phone,
                'template_id' => $request->template_id
            ]);
            dispatch(new SendInvoiceMessage($invoice->id,$message_log->id));

            return response()->json(['success'=>true,'message' => 'Message Sent Successfully'], 200);
        } catch (\Exception $exception){
            return response()->json(['success'=>false,'message' => $exception->getMessage()], 500);
        }

    }
    public function downloadInvoice(Request $request) {
        $validator = Validator::make($request->all(), [
            'plateNumber' => 'nullable|string',
            'carprofile_id' => 'required|string',
        ]);

        if ($validator->errors()->count()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        $data = MessageLog::where('carprofile_id',$request->carprofile_id)->first();
        if(!$data){
            return response()->json(['success'=>false,'message' => 'No invoice found'], 500);
        }

        $path = config('app.azure_storage') . config('app.azure_container') . $data->fileUrl;

        return response()->json(['invoice'=>$path,'name'=>basename($path),'rowid'=>$request->carprofile_id]);


    }
}
