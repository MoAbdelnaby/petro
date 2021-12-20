<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeMessage;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class HomeController extends Controller
{

    public function welcome()
    {
        return redirect()->route('login');
//            return view('home');
    }

    public function jobTest()
    {
        dispatch(new SendWelcomeMessage('2455JZJ'));
        dd('ok');

    }

    public function select($lang)
    {
        if (!in_array($lang, ['en', 'ar'])) {
            abort(400);
        }
        Session::put('lang', $lang);
        \App::setLocale(Session::get('lang', 'en'));
        return Redirect::back();
    }

    public function dark($code)
    {
        if (!in_array($code, ['on', 'off'])) {
            abort(400);
        }
        if ($code == 'on') {
            Session::put('darkMode', $code);
        } else {
            Session::forget('darkMode');
        }

        return Redirect::back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Auth::user()->type == "customer") {

            return \redirect()->route('CustomerHome');

        } elseif (Auth::user()->type == "subcustomer") {

            return \redirect()->route('myBranches');

        } else {
            return view('index');
        }
    }

    public function getNotify() {
        $notfications = \DB::table("notifications")->where("notifiable_id",Auth::id())->orderBy("created_at","DESC")->paginate(25);
        return view('notfication',compact('notfications'));
    }
}
