<?php

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
|
 */

Route::get('testjob', 'HomeController@jobTest');

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('lang/{lang}', 'HomeController@select')->name('select');
Route::get('dark/{code}', 'HomeController@dark')->name('dark');
Route::post('user_settings/{col}', 'UserSettingsController@update')->name('user_settings');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/customerhome', 'Customer\CustomerPackagesController@statistics')->name('CustomerHome');

    Route::group(['prefix' => 'api/charts'], function () {
        Route::post('getTotalPeople', 'Models\DashController@getPeopleCount');
        Route::get('getFilterImage/{id}', 'Models\DashController@FilterImage');
        Route::post('getHeatMapData', 'Models\DashController@getPositionsData');
        Route::post('ignoreDisabledData', 'Models\DashController@heatmapDisabledRegion');
        Route::post('heatmapLowHigh', 'Models\DashController@getPositionsLowHigh');
    });
    Route::group(['prefix' => 'api/map'], function () {
        Route::post('filter', 'Customer\MapController@filter')->name('map.filter');
        Route::post('plates_filter', 'Customer\MapController@MapPlatesfilter')->name('map.platesFilter');
    });

    Route::group(['prefix' => 'api/roles'], function () {
        Route::post('/permissions/{id}', 'Auth\RoleController@permissions')->name('roles.permissions');
        Route::get('/edit/item', 'Auth\RoleController@edit')->name('roles.edit');
        Route::post('/store', 'Auth\RoleController@store')->name('roles.store');
        Route::post('/update', 'Auth\RoleController@update')->name('roles.update');
    });

    /**
     * Auth managements  for users ,roles and permissions
     * prefix auth
     */
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

    /**
     * Saas managements  for packages ,Features
     * prefix auth
     */
    Route::group(['prefix' => 'saas', 'namespace' => 'Saas'], function () {
        Route::resource('packages', 'PackageController');
        Route::resource('models', 'ModelsController');
        Route::resource('packageRequests', 'PackageRequestsController');
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
        Route::DELETE('packageRequests/items/delete/{id}', 'PackageRequestsController@itemsdelete')->name('packageRequests.deleteitem');
        Route::post('packageRequests/assignUser', 'PackageRequestsController@assignUser')->name('packageRequests.assignUser');

    });

    Route::group(['prefix' => 'customer', 'namespace' => 'Customer'], function () {
        Route::get('map', 'MapController@index')->name('map.index');
        Route::resource('customerUsers', 'UserController');
        Route::post('customerUsers/bulkRestore', 'UserController@restore')->name('customerUsers.bulkRestore');
        Route::post('customerUsers/bulkDelete', 'UserController@forceDelete')->name('customerUsers.bulkDelete');

        Route::resource('customerBranches', 'CustomerBranchesController');
        Route::get('customerBranches/services/{id}', 'CustomerBranchesController@services')->name('customerBranches.services');
        Route::get('customerBranches/services/{id}/create', 'CustomerBranchesController@createServices')->name('customerBranches.services.create');
        Route::post('customerBranches/bulkRestore', 'CustomerBranchesController@restore')->name('branches.bulkRestore');
        Route::post('customerBranches/bulkDelete', 'CustomerBranchesController@forceDelete')->name('branches.bulkDelete');
        Route::get('customerBranches/change/{id}', 'CustomerBranchesController@changeActive')->name('branches.change_active');
        Route::get('activities', 'ActivityController@index')->name('activities.index');

        Route::get('config/{type}/get', 'ConfigController@index')->name('config.index');
        Route::post('config/update', 'ConfigController@update')->name('config.update');

        Route::get('reports/{type}/get', 'ReportController@index')->name('reports.index');
        Route::get('reports/{type}/filter', 'ReportController@filter')->name('report.filter');
        Route::get('reports/{type}/download', 'ReportController@download')->name('report.download');

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
        Route::get('myBranches', 'UserController@myBranches')->name('myBranches');
        Route::get('branches-status','BranchModelsController@BranchesStatus')->name('branches_status');
        Route::get('branches-log/{id}','BranchModelsController@getLogs');
        Route::get('customerPackages/assignuser/{id}', 'CustomerPackagesController@assignuser')->name('customerPackages.assignuser');
        Route::post('customerPackages/assignuser/{id}/create', 'CustomerPackagesController@assignuserpost')->name('customerPackages.assignuserpost');
        Route::post('customerPackages/requestPackage', 'CustomerPackagesController@requestPackage')->name('customerPackages.requestPackage');

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
        Route::get('reminder', 'SettingController@getReminder')->name('setting.reminder');
        Route::post('reminder/post', 'SettingController@saveReminder')->name('setting.reminder_post');
    });

    //door module
    Route::group(['prefix' => 'models/door', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'DoorController@index')->name('door.index');
        Route::any('/filter/{usermodelbranchid}', 'DoorController@doorfilter')->name('door.doorfilter');
        Route::post('{usermodelbranchid}/doorshiftSettingSave', 'DoorController@doorshiftSettingSave')->name('door.doorshiftsetting');

    });
    //recieption module
    Route::group(['prefix' => 'models/recieption', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'RecieptionController@index')->name('recieption.index');
        Route::any('/filter/{usermodelbranchid}', 'RecieptionController@recieptionfilter')->name('recieption.recieptionfilter');
        Route::post('{usermodelbranchid}/recieptionshiftSettingSave', 'RecieptionController@recieptionshiftSettingSave')->name('recieption.recieptionshiftsetting');

    });

    //carcount module
    Route::group(['prefix' => 'models/car', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'CarCountController@index')->name('car.index');
        Route::any('/filter/{usermodelbranchid}', 'CarCountController@carfilter')->name('car.carfilter');
        Route::post('{usermodelbranchid}/carshiftSettingSave', 'CarCountController@carshiftSettingSave')->name('car.carshiftsetting');
    });

    //peoplecount module
    Route::group(['prefix' => 'models/people', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'PeopleCountController@index')->name('people.index');
        Route::any('/filter/{usermodelbranchid}', 'PeopleCountController@peoplefilter')->name('people.peoplefilter');
        Route::post('{usermodelbranchid}/peopleshiftSettingSave', 'PeopleCountController@peopleshiftSettingSave')->name('people.peopleshiftsetting');

    });

    //heatmap module
    Route::group(['prefix' => 'models/heatmap', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}/{cameraid?}', 'HeatMapController@index')->name('heatmap.index');
        Route::get('heatmapHistory/{usermodelbranchid}/{cameraid?}', 'HeatMapController@viewHistory')->name('heatmap.history');

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

    //Mask module
    Route::group(['prefix' => 'models/mask', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'MaskController@index')->name('mask.index');
        Route::any('/filter/{usermodelbranchid}', 'MaskController@maskfilter')->name('mask.maskfilter');
        Route::post('{usermodelbranchid}/maskshiftSettingSave', 'MaskController@maskshiftSettingSave')->name('mask.maskshiftsetting');

    });

    //Emotion module
    Route::group(['prefix' => 'models/emotion', 'namespace' => 'Models'], function () {
        Route::get('home/{usermodelbranchid}', 'EmotionController@index')->name('emotion.index');
        Route::any('/filter/{usermodelbranchid}', 'EmotionController@emotionfilter')->name('emotion.emotionfilter');
        Route::post('{usermodelbranchid}/emotionshiftSettingSave', 'EmotionController@emotionshiftSettingSave')->name('emotion.emotionshiftsetting');

    });
    //branch show
    Route::group(['prefix' => 'models/branch', 'namespace' => 'Models'], function () {
        Route::get('home/{branchid?}', 'BranchesController@index')->name('branchmodelpreview.index');
        Route::get('regions/{regionid}', 'BranchesController@show')->name('regionmodelpreview.index');
        Route::get('door/{branchid}/{usermodelbranchid}', 'BranchesController@door')->name('branchmodelpreview.door');
        Route::any('doorfilter/{branchid}/{usermodelbranchid}', 'BranchesController@doorfilter')->name('branchmodelpreview.doorfilter');
        Route::post('doorshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@doorshiftSettingSave')->name('branchmodelpreview.doorshiftSettingSave');
        Route::get('recieption/{branchid}/{usermodelbranchid}', 'BranchesController@recieption')->name('branchmodelpreview.recieption');
        Route::any('recieptionfilter/{branchid}/{usermodelbranchid}', 'BranchesController@recieptionfilter')->name('branchmodelpreview.recieptionfilter');
        Route::post('recieptionshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@recieptionshiftSettingSave')->name('branchmodelpreview.recieptionshiftSettingSave');
        Route::get('car/{branchid}/{usermodelbranchid}', 'BranchesController@car')->name('branchmodelpreview.car');
        Route::any('carfilter/{branchid}/{usermodelbranchid}', 'BranchesController@carfilter')->name('branchmodelpreview.carfilter');
        Route::post('carshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@carshiftSettingSave')->name('branchmodelpreview.carshiftSettingSave');
        Route::get('people/{branchid}/{usermodelbranchid}', 'BranchesController@people')->name('branchmodelpreview.people');
        Route::any('peoplefilter/{branchid}/{usermodelbranchid}', 'BranchesController@peoplefilter')->name('branchmodelpreview.peoplefilter');
        Route::post('peopleshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@peopleshiftSettingSave')->name('branchmodelpreview.peopleshiftSettingSave');
        Route::get('heatmap/{branchid}/{usermodelbranchid}/{cameraid?}', 'BranchesController@heatmap')->name('branchmodelpreview.heatmap');
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
        Route::get('mask/{branchid}/{usermodelbranchid}', 'BranchesController@mask')->name('branchmodelpreview.mask');
        Route::any('maskfilter/{branchid}/{usermodelbranchid}', 'BranchesController@maskfilter')->name('branchmodelpreview.maskfilter');
        Route::post('maskshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@maskshiftSettingSave')->name('branchmodelpreview.maskshiftSettingSave');
        Route::get('emotion/{branchid}/{usermodelbranchid}', 'BranchesController@emotion')->name('branchmodelpreview.emotion');
        Route::any('emotionfilter/{branchid}/{usermodelbranchid}', 'BranchesController@emotionfilter')->name('branchmodelpreview.emotionfilter');
        Route::post('emotionshiftSettingSave/{branchid}/{usermodelbranchid}', 'BranchesController@emotionshiftSettingSave')->name('branchmodelpreview.emotionshiftSettingSave');

    });
    Route::post('connection-speed', 'Models\ConnectionSpeedController@store');
    Route::resource('service', 'ServiceController');
    Route::get('connection-speed', 'Models\ConnectionSpeedController@index')->name('connection-speed.index');
    Route::get('branches/{branch}/connection-speeds', 'Models\ConnectionSpeedController@show')->name('branch.connection-speeds');
    Route::get('branches/register', 'Models\ConnectionSpeedController@registerBranch')->name('branch.register');
});
