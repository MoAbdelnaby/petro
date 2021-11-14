<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapFilterRequest;
use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\Region;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MapController extends Controller
{
    public function index()
    {
        $regions = Region::where('user_id', parentID())->with(['branches' => function ($q) {
            return $q->where('user_id', parentID());
        }])->withCount(['branches' => function ($q) {
            return $q->where('user_id', parentID());
        }])->get();

        return view('customer.map.index', ['regions' => $regions]);
    }

    public function filter(MapFilterRequest $request)
    {

        switch ($request->table) {
            case 'branches':
                $data = Branch::with('region')->where('user_id', parentID())->where('name', 'like', '%' . $request->searchItem . '%')
                    ->orWhere('code', 'like', '%' . $request->searchItem . '%')->get();
                break;
            case 'regions':
                $data = Region::where('user_id', parentID())->where('name', 'like', '%' . $request->searchItem . '%')->get();
                break;
            case 'carprofiles':
                $search = trim($request->searchItem);
                if (strpos($search, ' ') !== false) {
                    $searchItem = $search;
                } else {
                    $searchItem = implode(' ', mb_str_split($search));
                }
                $data = Carprofile::where('plateNumber', 'like', '%' . $searchItem . '%')
                    ->orWhere('plate_ar', 'like', '%' . $searchItem . '%')
                    ->orWhere('plate_en', 'like', '%' . $searchItem . '%')->get();
                break;
        }

        if ($data) {
            return responseSuccess($data, 'data returned successfully');
        } else {
            return responseFail('No Data Found');
        }

    }

    public function MapPlatesfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_en' => 'required|string',
        ]);
        if ($validator->fails()) {
            return responseFail($validator->errors()->first());
        }
        $data = Carprofile::with('branch')->where('status', 'completed')->where('plate_en', $request->plate_en)->get();

        if ($data) {
            return responseSuccess($data, 'data returned successfully');
        } else {
            return responseFail('No Data Found');
        }

    }
}
