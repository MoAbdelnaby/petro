<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\CustomerRepo;
use App\Models\Config;
use App\Services\ConfigService;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{

    public function index($type)
    {
        return view("customer.config.{$type}", [
            'config' =>  ConfigService::get($type)
        ]);
    }

    public function update(Request $request)
    {
        if ($request->key == 'table') {
            $config = Config::updateOrCreate([
                'key' => $request->key,
                'view' => $request->view,
                'model_type' => $request->model_type,
                'user_id' => auth()->id(),
            ], [
                'value' => $request->value,
                'active' => $request->active
            ]);

        } else {
            $config = Config::updateOrCreate([
                'key' => $request->key,
                'value' => $request->value,
                'view' => $request->view,
                'model_type' => $request->model_type,
                'user_id' => auth()->id(),
            ], [
                'active' => (int)$request->active
            ]);
        }

        return response()->json('success', 200);

    }
}
