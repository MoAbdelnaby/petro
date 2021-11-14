<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\Customer;
use App\Services\CustomerPhone;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class AreaStatusController extends Controller
{
    public $plate='2931VJA';

    public function handle()
    {
        $contacts = (new CustomerPhone($this->plate))->handle();
        if (!empty($contacts)) {
            foreach ($contacts as $phone) {
                if (!is_null($phone)) {
                    Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template', [
                        'template_id' => '0',
                        'phone' => $phone,
                    ]);
                }
            }
        }

    }

    /**
     * @param Branch $branch
     * @return JsonResponse
     */
    public function status($code)
    {
        try {
            $branch = Branch::where('code',$code)->first();
            $data = AreaStatus::where('branch_id', $branch->id)
                ->select('area', 'status')
                ->groupBy('area')
                ->pluck('status', 'area')
                ->mapWithKeys(function ($item, $key) {
                    return ['Area ' . $key => ($item == 0) ? 'available' : ''];
                })->toArray();

            return response()->json([
                'success' => true,
                'areas' => array_filter($data),
                'count' => count(array_filter($data)),
                'message' => 'Area available get successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Unknown Error', 'info' => $e->getMessage()], 500);
        }

    }

}
