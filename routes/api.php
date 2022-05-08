<?php

use App\Models\AreaDurationDay;
use App\Models\Carprofile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api', 'namespace' => 'Api', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
        Route::post('getSetting', 'ApiModelController@getSetting');
        Route::post('saveCarPlatesRecord', 'ApiModelController@saveCarPlatesRecord');
        Route::post('savePlaceRecord', 'ApiModelController@savePlaceRecord');

        Route::post('saveDoorRecord', 'ApiModelController@saveDoorRecord');
        Route::post('saveRecieptionRecord', 'ApiModelController@saveRecieptionRecord');
        Route::post('savePeopleRecord', 'ApiModelController@savePeopleRecord');
        Route::post('saveCarCountRecord', 'ApiModelController@saveCarCountRecord');
        Route::post('saveEmotionRecord', 'ApiModelController@saveEmotionRecord');
        Route::post('saveMaskRecord', 'ApiModelController@saveMaskRecord');
        Route::post('saveHeatMapRecord', 'ApiModelController@saveHeatMapRecord');
        Route::post('vehicles-log', 'ApiModelController@getVehicles');

        Route::get('bays/{station}', 'ApiModelController@getBusyBays');
        Route::post('send_template', 'TemplateMessageController@SendTemplateToUser');
        Route::post('BranchNetwork', 'ApiModelController@branchNetwork');
        Route::post('testLoad', 'ApiModelController@testServerLoad');
    });
});

Route::get('handle-pending-plates', function () {
    \Illuminate\Support\Facades\Artisan::call('profile:handle');
    \Illuminate\Support\Facades\Artisan::call('carplate:images-handle');
});

Route::get('export-files-models', function () {
    \Illuminate\Support\Facades\Artisan::call('files:export');
});

Route::get('branch-status-update', function () {
    \Illuminate\Support\Facades\Artisan::call('branch-status:update');
});

//Route::get('handle-carprofiles', function (){
//    \Illuminate\Support\Facades\Artisan::call('profile:handle');
//});

Route::get('welcome_message-work', function () {
    // every minute
    \Illuminate\Support\Facades\Artisan::call('welcome:send');
});

Route::get('reminder_message-work', function () {
    // every day
    \Illuminate\Support\Facades\Artisan::call('reminder:send');
});

Route::get('handle-duration-daily', function () {
    \Illuminate\Support\Facades\Artisan::call('area:duration-daily');
});

Route::get('handle-duration-daily-today', function () {
    \Illuminate\Support\Facades\Artisan::call('area:duration-daily today');
});

Route::get('handle-duration-total', function () {
    \Illuminate\Support\Facades\Artisan::call('area:duration');
});

Route::get('testcase', function () {
    $data = Carprofile::where('status', 'pending')
        ->where('plate_status', 'success')->whereNotNull('plate_en')->whereNull('welcome')->get();
    if (count($data) > 0) {
    }
});


//Route::get('jobs-run', function (){
//    \Illuminate\Support\Facades\Artisan::call('queue:work --tries=3 --stop-when-empty');
//});

Route::get('azure-images-upload', function () {
    \Illuminate\Support\Facades\Artisan::call('plate-images:upload');
    \Illuminate\Support\Facades\Artisan::call('place-images:upload');
});

//
//Route::get('restart-workers', function (){
//    \Illuminate\Support\Facades\Artisan::call('queue:restart');
//});

//Route::group(['prefix' => 'api/exports'], function () {
//    Route::post('heatmap_count', 'Models\DashController@topLowHeatmap');
//    Route::post('heatmap_rate', 'Models\DashController@HeatmapRate');
//});

Route::get('branch/{code}/status', 'Api\AreaStatusController@status');
Route::get('getphone', 'Api\AreaStatusController@handle');
Route::post('invoices/download', 'Api\TemplateMessageController@downloadInvoice');

Route::get('test', function () {
    $total = AreaDurationDay::
    select(['area', 'branch_id', DB::raw("SUM(empty_by_minute) as total_empty_by_minute"), DB::raw("SUM(work_by_minute) as total_work_by_minute")])
        ->groupBy(['branch_id', 'area'])
        ->get();
    dd($total);

});



