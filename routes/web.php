<?php

use App\Services\InserBranchData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
 */

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('lang/{lang}', 'HomeController@select')->name('select');
Route::get('dark/{code}', 'HomeController@dark')->name('dark');
Route::post('user_settings/{col}', 'UserSettingsController@update')->name('user_settings');
Auth::routes();

Route::post('user/password/reset', 'Auth\UserController@resetPassword')->name('user_reset_password');

Route::group(['middleware' => ['auth', 'speed']], function () {
    Route::group(['middleware' => 'subCustomerCheck'], function () {
        Route::get('userNotify', 'HomeController@getNotify')->name('notfication');
        Route::group(['prefix' => 'api/map'], function () {
            Route::match(['get', 'post'], 'filter', 'Customer\MapController@filter')->name('map.filter');
            Route::post('plates_filter', 'Customer\MapController@MapPlatesfilter')->name('map.platesFilter');
        });

        Route::group(['prefix' => 'api/roles'], function () {
            Route::post('/permissions/{id}', 'Auth\RoleController@permissions')->name('roles.permissions');
            Route::get('/edit/item', 'Auth\RoleController@edit')->name('roles.edit');
            Route::post('/store', 'Auth\RoleController@store')->name('roles.store');
            Route::post('/update', 'Auth\RoleController@update')->name('roles.update');
        });

        Route::group(['prefix' => 'auth'], function () {
            Route::resource('users', 'Auth\UserController');
            Route::resource('roles', 'Auth\RoleController');
            Route::resource('permissions', 'Auth\PermissionController');
            Route::post('/users/updateprofile', 'Auth\UserController@updateprofile')->name('users.updateprofile');
            Route::post('/users/search', 'Auth\UserController@search')->name('users.search');
            Route::post('/roles/search', 'Auth\RoleController@search')->name('roles.search');
            Route::post('/packages/search', 'Saas\PackageController@search')->name('packages.search');
            Route::post('/models/search', 'Saas\ModelsController@search')->name('models.search');
            Route::post('/features/search', 'Saas\FeatureController@search')->name('features.search');
            Route::post('/permissions/search', 'Auth\PermissionController@search')->name('permissions.search');
            Route::get('/users/profile', 'Auth\UserController@profile')->name('users.profile');
            Route::get('/users/changepassword/{id}', 'Auth\UserController@changepassword')->name('users.changepassword');
            Route::post('/users/editchangepassword', 'Auth\UserController@editchangepassword')->name('users.editchangepassword');
        });

        Route::get('/website', function () {
            return view('settings.website.index');
        });

        Route::group(['prefix' => 'saas', 'namespace' => 'Saas'], function () {
            Route::resource('packages', 'PackageController');
            Route::resource('models', 'ModelsController');
            Route::resource('modelfeatures', 'ModelFeaturesController')->only(['index', 'show']);
            Route::resource('features', 'FeatureController')->only(['index']);
            Route::get('packages/assignuser/{id}', 'PackageController@assignuser')->name('packages.assignuser');
            Route::post('packages/assignuser/{id}/create', 'PackageController@assignuserpost')->name('packages.assignuserpost');
            Route::get('packages/items/{id}', 'PackageController@itemsindex')->name('packages.items');
            Route::get('packages/items/{id}/create', 'PackageController@itemscreate')->name('packages.createitem');
            Route::post('packages/items/{id}/create', 'PackageController@itemscreatepost')->name('packages.createitempost');
            Route::get('packages/items/{id}/edit', 'PackageController@itemsedit')->name('packages.edititem');
            Route::post('packages/items/{id}/edit', 'PackageController@itemseditpost')->name('packages.edititempost');
            Route::post('packages/items/modelfeatures', 'PackageController@modelfeatures')->name('packages.modelfeatures');
            Route::DELETE('packages/items/delete/{id}', 'PackageController@itemsdelete')->name('packages.deleteitem');
        });

        Route::group(['prefix' => 'customer', 'namespace' => 'Customer'], function () {
            Route::get('map', 'MapController@index')->name('map.index');
            Route::resource('customerUsers', 'UserController');
            Route::post('customerUsers/bulkRestore', 'UserController@restore')->name('customerUsers.bulkRestore');
            Route::post('customerUsers/bulkDelete', 'UserController@forceDelete')->name('customerUsers.bulkDelete');
            Route::get('activities', 'ActivityController@index')->name('activities.index');
            Route::get('config/{type}/get', 'ConfigController@index')->name('config.index');
            Route::post('config/update', 'ConfigController@update')->name('config.update');

           Route::get('error-mangment/{id}', 'ErrorManagementController@index')->name('error_mangment.index');
            Route::get('error-mangment/{id}/filter', 'ErrorManagementController@filter')->name('error_mangment.filter');
            Route::post('error-mangment/{id}/updatePlate', 'ErrorManagementController@updatePlate')->name('error_mangment.updatePlate');
            Route::resource('customerRegions', 'RegionController');
            Route::post('customerRegions/bulkRestore', 'RegionController@restore')->name('regions.bulkRestore');
            Route::post('customerRegions/bulkDelete', 'RegionController@forceDelete')->name('regions.bulkDelete');
            Route::get('customerRegions/change/{id}', 'RegionController@changeActive')->name('regions.change_active');
            Route::resource('customerPackages', 'CustomerPackagesController');
            Route::resource('branchmodels', 'BranchModelsController');
            Route::get('modelbranchpreview/{id}', 'BranchModelsController@preview')->name('modelbranchpreview');
            Route::get('allpackages', 'CustomerPackagesController@allpackages')->name('customerPackages.allpackages');
            Route::get('packageDetails/{package_id}', 'CustomerPackagesController@packageDetails')->name('customerPackages.packageDetails');
            Route::post('customerUsers/assignUser', 'UserController@assignUser')->name('customerUsers.assignUser');
            Route::post('customerUsers/assignUserToBranch', 'UserController@assignUserToBranch')->name('customerUsers.assignUserToBranch');
            Route::get('myModels', 'UserController@myModels')->name('myModels');

            Route::get('customerPackages/assignuser/{id}', 'CustomerPackagesController@assignuser')->name('customerPackages.assignuser');
            Route::post('customerPackages/assignuser/{id}/create', 'CustomerPackagesController@assignuserpost')->name('customerPackages.assignuserpost');
            Route::post('customerPackages/requestPackage', 'CustomerPackagesController@requestPackage')->name('customerPackages.requestPackage');

            //Branch Status Routes
            Route::get('branches-status', 'BranchStatusController@branchesStatus')->name('branches_status');
            Route::get('branches-log/{id}', 'BranchStatusController@getLogs');
            Route::get('branches-stability/{id}', 'BranchStatusController@getStability');
            Route::get('branches/not_linked/list', 'BranchStatusController@getNotLinked')->name('branches.not_linked');

            //Position Routes
            Route::resource('positions', 'PositionController');
            Route::post('positions/bulkRestore', 'PositionController@restore')->name('positions.bulkRestore');
            Route::post('positions/bulkDelete', 'PositionController@forceDelete')->name('positions.bulkDelete');

            //Escalations Routs
            Route::resource('escalations', 'EscalationController')->except('show');
            Route::put('escalations/branch-status/update', 'EscalationController@updateBranchStatus')->name('escalations.updateStatus');
        });

        Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
            Route::post('upload', 'MediaController@upload')->name('media.upload');
            Route::delete('destroy', 'MediaController@destroy')->name('media.destroy');
            Route::get('get', 'MediaController@get')->name('media.get');
        });

        Route::group(['prefix' => 'settings', 'namespace' => 'Setting'], function () {
            Route::resource('languages', 'LanguageController');
            Route::get('show', 'SettingController@index')->name('settings.index');
            Route::post('setting_save', 'SettingController@settingSave');
            Route::get('reminder', 'SettingController@getSetting')->name('setting.reminder');
            Route::post('reminder/post', 'SettingController@saveReminder')->name('setting.reminder_post');
            Route::post('mailTemplate', 'SettingController@saveMailTemplate')->name('setting.mailTemplate');
            Route::post('branch/mail', 'SettingController@branchmailSetting')->name('setting.branchmail');
            Route::post('mail', 'SettingController@mailSetting')->name('setting.mailsettings');
        });

        Route::post('connection-speed', 'Models\ConnectionSpeedController@store');
        Route::post('uploadSpeed', 'Models\ConnectionSpeedController@uploadSpeed');
        Route::resource('service', 'ServiceController');
        Route::get('connection-speed', 'Models\ConnectionSpeedController@index')->name('connection-speed.index');
        Route::get('branches/{branch}/connection-speeds', 'Models\ConnectionSpeedController@show')->name('branch.connection-speeds');
        Route::get('branches/message-log', 'Customer\BranchMessageController@index')->name('branch.message_log');
        Route::post('branches/export', 'Customer\BranchMessageController@export')->name('branch.export');
        Route::get('branches/message-exported', 'Customer\BranchMessageController@exportedFile')->name('branch.exported_file');

        Route::get('branches/backout-reasons', 'Customer\BackoutReasonController@index')->name('branch.backout_reasons');
        Route::post('branches/backout-reasons/export', 'Customer\BackoutReasonController@export')->name('branch.backout_reason_export');
        Route::get('branches/backout-reasons/exported', 'Customer\BackoutReasonController@exportedFile')->name('branch.backout_reason_exported');
    });

    Route::get('/customerhome', 'Customer\CustomerPackagesController@statistics')->name('CustomerHome');

    ///////////////////Sub-Customer Routes//////////
    Route::get('customer/branch/last-stability','Customer\BranchStatusController@lastStability')->name('branch.last_stability');

    Route::get('my-branches/status', 'Customer\BranchStatusController@UserbranchesStatus')->name('my_branches_status');
    Route::get('branch/filter/area', 'Models\PlacesController@get_branch_data')->name('branch.filter.area');
    Route::get('branch/plates/times', 'Models\PlatesController@get_branch_plate_times')->name('branch.plates.times');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'models/branch', 'namespace' => 'Models'], function () {
        Route::get('home/{branchid?}', 'BranchesController@index')->name('branchmodelpreview.index');
        Route::get('regions/{regionid}', 'BranchesController@show')->name('regionmodelpreview.index');
        Route::get('places/{branchid}/{usermodelbranchid}', 'BranchesController@places')->name('branchmodelpreview.places');
        Route::get('{branchid}/{usermodelbranchid}/files', 'BranchesFilesController@index')->name('branchmodelpreview.files.index');
        Route::get('files/{file}/download', 'BranchesFilesController@download')->name('branchmodelpreview.files.download');
        Route::delete('files/destroy/{file}', 'BranchesFilesController@destroy')->name('branchmodelpreview.files.destroy');
        Route::post('files/bulkRestore', 'BranchesFilesController@restore')->name('branchmodelpreview.files.bulkRestore');
        Route::post('files/bulkDelete', 'BranchesFilesController@forceDelete')->name('branchmodelpreview.files.bulkDelete');
        Route::get('placesfilter/{branchid}/{usermodelbranchid}', 'BranchesController@placesfilter')->name('branchmodelpreview.placesfilter');
        Route::post('placesshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@placesshiftSettingSave')->name('branchmodelpreview.placesshiftSettingSave');
        Route::get('plates/{branchid}/{usermodelbranchid}', 'BranchesController@plates')->name('branchmodelpreview.plates');
        Route::get('platesfilter/{branchid}/{usermodelbranchid}', 'BranchesController@platesfilter')->name('branchmodelpreview.platesfilter');
        Route::post('platesshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@platesshiftSettingSave')->name('branchmodelpreview.platesshiftSettingSave');
    });
    //placesmaintenance module
    Route::group(['prefix' => 'models/places', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'PlacesController@index')->name('places.index');
        Route::get('/filter/{usermodelbranchid}', 'PlacesController@placesfilter')->name('places.placesfilter');
        Route::post('{usermodelbranchid}/placesshiftSettingSave', 'PlacesController@placesshiftSettingSave')->name('places.placesshiftsetting');
    });
    //car plates module
    Route::group(['prefix' => 'models/plates', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'PlatesController@index')->name('plates.index');
        Route::get('/filter/{usermodelbranchid}', 'PlatesController@platesfilter')->name('plates.platesfilter');
        Route::post('/{carprofile}/putError', 'PlatesController@putError')->name('plates.putError');
        Route::post('/{type}/sendMessage', 'PlatesController@sendMessage')->name('plates.sendMessage');
        Route::post('{usermodelbranchid}/platesshiftSettingSave', 'PlatesController@platesshiftSettingSave')->name('plates.platesshiftsetting');
    });

    Route::group(['prefix' => 'customer', 'namespace' => 'Customer'], function () {
        Route::resource('customerBranches', 'CustomerBranchesController');
        Route::get('customerBranches/services/{id}', 'CustomerBranchesController@services')->name('customerBranches.services');
        Route::get('customerBranches/services/{id}/create', 'CustomerBranchesController@createServices')->name('customerBranches.services.create');
        Route::post('customerBranches/bulkRestore', 'CustomerBranchesController@restore')->name('branches.bulkRestore');
        Route::post('customerBranches/bulkDelete', 'CustomerBranchesController@forceDelete')->name('branches.bulkDelete');
        Route::get('customerBranches/change/{id}', 'CustomerBranchesController@changeActive')->name('branches.change_active');
        Route::get('myBranches', 'UserController@myBranches')->name('myBranches');
        Route::get('settings', 'UserController@UserSetting')->name('subcustomer.settings');
        Route::post('mailsettingUpdate', 'UserController@MailsettingUpdate')->name('user.MailsettingUpdate');

        //New
        Route::post('customerBranches/change-installed/{id}', 'CustomerBranchesController@changeInstalled')->name('branches.change_installed');

        //reports
        Route::get('reports', 'ReportController@index')->name('reports.index');
        Route::match(['get', 'post'], 'reports', 'ReportController@index')->name('reports.index');
        Route::get('reports/filter', 'ReportController@filter')->name('reports.filter');
        Route::get('report/region/{region}/show-branches', 'ReportController@getBranchByRegion');
        Route::get('report/city/{region}/show-regions', 'ReportController@getRegionByCity');
        Route::match(['get', 'post'],'reports/{type}/show', 'ReportController@show')->name('reports.show');
        Route::get('reports/{type}/download', 'ReportController@download')->name('report.download');
        Route::get('reports/download-statistics', 'ReportController@downloadStatistics')->name('report.downloadStatistics');
        Route::get('reports/{type}/export-files', 'ReportController@export')->name('reports.export');
    });

    Route::get('testmailsetting/{mail?}','HomeController@testMail');
});

Route::get('branches/register', 'Models\ConnectionSpeedController@registerBranch')->name('branch.register');


