<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\BranchSetting;
use App\Models\MailTemplate;
use App\Models\Reminder;
use App\Setting;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Arr;
use Validator;
class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-settings|edit-settings|delete-settings|create-settings', ['only' => ['index', 'settingSave']]);
        $this->middleware('permission:create-settings', ['only' => ['store']]);
        $this->middleware('permission:edit-settings', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-settings', ['only' => ['destroy', 'delete_all']]);
    }

    public function index()
    {
        return view('settings.website.index');
    }

    public function settingSave(Request $request)
    {
        if (setting()) {
            $logoPath = setting()->logo;
            $iconPath = setting()->icon;
        }

        // check if user upload icon
        if ($request->hasFile('icon')) {
            if (setting()->icon)
                unlink('media/settings/' . setting()->icon); // unlink old icon
            $iconPath = uploadImage('media', $request->icon, 'settings');

        }
        // chick if user upload logo
        if ($request->hasFile('logo')) {
            if (setting()->logo)
                unlink('media/settings/' . setting()->logo); // unlink old logo
            $logoPath = uploadImage('media', $request->logo, 'settings');
        }

        //  Create new setting element if not exist else update it
        Setting::updateOrCreate(
            [
                'primary_id' => primaryID()
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'whats_num' => $request->whats_num,
                'contact_phone' => $request->contact_phone,
                'country' => $request->country,
                'fb_link' => $request->fb_link,
                'address' => $request->address,
                'tw_link' => $request->tw_link,
                'in_link' => $request->in_link,
                'insta_link' => $request->insta_link,
                'website_link' => $request->website_link,
                'lang_id' => $request->lang_id,
                'icon' => $iconPath,
                'logo' => $logoPath,
                'user_id' => auth()->id()
            ]);

        session()->put('success', __('app.settings.success_message'));
        return response()->json(['message' => __('app.settings.success_message')], '200');
    }

    public function getSetting()
    {
        $reminder = Reminder::latest()->first();
        $mailtemplate =  MailTemplate::where('key', 'branchError')->value('value');
        $mail = [
            'driver'=> config('mail.default'),
            'host'=> config('mail.mailers.smtp.host'),
            'port'=> config('mail.mailers.smtp.port'),
            'encryption'=> config('mail.mailers.smtp.encryption'),
            'username'=> config('mail.mailers.smtp.username'),
            'password'=> config('mail.mailers.smtp.password'),
        ];
        return view('settings.reminder',['reminder' => $reminder,'mail'=>$mail,'mailtemplate'=>$mailtemplate]);
    }

    public function saveReminder(Request $request)
    {

        // pause to work

//        $request->validate(['day' => 'required|numeric']);
//
//        Reminder::updateOrCreate(['day' => $request->day]);
//
//        if ($request->branch_type) {
//            $branchSetting = BranchSetting::find(1);
//            $branchSetting->type = $request->branch_type;
//            $branchSetting->duration = $request->branch_duration;
//            $branchSetting->update();
//        }

        session()->flash('success', __('app.settings.success_message'));

        return redirect()->route('setting.reminder');
    }

    public function branchmailSetting(Request $request) {

        $validator = Validator::make($request->all(), [
            'branch_type' => 'required',
            'branch_duration' => 'required',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

            DB::table('branch_settings')->updateOrInsert([
                'id' => 1
            ],[
                'type'=>$request->branch_type,
                'duration'=>$request->branch_duration
            ]);

        session()->flash('success', __('app.settings.success_message'));

        return redirect()->route('setting.reminder');
    }

    public function mailSetting(Request $request) {

        $validator = Validator::make($request->all(), [
            'env' => 'required|array',
            'env.MAIL_MAILER' => 'required',
            'env.MAIL_HOST' => 'required',
            'env.MAIL_PORT' => 'required',
            'env.MAIL_USERNAME' => 'required',
            'env.MAIL_PASSWORD' => 'required',
            'env.MAIL_ENCRYPTION' => 'required',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = Arr::only($request->env,
            [
                'MAIL_MAILER',
                'MAIL_HOST',
                'MAIL_PORT',
                'MAIL_USERNAME',
                'MAIL_PASSWORD',
                'MAIL_ENCRYPTION'
            ]
        );
        foreach ($data as $key=>$value) {
            put_permanent_env($key,$value);
        }
        // TO Be Continue ...

        session()->flash('success', __('app.settings.success_message'));

        return redirect()->route('setting.reminder');
    }



    public function saveMailTemplate(Request $request) {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // write your code
        MailTemplate::updateOrCreate(
            ['key'=>$request->key],
            [
                'value'=>$request->value,
                'group'=>'mails',
            ]
        );

        session()->flash('success', __('app.settings.success_message'));
        return redirect()->route('setting.reminder');
    }

    public function testingUser(Request $request,$branchId) {
//        dd($branchId);
    }

}
